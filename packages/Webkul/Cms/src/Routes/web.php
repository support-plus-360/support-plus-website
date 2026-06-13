<?php

use Illuminate\Support\Facades\Route;
use Webkul\Cms\Http\Controllers\CmsController;
use Webkul\Cms\Http\Controllers\Admin\PageBuilderController;
use Webkul\Cms\Http\Controllers\Admin\PageController;
use Webkul\Cms\Http\Controllers\Admin\SectionController;
use Webkul\Cms\Http\Controllers\Admin\ItemController;
use Webkul\Cms\Http\Controllers\Admin\LinkController;
use Webkul\Cms\Http\Controllers\Admin\LinkableOptionsController;
use Webkul\Cms\Http\Controllers\Admin\BlogCategoryController;
use Webkul\Cms\Http\Controllers\Admin\BlogPostController;
use Webkul\Cms\Http\Controllers\Admin\ContactMessageController;
use Webkul\Cms\Http\Controllers\Admin\NavMenuController;
use Webkul\Cms\Http\Controllers\Admin\NavItemController;
use Webkul\Cms\Http\Controllers\Admin\CaseStudyCategoryController;
use Webkul\Cms\Http\Controllers\Admin\CaseStudyController;
use Webkul\Cms\Http\Controllers\Admin\ServiceTypeController;
use Webkul\Cms\Http\Controllers\Admin\ServiceController;

Route::middleware(['web', 'admin_locale', 'admin_no_cache', 'user'])
    ->prefix(config('app.admin_path'))
    ->group(function () {
        Route::prefix('cms')->group(function () {
            Route::get('api/linkable-options', LinkableOptionsController::class)
                ->name('admin.cms.api.linkable-options');

            Route::get('', [CmsController::class, 'index'])->name('admin.cms.index');

            Route::get('builder-layout-preview/{path}', [PageBuilderController::class, 'layoutPreviewAsset'])
                ->where('path', '.*')
                ->name('admin.cms.builder.layout-preview');

            Route::get('builder-layout-config', [PageBuilderController::class, 'layoutConfig'])
                ->name('admin.cms.builder.layout-config');

            Route::controller(PageBuilderController::class)->prefix('pages')->group(function () {
                Route::get('{id}/builder', 'edit')->whereNumber('id')->name('admin.cms.pages.builder');
                Route::put('{id}/builder', 'update')->whereNumber('id')->name('admin.cms.pages.builder.update');
            });

            Route::controller(PageController::class)->prefix('pages')->group(function () {
                Route::get('', 'index')->name('admin.cms.pages.index');
                Route::get('create', 'create')->name('admin.cms.pages.create');
                Route::post('', 'store')->name('admin.cms.pages.store');
                Route::get('{id}/edit', 'edit')->name('admin.cms.pages.edit');
                Route::put('{id}', 'update')->name('admin.cms.pages.update');
                Route::delete('{id}', 'destroy')->name('admin.cms.pages.delete');
		Route::post('{id}/restore', 'restore')->name('admin.cms.pages.restore');
		Route::delete('{id}/forceDelete', 'forceDelete')->name('admin.cms.pages.forceDelete');
            });

            Route::controller(SectionController::class)->prefix('sections')->group(function () {
                Route::get('', 'index')->name('admin.cms.sections.index');
                Route::get('create', 'create')->name('admin.cms.sections.create');
                Route::post('', 'store')->name('admin.cms.sections.store');
                Route::get('{id}/edit', 'edit')->name('admin.cms.sections.edit');
                Route::put('{id}', 'update')->name('admin.cms.sections.update');
                Route::delete('{id}', 'destroy')->name('admin.cms.sections.delete');
                Route::post('{id}/restore', 'restore')->name('admin.cms.sections.restore');
                Route::delete('{id}/forceDelete', 'forceDelete')->name('admin.cms.sections.forceDelete');
            });
        });

        Route::controller(ItemController::class)->prefix('items')->group(function () {
            Route::get('', 'index')->name('admin.cms.items.index');
            Route::get('create', 'create')->name('admin.cms.items.create');
            Route::post('', 'store')->name('admin.cms.items.store');
            Route::get('{id}/edit', 'edit')->name('admin.cms.items.edit');
            Route::put('{id}', 'update')->name('admin.cms.items.update');
            Route::delete('{id}', 'destroy')->name('admin.cms.items.delete');
            Route::post('{id}/restore', 'restore')->name('admin.cms.items.restore');
            Route::delete('{id}/forceDelete', 'forceDelete')->name('admin.cms.items.forceDelete');
        });

            Route::controller(LinkController::class)->prefix('links')->group(function () {
                Route::get('', 'index')->name('admin.cms.links.index');
                Route::get('create', 'create')->name('admin.cms.links.create');
                Route::post('', 'store')->name('admin.cms.links.store');
                Route::get('{id}/edit', 'edit')->name('admin.cms.links.edit');
                Route::put('{id}', 'update')->name('admin.cms.links.update');
                Route::delete('{id}', 'destroy')->name('admin.cms.links.delete');
                Route::post('{id}/restore', 'restore')->name('admin.cms.links.restore');
                Route::delete('{id}/forceDelete', 'forceDelete')->name('admin.cms.links.forceDelete');
            });

            Route::controller(NavMenuController::class)->prefix('nav-menus')->group(function () {
                Route::get('', 'index')->name('admin.cms.nav-menus.index');
                Route::get('create', 'create')->name('admin.cms.nav-menus.create');
                Route::post('', 'store')->name('admin.cms.nav-menus.store');
                Route::get('{id}/edit', 'edit')->whereNumber('id')->name('admin.cms.nav-menus.edit');
                Route::put('{id}', 'update')->whereNumber('id')->name('admin.cms.nav-menus.update');
                Route::delete('{id}', 'destroy')->whereNumber('id')->name('admin.cms.nav-menus.delete');
                Route::post('{id}/restore', 'restore')->whereNumber('id')->name('admin.cms.nav-menus.restore');
                Route::delete('{id}/forceDelete', 'forceDelete')->whereNumber('id')->name('admin.cms.nav-menus.forceDelete');
            });

            Route::controller(NavItemController::class)->prefix('nav-menus/{menuId}/items')->group(function () {
                Route::get('', 'index')->whereNumber('menuId')->name('admin.cms.nav-menus.items.index');
                Route::get('create', 'create')->whereNumber('menuId')->name('admin.cms.nav-menus.items.create');
                Route::post('', 'store')->whereNumber('menuId')->name('admin.cms.nav-menus.items.store');
                Route::get('{id}/edit', 'edit')->whereNumber(['menuId', 'id'])->name('admin.cms.nav-menus.items.edit');
                Route::put('{id}', 'update')->whereNumber(['menuId', 'id'])->name('admin.cms.nav-menus.items.update');
                Route::delete('{id}', 'destroy')->whereNumber(['menuId', 'id'])->name('admin.cms.nav-menus.items.delete');
                Route::post('{id}/restore', 'restore')->whereNumber(['menuId', 'id'])->name('admin.cms.nav-menus.items.restore');
                Route::delete('{id}/forceDelete', 'forceDelete')->whereNumber(['menuId', 'id'])->name('admin.cms.nav-menus.items.forceDelete');
            });

            Route::controller(BlogCategoryController::class)->prefix('blog-categories')->group(function () {
                Route::get('', 'index')->name('admin.cms.blog-categories.index');
                Route::get('create', 'create')->name('admin.cms.blog-categories.create');
                Route::post('', 'store')->name('admin.cms.blog-categories.store');
                Route::get('{id}/edit', 'edit')->name('admin.cms.blog-categories.edit');
                Route::put('{id}', 'update')->name('admin.cms.blog-categories.update');
                Route::delete('{id}', 'destroy')->name('admin.cms.blog-categories.delete');
                Route::post('{id}/restore', 'restore')->name('admin.cms.blog-categories.restore');
                Route::delete('{id}/forceDelete', 'forceDelete')->name('admin.cms.blog-categories.forceDelete');
            });

	Route::controller(BlogPostController::class)->prefix('blog-posts')->group(function () {
		Route::get('', 'index')->name('admin.cms.blog-posts.index');
		Route::get('create', 'create')->name('admin.cms.blog-posts.create');
		Route::post('', 'store')->name('admin.cms.blog-posts.store');
		Route::get('{id}/edit', 'edit')->name('admin.cms.blog-posts.edit');
		Route::put('{id}', 'update')->name('admin.cms.blog-posts.update');
		Route::delete('{id}', 'destroy')->name('admin.cms.blog-posts.delete');
		Route::post('{id}/restore', 'restore')->name('admin.cms.blog-posts.restore');
		Route::delete('{id}/forceDelete', 'forceDelete')->name('admin.cms.blog-posts.forceDelete');
	});

            Route::controller(ContactMessageController::class)->prefix('contact-messages')->group(function () {
                Route::get('', 'index')->name('admin.cms.contact-messages.index');
                Route::delete('{id}', 'destroy')->whereNumber('id')->name('admin.cms.contact-messages.delete');
            });

            Route::controller(CaseStudyCategoryController::class)->prefix('case-study-categories')->group(function () {
                Route::get('', 'index')->name('admin.cms.case-study-categories.index');
                Route::get('create', 'create')->name('admin.cms.case-study-categories.create');
                Route::post('', 'store')->name('admin.cms.case-study-categories.store');
                Route::get('{id}/edit', 'edit')->name('admin.cms.case-study-categories.edit');
                Route::put('{id}', 'update')->name('admin.cms.case-study-categories.update');
                Route::delete('{id}', 'destroy')->name('admin.cms.case-study-categories.delete');
                Route::post('{id}/restore', 'restore')->name('admin.cms.case-study-categories.restore');
                Route::delete('{id}/forceDelete', 'forceDelete')->name('admin.cms.case-study-categories.forceDelete');
            });

            Route::controller(CaseStudyController::class)->prefix('case-studies')->group(function () {
                Route::get('', 'index')->name('admin.cms.case-studies.index');
                Route::get('create', 'create')->name('admin.cms.case-studies.create');
                Route::post('', 'store')->name('admin.cms.case-studies.store');
                Route::get('{id}/edit', 'edit')->name('admin.cms.case-studies.edit');
                Route::put('{id}', 'update')->name('admin.cms.case-studies.update');
                Route::delete('{id}', 'destroy')->name('admin.cms.case-studies.delete');
                Route::post('{id}/restore', 'restore')->name('admin.cms.case-studies.restore');
                Route::delete('{id}/forceDelete', 'forceDelete')->name('admin.cms.case-studies.forceDelete');
            });

            Route::controller(ServiceTypeController::class)->prefix('service-types')->group(function () {
                Route::get('', 'index')->name('admin.cms.service-types.index');
                Route::get('create', 'create')->name('admin.cms.service-types.create');
                Route::post('', 'store')->name('admin.cms.service-types.store');
                Route::get('{id}/edit', 'edit')->name('admin.cms.service-types.edit');
                Route::put('{id}', 'update')->name('admin.cms.service-types.update');
                Route::delete('{id}', 'destroy')->name('admin.cms.service-types.delete');
                Route::post('{id}/restore', 'restore')->name('admin.cms.service-types.restore');
                Route::delete('{id}/forceDelete', 'forceDelete')->name('admin.cms.service-types.forceDelete');
            });

            Route::controller(ServiceController::class)->prefix('services')->group(function () {
                Route::get('', 'index')->name('admin.cms.services.index');
                Route::get('create', 'create')->name('admin.cms.services.create');
                Route::post('', 'store')->name('admin.cms.services.store');
                Route::get('{id}/edit', 'edit')->name('admin.cms.services.edit');
                Route::put('{id}', 'update')->name('admin.cms.services.update');
                Route::delete('{id}', 'destroy')->name('admin.cms.services.delete');
                Route::post('{id}/restore', 'restore')->name('admin.cms.services.restore');
                Route::delete('{id}/forceDelete', 'forceDelete')->name('admin.cms.services.forceDelete');
            });
    });
