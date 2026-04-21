<?php

use Illuminate\Support\Facades\Route;
use Webkul\Cms\Http\Controllers\CmsController;
use Webkul\Cms\Http\Controllers\Admin\PageController;
use Webkul\Cms\Http\Controllers\Admin\SectionController;

Route::middleware(['web', 'admin_locale', 'user'])
    ->prefix(config('app.admin_path'))
    ->group(function () {
        Route::prefix('cms')->group(function () {
            Route::get('', [CmsController::class, 'index'])->name('admin.cms.index');

            Route::controller(PageController::class)->prefix('pages')->group(function () {
                Route::get('', 'index')->name('admin.cms.pages.index');
                Route::get('create', 'create')->name('admin.cms.pages.create');
                Route::post('', 'store')->name('admin.cms.pages.store');
                Route::get('{id}/edit', 'edit')->name('admin.cms.pages.edit');
                Route::put('{id}', 'update')->name('admin.cms.pages.update');
                Route::delete('{id}', 'destroy')->name('admin.cms.pages.delete');
            });

            Route::controller(SectionController::class)->prefix('sections')->group(function () {
                Route::get('', 'index')->name('admin.cms.sections.index');
                Route::get('create', 'create')->name('admin.cms.sections.create');
                Route::post('', 'store')->name('admin.cms.sections.store');
                Route::get('{id}/edit', 'edit')->name('admin.cms.sections.edit');
                Route::put('{id}', 'update')->name('admin.cms.sections.update');
                Route::delete('{id}', 'destroy')->name('admin.cms.sections.delete');
            });
        });
    });
