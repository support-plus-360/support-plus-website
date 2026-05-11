<?php

namespace Webkul\Cms\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Webkul\Cms\Concerns\InteractsWithCmsMedia;
use Webkul\Cms\Models\Item;
use Webkul\Cms\Models\Link;
use Webkul\Cms\Models\Page;
use Webkul\Cms\Models\Section;
use Webkul\Cms\Repositories\ItemRepository;
use Webkul\Cms\Repositories\LinkRepository;
use Webkul\Cms\Repositories\SectionRepository;

class PageBuilderService
{
    use InteractsWithCmsMedia;

    public function __construct(
        protected SectionRepository $sectionRepository,
        protected ItemRepository $itemRepository,
        protected LinkRepository $linkRepository,
    ) {}

    /**
     * @param  array{
     *   sections?: array<int, array<string, mixed>>,
     *   prune_sections?: bool,
     *   page_links?: array<int, array<string, mixed>>,
     *   prune_page_links?: bool,
     * }  $structure
     */
    public function syncStructure(Page $page, array $structure, ?Request $request = null): void
    {
        DB::transaction(function () use ($page, $structure, $request): void {
            if (array_key_exists('page_links', $structure)) {
                $this->syncLinksForParent(
                    $page,
                    $structure['page_links'],
                    (bool) ($structure['prune_page_links'] ?? true)
                );
            }

            if (! array_key_exists('sections', $structure)) {
                return;
            }

            $sections = $structure['sections'];
            $pruneSections = (bool) ($structure['prune_sections'] ?? true);

            if ($pruneSections) {
                $keepIds = collect($sections)->pluck('id')->filter()->map(fn ($id) => (int) $id)->values()->all();
                $q = Section::query()->where('page_id', $page->id);
                if ($keepIds !== []) {
                    $q->whereNotIn('id', $keepIds);
                }
                $q->get()->each->delete();
            }

            foreach ($sections as $order => $sectionData) {
                if (! is_array($sectionData)) {
                    continue;
                }

                $section = $this->upsertSection($page, $sectionData, (int) $order);

                if ($request) {
                    $this->syncMainMediaFromPrefix($request, $section, 'sections.'.$order);
                }

                if (array_key_exists('links', $sectionData)) {
                    $this->syncLinksForParent(
                        $section,
                        is_array($sectionData['links']) ? $sectionData['links'] : [],
                        (bool) ($sectionData['prune_links'] ?? true)
                    );
                }

                if (array_key_exists('items', $sectionData)) {
                    $this->syncItems(
                        $page,
                        $section,
                        is_array($sectionData['items']) ? $sectionData['items'] : [],
                        (bool) ($sectionData['prune_items'] ?? true),
                        $request,
                        (int) $order
                    );
                }
            }
        });
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function upsertSection(Page $page, array $data, int $order): Section
    {
        $payload = $this->sanitizeSectionForRepo($data, $page, $order);

        if (! empty($data['id'])) {
            $section = Section::query()
                ->where('page_id', $page->id)
                ->where('id', (int) $data['id'])
                ->firstOrFail();

            $this->sectionRepository->update($payload, $section->id);

            return $section->fresh() ?? $section;
        }

        $payload['page_id'] = $page->id;

        return $this->sectionRepository->create($payload);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function sanitizeSectionForRepo(array $data, Page $page, int $order): array
    {
        $companyId = $data['company_id'] ?? $page->company_id;

        $translations = [];
        foreach (['en', 'ar'] as $locale) {
            $t = $data['translations'][$locale] ?? [];
            if (! is_array($t)) {
                $t = [];
            }
            $translations[$locale] = [
                'title'       => $t['title'] ?? '',
                'subtitle'    => $t['subtitle'] ?? null,
                'description' => $t['description'] ?? null,
                'locale'      => $locale,
            ];
        }

        $settings = $data['settings'] ?? null;
        if (is_string($settings)) {
            $decoded = json_decode($settings, true);
            $settings = json_last_error() === JSON_ERROR_NONE ? $decoded : null;
        }

        $layoutKeys = array_keys(config('cms.section_layouts.layouts', []));
        $defaultLayout = config('cms.section_layouts.default');
        if (! is_string($defaultLayout) || $defaultLayout === '' || ! in_array($defaultLayout, $layoutKeys, true)) {
            $defaultLayout = $layoutKeys[0] ?? 'home_hero';
        }

        $base = [
            'name'            => (string) ($data['name'] ?? ''),
            'section_layout'  => (string) ($data['section_layout'] ?? $defaultLayout),
            'settings'        => is_array($settings) ? $settings : null,
            'is_active'       => (bool) ($data['is_active'] ?? true),
            'order'           => isset($data['order']) ? (int) $data['order'] : $order,
            'company_id'      => $companyId !== null && $companyId !== '' ? (int) $companyId : null,
        ];

        return $base + $translations;
    }

    /**
     * @param  array<int, array<string, mixed>>  $items
     */
    protected function syncItems(Page $page, Section $section, array $items, bool $prune, ?Request $request = null, ?int $sectionIndex = null): void
    {
        if ($prune) {
            $keepIds = collect($items)->pluck('id')->filter()->map(fn ($id) => (int) $id)->values()->all();
            $q = Item::query()->where('section_id', $section->id);
            if ($keepIds !== []) {
                $q->whereNotIn('id', $keepIds);
            }
            $q->get()->each->delete();
        }

        foreach ($items as $order => $itemData) {
            if (! is_array($itemData)) {
                continue;
            }

            $item = $this->upsertItem($page, $section, $itemData, (int) $order);

            if ($request !== null && $sectionIndex !== null) {
                $this->syncMainMediaFromPrefix($request, $item, 'sections.'.$sectionIndex.'.items.'.$order);
            }

            if (array_key_exists('links', $itemData)) {
                $this->syncLinksForParent(
                    $item,
                    is_array($itemData['links']) ? $itemData['links'] : [],
                    (bool) ($itemData['prune_links'] ?? true)
                );
            }
        }
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function upsertItem(Page $page, Section $section, array $data, int $order): Item
    {
        $payload = $this->sanitizeItemForRepo($data, $page, $section, $order);

        if (! empty($data['id'])) {
            $item = Item::query()
                ->where('section_id', $section->id)
                ->where('id', (int) $data['id'])
                ->firstOrFail();

            $this->itemRepository->update($payload, $item->id);

            return $item->fresh() ?? $item;
        }

        $payload['section_id'] = $section->id;

        return $this->itemRepository->create($payload);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function sanitizeItemForRepo(array $data, Page $page, Section $section, int $order): array
    {
        $companyId = $data['company_id'] ?? $section->company_id ?? $page->company_id;

        $translations = [];
        foreach (['en', 'ar'] as $locale) {
            $t = $data['translations'][$locale] ?? [];
            if (! is_array($t)) {
                $t = [];
            }
            $translations[$locale] = [
                'title'     => $t['title'] ?? '',
                'sub_title' => $t['sub_title'] ?? null,
                'content'   => $t['content'] ?? null,
                'icon'      => $t['icon'] ?? null,
                'locale'    => $locale,
            ];
        }

        $settings = $data['settings'] ?? null;
        if (is_string($settings)) {
            $decoded = json_decode($settings, true);
            $settings = json_last_error() === JSON_ERROR_NONE ? $decoded : null;
        }

        $base = [
            'type'       => (string) ($data['type'] ?? 'default'),
            'settings'   => is_array($settings) ? $settings : null,
            'is_active'  => (bool) ($data['is_active'] ?? true),
            'order'      => isset($data['order']) ? (int) $data['order'] : $order,
            'company_id' => $companyId !== null && $companyId !== '' ? (int) $companyId : null,
        ];

        return $base + $translations;
    }

    /**
     * @param  array<int, array<string, mixed>>  $links
     */
    protected function syncLinksForParent(Page|Section|Item $parent, array $links, bool $prune): void
    {
        if ($prune) {
            $keepIds = collect($links)->pluck('id')->filter()->map(fn ($id) => (int) $id)->values()->all();
            $q = Link::query()
                ->where('linkable_type', $parent::class)
                ->where('linkable_id', $parent->id);

            if ($keepIds !== []) {
                $q->whereNotIn('id', $keepIds);
            }
            $q->get()->each->delete();
        }

        foreach ($links as $order => $linkData) {
            if (! is_array($linkData)) {
                continue;
            }

            $this->upsertLink($parent, $linkData, (int) $order);
        }
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function upsertLink(Page|Section|Item $parent, array $data, int $order): Link
    {
        $payload = $this->sanitizeLinkForRepo($data, $parent, $order);

        if (! empty($data['id'])) {
            $link = Link::query()
                ->where('linkable_type', $parent::class)
                ->where('linkable_id', $parent->id)
                ->where('id', (int) $data['id'])
                ->firstOrFail();

            $this->linkRepository->update($payload, $link->id);

            return $link->fresh() ?? $link;
        }

        $payload['linkable_type'] = $parent::class;
        $payload['linkable_id'] = $parent->id;

        return $this->linkRepository->create($payload);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function sanitizeLinkForRepo(array $data, Page|Section|Item $parent, int $order): array
    {
        $companyId = $data['company_id'] ?? null;
        if ($companyId === null && $parent instanceof Item) {
            $companyId = $parent->company_id;
        }
        if ($companyId === null && $parent instanceof Section) {
            $companyId = $parent->company_id;
        }
        if ($companyId === null && $parent instanceof Page) {
            $companyId = $parent->company_id;
        }

        $translations = [];
        foreach (['en', 'ar'] as $locale) {
            $t = $data['translations'][$locale] ?? [];
            if (! is_array($t)) {
                $t = [];
            }
            $translations[$locale] = [
                'name'   => $t['name'] ?? null,
                'locale' => $locale,
            ];
        }

        $name = $translations['en']['name'] ?? null;
        if ($name === null || $name === '') {
            foreach ($translations as $t) {
                if (! empty($t['name'])) {
                    $name = $t['name'];
                    break;
                }
            }
        }

        $base = [
            'name'       => $name,
            'link'       => (string) ($data['link'] ?? ''),
            'icon'       => $data['icon'] ?? null,
            'target'     => $data['target'] ?? '_self',
            'type'       => $data['type'] ?? null,
            'is_active'  => (bool) ($data['is_active'] ?? true),
            'order'      => isset($data['order']) ? (int) $data['order'] : $order,
            'company_id' => $companyId !== null && $companyId !== '' ? (int) $companyId : null,
        ];

        return $base + $translations;
    }
}
