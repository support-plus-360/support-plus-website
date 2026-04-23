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
    ];
}
