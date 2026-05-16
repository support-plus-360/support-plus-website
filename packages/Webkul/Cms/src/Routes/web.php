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
use Webkul\Cms\Http\Controllers\Admin\NavMenuController;
use Webkul\Cms\Http\Controllers\Admin\NavItemController;

Route::middleware(['web', 'admin_locale', 'user'])
    ->prefix(config('app.admin_path'))
    ->group(function () {
        Route::prefix('cms')->group(function () {
            Route::get('api/linkable-options', LinkableOptionsController::class)
                ->name('admin.cms.api.linkable-options');

            Route::get('', [CmsController::class, 'index'])->name('admin.cms.index');

            Route::get('builder-layout-preview/{filename}', [PageBuilderController::class, 'layoutPreviewAsset'])
                ->where('filename', '[a-zA-Z0-9._-]+')
                ->name('admin.cms.builder.layout-preview');

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
    });
