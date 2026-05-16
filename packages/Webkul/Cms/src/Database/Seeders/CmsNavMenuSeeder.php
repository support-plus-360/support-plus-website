<?php

namespace Webkul\Cms\Database\Seeders;

use Illuminate\Database\Seeder;
use Webkul\Cms\Models\NavItem;
use Webkul\Cms\Models\NavItemTranslation;
use Webkul\Cms\Models\NavMenu;
use Webkul\Cms\Models\Page;

class CmsNavMenuSeeder extends Seeder
{
    public function run(): void
    {
        $companyId = 1;

        $headerMenu = NavMenu::create([
            'company_id' => $companyId,
            'key'        => 'header',
            'name'       => 'Main header',
        ]);

        $footerMenu = NavMenu::create([
            'company_id' => $companyId,
            'key'        => 'footer',
            'name'       => 'Main footer',
        ]);

        $pages = Page::query()
            ->where('company_id', $companyId)
            ->get()
            ->keyBy('slug');

        $this->seedHeaderMenu($headerMenu, $pages);
        $this->seedFooterMenu($footerMenu, $pages);
    }

    /**
     * @param  \Illuminate\Support\Collection<string, Page>  $pages
     */
    protected function seedHeaderMenu(NavMenu $menu, $pages): void
    {
        $this->createPageItem($menu, $pages->get('home'), order: 1);

         $this->createPageItem($menu, $pages->get('healthcare'), order: 2);

        $services = $this->createLabelItem($menu, [
            'en' => 'Services',
            'ar' => 'الخدمات',
        ], order: 3);

        foreach ([
            ['slug' => 'digital-marketing', 'order' => 1],
            ['slug' => 'software-house', 'order' => 2],
            ['slug' => 'call-center', 'order' => 3],
            ['slug' => 'services', 'order' => 4, 'en' => 'All Services', 'ar' => 'جميع الخدمات'],
        ] as $child) {
            $page = $pages->get($child['slug']);

            if (! $page) {
                continue;
            }

            $item = $this->createPageItem($menu, $page, parentId: $services->id, order: $child['order']);

            if (isset($child['en'])) {
                $this->setLabels($item, $child['en'], $child['ar']);
            }
        }

        $this->createPageItem($menu, $pages->get('case-studies'), order: 4);
        $this->createPageItem($menu, $pages->get('contact'), order: 5);
    }

    /**
     * @param  \Illuminate\Support\Collection<string, Page>  $pages
     */
    protected function seedFooterMenu(NavMenu $menu, $pages): void
    {
        $order = 1;

        foreach (['home', 'services', 'case-studies', 'contact'] as $slug) {
            $page = $pages->get($slug);

            if ($page) {
                $this->createPageItem($menu, $page, order: $order++);
            }
        }
    }

    protected function createPageItem(
        NavMenu $menu,
        ?Page $page,
        ?int $parentId = null,
        int $order = 0,
    ): ?NavItem {
        if (! $page) {
            return null;
        }

        return NavItem::create([
            'menu_id'         => $menu->id,
            'parent_id'       => $parentId,
            'cms_page_id'     => $page->id,
            'order'           => $order,
            'is_active'       => true,
            'open_in_new_tab' => false,
        ]);
    }

  /**
     * @param  array{en: string, ar: string}  $labels
     */
    protected function createLabelItem(NavMenu $menu, array $labels, int $order = 0): NavItem
    {
        $item = NavItem::create([
            'menu_id'         => $menu->id,
            'parent_id'       => null,
            'cms_page_id'     => null,
            'url'             => null,
            'order'           => $order,
            'is_active'       => true,
            'open_in_new_tab' => false,
        ]);

        $this->setLabels($item, $labels['en'], $labels['ar']);

        return $item;
    }

    protected function setLabels(NavItem $item, string $en, string $ar): void
    {
        foreach (['en' => $en, 'ar' => $ar] as $locale => $label) {
            NavItemTranslation::create([
                'cms_nav_item_id' => $item->id,
                'locale'          => $locale,
                'label'           => $label,
            ]);
        }
    }
}
