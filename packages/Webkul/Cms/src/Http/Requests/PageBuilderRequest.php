<?php

namespace Webkul\Cms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Webkul\Cms\Models\Item;
use Webkul\Cms\Models\Link;
use Webkul\Cms\Models\Page;
use Webkul\Cms\Models\Section;

class PageBuilderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $pageId = $this->route('id');

        $linkTranslationRules = [
            'translations'                  => ['required', 'array'],
            'translations.en'               => ['required', 'array'],
            'translations.en.name'          => ['required', 'string', 'max:255'],
            'translations.ar'               => ['nullable', 'array'],
            'translations.ar.name'          => ['nullable', 'string', 'max:255'],
        ];

        $base = [
            'slug'         => [
                'required',
                'string',
                'max:255',
                Rule::unique('cms_pages', 'slug')->ignore($pageId),
            ],
            'name'         => ['required', 'string', 'max:255'],
            'is_active'    => ['nullable', 'boolean'],
            'order'        => ['nullable', 'integer', 'min:0'],
            'type'         => ['required', 'string', Rule::in(['page', 'service', 'case_study', 'industry'])],
            'status'       => ['required', 'string', Rule::in(['draft', 'published', 'archived'])],
            'published_at' => ['nullable', 'date'],
            'author_id'    => ['nullable', 'integer', 'exists:users,id'],
            'company_id'   => ['nullable', 'integer', 'exists:companies,id'],

            'translations'                    => ['required', 'array'],
            'translations.*.title'            => ['required', 'string', 'max:255'],
            'translations.*.meta_description' => ['nullable', 'string'],
            'translations.*.meta_keywords'    => ['nullable', 'string', 'max:255'],

            'sync_sections'     => ['nullable', 'boolean'],
            'sync_page_links'   => ['nullable', 'boolean'],
            'prune_sections'    => ['nullable', 'boolean'],
            'prune_page_links'  => ['nullable', 'boolean'],
        ];

        if ($this->boolean('sync_page_links')) {
            $base += [
                'page_links'              => ['nullable', 'array'],
                'page_links.*.id'         => ['nullable', 'integer', 'exists:cms_links,id'],
                'page_links.*.link'       => ['required', 'string', 'max:2048'],
                'page_links.*.icon'       => ['nullable', 'string', 'max:255'],
                'page_links.*.target'     => ['nullable', 'string', Rule::in(['_self', '_blank', '_parent', '_top'])],
                'page_links.*.type'       => ['nullable', 'string', Rule::in(['social', 'contact', 'quick', 'custom'])],
                'page_links.*.is_active'  => ['nullable', 'boolean'],
                'page_links.*.order'      => ['nullable', 'integer', 'min:0'],
                'page_links.*.company_id' => ['nullable', 'integer', 'exists:companies,id'],
                ...$this->prefixedRules('page_links.*.', $linkTranslationRules),
            ];
        }

        if ($this->boolean('sync_sections')) {
            $layoutKeys = array_keys(config('cms.section_layouts.layouts', []));
            if ($layoutKeys === []) {
                $layoutKeys = ['stacked'];
            }

            $base += [
                'sections'                          => ['nullable', 'array'],
                'sections.*.id'                     => ['nullable', 'integer', 'exists:cms_sections,id'],
                'sections.*.name'                   => ['required', 'string', 'max:255'],
                'sections.*.section_layout'         => ['required', 'string', Rule::in($layoutKeys)],
                'sections.*.settings'               => ['nullable', 'array'],
                'sections.*.is_active'              => ['nullable', 'boolean'],
                'sections.*.order'                  => ['nullable', 'integer', 'min:0'],
                'sections.*.company_id'             => ['nullable', 'integer', 'exists:companies,id'],
                'sections.*.prune_links'            => ['nullable', 'boolean'],
                'sections.*.prune_items'            => ['nullable', 'boolean'],

                'sections.*.translations'                => ['required', 'array'],
                'sections.*.translations.en'             => ['required', 'array'],
                'sections.*.translations.en.title'       => ['required', 'string', 'max:255'],
                'sections.*.translations.en.subtitle'    => ['nullable', 'string'],
                'sections.*.translations.en.description' => ['nullable', 'string'],
                'sections.*.translations.ar'             => ['nullable', 'array'],
                'sections.*.translations.ar.title'       => ['nullable', 'string', 'max:255'],
                'sections.*.translations.ar.subtitle'    => ['nullable', 'string'],
                'sections.*.translations.ar.description' => ['nullable', 'string'],

                'sections.*.links'                        => ['nullable', 'array'],
                'sections.*.links.*.id'                   => ['nullable', 'integer', 'exists:cms_links,id'],
                'sections.*.links.*.link'                 => ['required', 'string', 'max:2048'],
                'sections.*.links.*.icon'                 => ['nullable', 'string', 'max:255'],
                'sections.*.links.*.target'               => ['nullable', 'string', Rule::in(['_self', '_blank', '_parent', '_top'])],
                'sections.*.links.*.type'                 => ['nullable', 'string', Rule::in(['social', 'contact', 'quick', 'custom'])],
                'sections.*.links.*.is_active'            => ['nullable', 'boolean'],
                'sections.*.links.*.order'                => ['nullable', 'integer', 'min:0'],
                'sections.*.links.*.company_id'           => ['nullable', 'integer', 'exists:companies,id'],
                ...$this->prefixedRules('sections.*.links.*.', $linkTranslationRules),

                'sections.*.items'                        => ['nullable', 'array'],
                'sections.*.items.*.id'                   => ['nullable', 'integer', 'exists:cms_items,id'],
                'sections.*.items.*.type'                 => ['required', 'string', Rule::in(['default', 'card', 'feature', 'testimonial', 'industry'])],
                'sections.*.items.*.settings'             => ['nullable', 'array'],
                'sections.*.items.*.is_active'            => ['nullable', 'boolean'],
                'sections.*.items.*.order'                => ['nullable', 'integer', 'min:0'],
                'sections.*.items.*.company_id'           => ['nullable', 'integer', 'exists:companies,id'],
                'sections.*.items.*.main_media'           => ['nullable', 'file', 'max:51200', 'mimetypes:image/jpeg,image/png,image/webp,image/gif,video/mp4,video/webm,video/quicktime,video/x-msvideo'],
                'sections.*.items.*.delete_main_media'    => ['nullable', 'boolean'],
                'sections.*.items.*.main_media_alt'       => ['nullable', 'string', 'max:255'],
                'sections.*.items.*.prune_links'          => ['nullable', 'boolean'],

                'sections.*.items.*.translations'                  => ['required', 'array'],
                'sections.*.items.*.translations.en'                 => ['required', 'array'],
                'sections.*.items.*.translations.en.title'           => ['required', 'string', 'max:255'],
                'sections.*.items.*.translations.en.sub_title'       => ['nullable', 'string'],
                'sections.*.items.*.translations.en.content'         => ['nullable', 'string'],
                'sections.*.items.*.translations.en.icon'            => ['nullable', 'string'],
                'sections.*.items.*.translations.ar'               => ['nullable', 'array'],
                'sections.*.items.*.translations.ar.title'           => ['nullable', 'string', 'max:255'],
                'sections.*.items.*.translations.ar.sub_title'       => ['nullable', 'string'],
                'sections.*.items.*.translations.ar.content'         => ['nullable', 'string'],
                'sections.*.items.*.translations.ar.icon'            => ['nullable', 'string'],

                'sections.*.items.*.links'                        => ['nullable', 'array'],
                'sections.*.items.*.links.*.id'                     => ['nullable', 'integer', 'exists:cms_links,id'],
                'sections.*.items.*.links.*.link'                   => ['required', 'string', 'max:2048'],
                'sections.*.items.*.links.*.icon'                   => ['nullable', 'string', 'max:255'],
                'sections.*.items.*.links.*.target'                 => ['nullable', 'string', Rule::in(['_self', '_blank', '_parent', '_top'])],
                'sections.*.items.*.links.*.type'                   => ['nullable', 'string', Rule::in(['social', 'contact', 'quick', 'custom'])],
                'sections.*.items.*.links.*.is_active'              => ['nullable', 'boolean'],
                'sections.*.items.*.links.*.order'                  => ['nullable', 'integer', 'min:0'],
                'sections.*.items.*.links.*.company_id'             => ['nullable', 'integer', 'exists:companies,id'],
                ...$this->prefixedRules('sections.*.items.*.links.*.', $linkTranslationRules),
            ];
        }

        return $base;
    }

    /**
     * @param  array<string, array<int, mixed>>  $rules
     * @return array<string, array<int, mixed>>
     */
    protected function prefixedRules(string $prefix, array $rules): array
    {
        $out = [];
        foreach ($rules as $key => $rule) {
            $out[$prefix.$key] = $rule;
        }

        return $out;
    }

    protected function prepareForValidation(): void
    {
        if (! $this->has('sync_sections')) {
            $this->merge(['sync_sections' => true]);
        }

        if (! $this->has('sync_page_links')) {
            $this->merge(['sync_page_links' => true]);
        }

        $this->merge([
            'is_active'        => (bool) $this->boolean('is_active'),
            'order'            => $this->input('order') === null || $this->input('order') === '' ? 0 : (int) $this->input('order'),
            'sync_sections'    => (bool) $this->boolean('sync_sections'),
            'sync_page_links'  => (bool) $this->boolean('sync_page_links'),
            'prune_sections'   => (bool) $this->boolean('prune_sections'),
            'prune_page_links' => (bool) $this->boolean('prune_page_links'),
        ]);

        if (is_array($this->input('sections'))) {
            $sections = [];
            foreach ($this->input('sections') as $section) {
                if (! is_array($section) || ! filled($section['name'] ?? '')) {
                    continue;
                }

                if (isset($section['items']) && is_array($section['items'])) {
                    $cleanItems = [];
                    foreach ($section['items'] as $item) {
                        if (! is_array($item) || ! filled($item['translations']['en']['title'] ?? '')) {
                            continue;
                        }
                        if (isset($item['links']) && is_array($item['links'])) {
                            $item['links'] = array_values(array_filter(
                                $item['links'],
                                fn ($link) => is_array($link)
                                    && filled($link['link'] ?? '')
                                    && filled($link['translations']['en']['name'] ?? '')
                            ));
                        }
                        $cleanItems[] = $item;
                    }
                    $section['items'] = $cleanItems;
                }

                if (isset($section['links']) && is_array($section['links'])) {
                    $section['links'] = array_values(array_filter(
                        $section['links'],
                        fn ($link) => is_array($link)
                            && filled($link['link'] ?? '')
                            && filled($link['translations']['en']['name'] ?? '')
                    ));
                }

                $sections[] = $section;
            }

            $this->merge(['sections' => $sections]);
        }

        if (is_array($this->input('page_links'))) {
            $pageLinks = array_values(array_filter(
                $this->input('page_links'),
                fn ($link) => is_array($link)
                    && filled($link['link'] ?? '')
                    && filled($link['translations']['en']['name'] ?? '')
            ));

            $this->merge(['page_links' => $pageLinks]);
        }
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $v): void {
            $pageId = (int) $this->route('id');

            if ($this->boolean('sync_sections')) {
                $this->validateNestedSections($v, $pageId);
            }

            if ($this->boolean('sync_page_links')) {
                $this->validatePageLinks($v, $pageId);
            }
        });
    }

    protected function validateNestedSections(Validator $v, int $pageId): void
    {
        foreach ($this->input('sections', []) as $sIdx => $section) {
                if (! is_array($section)) {
                    continue;
                }

                if (! empty($section['id'])) {
                    $belongs = Section::query()
                        ->where('id', (int) $section['id'])
                        ->where('page_id', $pageId)
                        ->exists();

                    if (! $belongs) {
                        $v->errors()->add("sections.$sIdx.id", trans('validation.exists', ['attribute' => "sections.$sIdx.id"]));
                    }
                }

                $sectionId = ! empty($section['id']) ? (int) $section['id'] : null;

                foreach ($section['items'] ?? [] as $iIdx => $item) {
                    if (! is_array($item)) {
                        continue;
                    }

                    if (! empty($item['id'])) {
                        $row = Item::query()->find((int) $item['id']);
                        if (! $row) {
                            $v->errors()->add("sections.$sIdx.items.$iIdx.id", trans('validation.exists', ['attribute' => 'id']));

                            continue;
                        }

                        if ($sectionId !== null && (int) $row->section_id !== $sectionId) {
                            $v->errors()->add("sections.$sIdx.items.$iIdx.id", trans('validation.exists', ['attribute' => 'id']));
                        }

                        if ($sectionId === null) {
                            $v->errors()->add("sections.$sIdx.items.$iIdx.id", __('New sections cannot reuse existing item IDs.'));
                        }
                    }
                }

                foreach ($section['links'] ?? [] as $lIdx => $link) {
                    if (! is_array($link) || empty($link['id'])) {
                        continue;
                    }
                    $this->assertLinkBelongs($v, $link, Section::class, $sectionId, "sections.$sIdx.links.$lIdx.id");
                }

                foreach ($section['items'] ?? [] as $iIdx => $item) {
                    if (! is_array($item)) {
                        continue;
                    }
                    $itemId = ! empty($item['id']) ? (int) $item['id'] : null;
                    foreach ($item['links'] ?? [] as $lIdx => $link) {
                        if (! is_array($link) || empty($link['id'])) {
                            continue;
                        }
                        if ($itemId === null) {
                            $v->errors()->add("sections.$sIdx.items.$iIdx.links.$lIdx.id", __('New items cannot reuse existing link IDs.'));

                            continue;
                        }
                        $this->assertLinkBelongs($v, $link, Item::class, $itemId, "sections.$sIdx.items.$iIdx.links.$lIdx.id");
                    }
                }
            }
    }

    protected function validatePageLinks(Validator $v, int $pageId): void
    {
        foreach ($this->input('page_links', []) as $pIdx => $link) {
            if (! is_array($link) || empty($link['id'])) {
                continue;
            }
            $this->assertLinkBelongs($v, $link, Page::class, $pageId, "page_links.$pIdx.id");
        }
    }

    /**
     * @param  array<string, mixed>  $link
     */
    protected function assertLinkBelongs(
        Validator $v,
        array $link,
        string $expectType,
        ?int $expectId,
        string $errorKey
    ): void {
        if ($expectId === null) {
            $v->errors()->add($errorKey, __('Parent must be saved before reusing link IDs.'));

            return;
        }

        $row = Link::query()->find((int) $link['id']);
        if (! $row) {
            $v->errors()->add($errorKey, trans('validation.exists', ['attribute' => 'id']));

            return;
        }

        if ($row->linkable_type !== $expectType || (int) $row->linkable_id !== $expectId) {
            $v->errors()->add($errorKey, trans('validation.exists', ['attribute' => 'id']));
        }
    }
}
