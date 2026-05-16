<?php

namespace Webkul\Cms\Services;

use Illuminate\Support\Collection;
use Webkul\Cms\Models\NavItem;

class NavMenuTreeBuilder
{
    /**
     * @param  Collection<int, NavItem>  $items
     * @return array<int, array<string, mixed>>
     */
    public function build(Collection $items, ?int $parentId = null): array
    {
        return $items
            ->where('parent_id', $parentId)
            ->sortBy('order')
            ->values()
            ->map(fn (NavItem $item) => $this->node($item, $items))
            ->all();
    }

    /**
     * @param  Collection<int, NavItem>  $items
     * @return array<string, mixed>
     */
    protected function node(NavItem $item, Collection $items): array
    {
        $page = $item->relationLoaded('page') ? $item->page : null;

        $labels = [];

        foreach ($item->translations ?? [] as $translation) {
            if ($translation->label) {
                $labels[$translation->locale] = $translation->label;
            }
        }

        if ($page) {
            foreach ($page->translations ?? [] as $pageTranslation) {
                if (! isset($labels[$pageTranslation->locale])) {
                    $labels[$pageTranslation->locale] = $pageTranslation->title;
                }
            }
        }

        $href = $this->resolveHref($item, $page?->slug);

        return [
            'id'              => $item->id,
            'parent_id'       => $item->parent_id,
            'cms_page_id'     => $item->cms_page_id,
            'slug'            => $page?->slug,
            'url'             => $item->url,
            'href'            => $href,
            'label'           => $labels,
            'order'           => $item->order,
            'open_in_new_tab' => $item->open_in_new_tab,
            'children'        => $this->build($items, $item->id),
        ];
    }

    protected function resolveHref(NavItem $item, ?string $pageSlug): ?string
    {
        if ($item->url) {
            return $item->url;
        }

        if ($pageSlug) {
            return '/'.$pageSlug;
        }

        return null;
    }
}
