<?php

namespace Webkul\Cms\Database\Seeders;

use Illuminate\Database\Seeder;
use Webkul\Cms\Models\NavItem;
use Webkul\Cms\Models\NavItemTranslation;
use Webkul\Cms\Models\NavMenu;
use Webkul\Cms\Models\Page;

class CmsNavMenuSeeder extends Seeder
{
    /**
     * Page slugs seeded by CmsPageSeeder for company_id = 1 (Support Plus).
     *
     * @var array<string, string>
     */
    protected array $supportPlusPageSlugs = [
        'home'              => 'support-plus-home',
        'healthcare'        => 'support-plus-healthcare',
        'digital-marketing' => 'support-plus-digital-marketing',
        'software-house'    => 'support-plus-software-house',
        'call-center'       => 'support-plus-call-center',
        'services'          => 'support-plus-services',
        'case-studies'      => 'support-plus-case-studies',
        'contact'           => 'support-plus-contact',
    ];

    /**
     * Page slugs seeded by CmsPageSeeder for company_id = 2 (Mena Support).
     *
     * @var array<string, string>
     */
    protected array $menaSupportPageSlugs = [
        'home'          => 'mena-support-home',
        'services'      => 'mena-support-services',
        'case-studies'  => 'mena-support-case-studies',
        'about-us'      => 'mena-support-about-us',
        'blog'          => 'mena-support-blog',
    ];

    /**
     * Active page slug map for the company currently being seeded.
     *
     * @var array<string, string>
     */
    protected array $pageSlugs = [];

    public function run(): void
    {
        $this->seedCompanyNavMenus(1, $this->supportPlusPageSlugs);
        $this->seedCompanyNavMenus(2, $this->menaSupportPageSlugs);
    }

    protected function seedCompanyNavMenus(int $companyId, array $pageSlugs): void
    {
        $this->pageSlugs = $pageSlugs;

        $pages = Page::query()
            ->where('company_id', $companyId)
            ->get()
            ->keyBy('slug');

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

        if ($companyId === 1) {
            $this->seedSupportPlusHeaderMenu($headerMenu, $pages);
            $this->seedSupportPlusFooterMenu($footerMenu, $pages);
        } else {
            $this->seedMenaSupportHeaderMenu($headerMenu, $pages);
            $this->seedMenaSupportFooterMenu($footerMenu, $pages);
        }
    }

    protected function pageByKey($pages, string $key): ?Page
    {
        $slug = $this->pageSlugs[$key] ?? null;

        return $slug ? $pages->get($slug) : null;
    }

    /**
     * @param  \Illuminate\Support\Collection<string, Page>  $pages
     */
    protected function seedSupportPlusHeaderMenu(NavMenu $menu, $pages): void
    {
        $this->createPageItem($menu, $this->pageByKey($pages, 'home'), order: 1);

        $this->createPageItem($menu, $this->pageByKey($pages, 'healthcare'), order: 2);

        $services = $this->createLabelItem($menu, [
            'en' => 'Services',
            'ar' => 'الخدمات',
        ], order: 3);

        foreach ([
            ['key' => 'digital-marketing', 'order' => 1],
            ['key' => 'software-house', 'order' => 2],
            ['key' => 'call-center', 'order' => 3],
            ['key' => 'services', 'order' => 4, 'en' => 'All Services', 'ar' => 'جميع الخدمات'],
        ] as $child) {
            $page = $this->pageByKey($pages, $child['key']);

            if (! $page) {
                continue;
            }

            $item = $this->createPageItem($menu, $page, parentId: $services->id, order: $child['order']);

            if (isset($child['en'])) {
                $this->setLabels($item, $child['en'], $child['ar']);
            }
        }

        $this->createPageItem($menu, $this->pageByKey($pages, 'case-studies'), order: 4);
        $this->createPageItem($menu, $this->pageByKey($pages, 'contact'), order: 5);
    }

    /**
     * @param  \Illuminate\Support\Collection<string, Page>  $pages
     */
    protected function seedSupportPlusFooterMenu(NavMenu $menu, $pages): void
    {
        $this->seedFlatFooterMenu($menu, $pages, ['home', 'services', 'case-studies', 'contact']);
    }

    /**
     * @param  \Illuminate\Support\Collection<string, Page>  $pages
     */
    protected function seedMenaSupportHeaderMenu(NavMenu $menu, $pages): void
    {
        $order = 1;

        foreach (['home', 'services', 'case-studies', 'about-us', 'blog'] as $key) {
            $this->createPageItem($menu, $this->pageByKey($pages, $key), order: $order++);
        }
    }

    /**
     * @param  \Illuminate\Support\Collection<string, Page>  $pages
     */
    protected function seedMenaSupportFooterMenu(NavMenu $menu, $pages): void
    {
        $this->seedFlatFooterMenu($menu, $pages, ['home', 'services', 'case-studies', 'about-us']);
    }

    /**
     * @param  \Illuminate\Support\Collection<string, Page>  $pages
     * @param  array<int, string>  $keys
     */
    protected function seedFlatFooterMenu(NavMenu $menu, $pages, array $keys): void
    {
        $order = 1;

        foreach ($keys as $key) {
            $page = $this->pageByKey($pages, $key);

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
