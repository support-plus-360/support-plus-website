<?php

namespace Webkul\Cms\Providers;

use Webkul\Core\Providers\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    /**
     * The models to be used by this module.
     *
     * @var array
     */
    protected $models = [
        \Webkul\Cms\Models\Page::class,
        \Webkul\Cms\Models\PageTranslation::class,
		\Webkul\Cms\Models\Section::class,
		\Webkul\Cms\Models\SectionTranslation::class,
        \Webkul\Cms\Models\Item::class,
        \Webkul\Cms\Models\ItemTranslation::class,
        \Webkul\Cms\Models\Link::class,
        \Webkul\Cms\Models\LinkTranslation::class,
        \Webkul\Cms\Models\BlogCategory::class,
        \Webkul\Cms\Models\BlogCategoryTranslation::class,
		\Webkul\Cms\Models\BlogPost::class,
		\Webkul\Cms\Models\BlogPostTranslation::class,
        \Webkul\Cms\Models\NavMenu::class,
        \Webkul\Cms\Models\NavItem::class,
        \Webkul\Cms\Models\NavItemTranslation::class,
        \Webkul\Cms\Models\CaseStudyCategory::class,
        \Webkul\Cms\Models\CaseStudy::class,
        \Webkul\Cms\Models\CaseStudyTranslation::class,
        \Webkul\Cms\Models\ServiceType::class,
        \Webkul\Cms\Models\Service::class,
        \Webkul\Cms\Models\ServiceTranslation::class,
    ];
}
