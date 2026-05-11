<?php

namespace Webkul\Cms\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class CmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../Resources/assets/builder-layout-previews' => public_path('vendor/webkul/cms/builder-layout-previews'),
        ], 'cms-builder-layout-previews');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');

        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'cms');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'cms');

//         Event::listen('admin.layout.head.after', function($viewRenderEventManager) {
//             $viewRenderEventManager->addTemplate('cms::components.layouts.style');
//         });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
    }

    /**
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/menu.php', 'menu.admin'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/acl.php', 'acl'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/section_layouts.php', 'cms.section_layouts'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/cms_section_layout_renderers.php', 'cms.section_layout_renderers'
        );
    }
}
