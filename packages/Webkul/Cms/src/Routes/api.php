<?php

use Illuminate\Support\Facades\Route;
use Webkul\Cms\Http\Controllers\Api\PageApiController;

Route::prefix('cms/api/pages')->controller(PageApiController::class)->group(function () {
            Route::get('', 'index')->name('admin.cms.api.pages.index');
            Route::post('', 'store')->name('admin.cms.api.pages.store');
            Route::get('{id}', 'show')->whereNumber('id')->name('admin.cms.api.pages.show');
            Route::put('{id}', 'update')->whereNumber('id')->name('admin.cms.api.pages.update');
            Route::delete('{id}', 'destroy')->whereNumber('id')->name('admin.cms.api.pages.destroy');
        });

// Route::middleware(['web', 'admin_locale', 'user'])
//     ->prefix(config('app.admin_path'))
//     ->group(function () {
//         Route::prefix('cms/api/pages')->controller(PageApiController::class)->group(function () {
//             Route::get('', 'index')->name('admin.cms.api.pages.index');
//             Route::post('', 'store')->name('admin.cms.api.pages.store');
//             Route::get('{id}', 'show')->whereNumber('id')->name('admin.cms.api.pages.show');
//             Route::put('{id}', 'update')->whereNumber('id')->name('admin.cms.api.pages.update');
//             Route::delete('{id}', 'destroy')->whereNumber('id')->name('admin.cms.api.pages.destroy');
//         });
//     });
