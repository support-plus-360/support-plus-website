<?php

use Illuminate\Support\Facades\Route;
use Webkul\Cms\Http\Controllers\Api\PageApiController;
use Webkul\Cms\Http\Controllers\Api\SectionApiController;
use Webkul\Cms\Http\Controllers\Api\LinkApiController;
use Webkul\Cms\Http\Controllers\Api\BlogCategoryApiController;
use Webkul\Cms\Http\Controllers\Api\BlogPostApiController;
use Webkul\Cms\Http\Controllers\Api\ItemApiController;

// pages
Route::prefix('cms/api/pages')->controller(PageApiController::class)->group(function () {
            Route::get('', 'index')->name('admin.cms.api.pages.index');
            Route::post('', 'store')->name('admin.cms.api.pages.store');
            Route::get('{id}', 'show')->whereNumber('id')->name('admin.cms.api.pages.show');
            Route::put('{id}', 'update')->whereNumber('id')->name('admin.cms.api.pages.update');
            Route::delete('{id}', 'destroy')->whereNumber('id')->name('admin.cms.api.pages.destroy');
        });

// sections
Route::prefix('cms/api/sections')->controller(SectionApiController::class)->group(function () {
            Route::get('', 'index')->name('admin.cms.api.sections.index');
            Route::post('', 'store')->name('admin.cms.api.sections.store');
            Route::get('{id}', 'show')->whereNumber('id')->name('admin.cms.api.sections.show');
            Route::get('page/{pageId}', 'getSectionsByPageId')->whereNumber('pageId')->name('admin.cms.api.sections.getSectionsByPageId');
            Route::put('{id}', 'update')->whereNumber('id')->name('admin.cms.api.sections.update');
            Route::delete('{id}', 'destroy')->whereNumber('id')->name('admin.cms.api.sections.destroy');
        });


// items
Route::prefix('cms/api/items')->controller(ItemApiController::class)->group(function () {
            Route::get('', 'index')->name('admin.cms.api.items.index');
            Route::post('', 'store')->name('admin.cms.api.items.store');
            Route::get('{id}', 'show')->whereNumber('id')->name('admin.cms.api.items.show');
            Route::get('section/{sectionId}', 'getItemsBySectionId')->whereNumber('sectionId')->name('admin.cms.api.items.getItemsBySectionId');
            Route::put('{id}', 'update')->whereNumber('id')->name('admin.cms.api.items.update');
            Route::delete('{id}', 'destroy')->whereNumber('id')->name('admin.cms.api.items.destroy');
        });


// links
Route::prefix('cms/api/links')->controller(LinkApiController::class)->group(function () {
            Route::get('', 'index')->name('admin.cms.api.links.index');
            Route::post('', 'store')->name('admin.cms.api.links.store');
            Route::get('{id}', 'show')->whereNumber('id')->name('admin.cms.api.links.show');
            Route::get('linkable/{linkableType}/{linkableId}', 'getLinksByLinkableTypeAndLinkableId')->where('linkableType', 'page|section|item')->whereNumber('linkableId')->name('admin.cms.api.links.getLinksByLinkableTypeAndLinkableId');
            Route::put('{id}', 'update')->whereNumber('id')->name('admin.cms.api.links.update');
            Route::delete('{id}', 'destroy')->whereNumber('id')->name('admin.cms.api.links.destroy');
        });

// blog categories
Route::prefix('cms/api/blog-categories')->controller(BlogCategoryApiController::class)->group(function () {
            Route::get('', 'index')->name('admin.cms.api.blog-categories.index');
            Route::post('', 'store')->name('admin.cms.api.blog-categories.store');
            Route::get('{id}', 'show')->whereNumber('id')->name('admin.cms.api.blog-categories.show');
            Route::put('{id}', 'update')->whereNumber('id')->name('admin.cms.api.blog-categories.update');
            Route::delete('{id}', 'destroy')->whereNumber('id')->name('admin.cms.api.blog-categories.destroy');
        });

// blog posts
Route::prefix('cms/api/blog-posts')->controller(BlogPostApiController::class)->group(function () {
            Route::get('', 'index')->name('admin.cms.api.blog-posts.index');
            Route::post('', 'store')->name('admin.cms.api.blog-posts.store');
            Route::get('{id}', 'show')->whereNumber('id')->name('admin.cms.api.blog-posts.show');
            Route::get('category/{categoryId}', 'getBlogPostsByCategoryId')->whereNumber('categoryId')->name('admin.cms.api.blog-posts.getBlogPostsByCategoryId');
            Route::put('{id}', 'update')->whereNumber('id')->name('admin.cms.api.blog-posts.update');
            Route::delete('{id}', 'destroy')->whereNumber('id')->name('admin.cms.api.blog-posts.destroy');
        });


