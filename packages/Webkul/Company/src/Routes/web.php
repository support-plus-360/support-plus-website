<?php

use Illuminate\Support\Facades\Route;
use Webkul\Company\Http\Controllers\Admin\CompanyController;

Route::middleware(['web', 'admin_locale', 'user'])
    ->prefix(config('app.admin_path'))
    ->group(function () {
        Route::controller(CompanyController::class)->prefix('company')->group(function () {
            Route::get('', 'index')->name('admin.company.index');
            Route::get('create', 'create')->name('admin.company.create');
            Route::post('', 'store')->name('admin.company.store');
            Route::get('{id}/edit', 'edit')->whereNumber('id')->name('admin.company.edit');
            Route::put('{id}', 'update')->whereNumber('id')->name('admin.company.update');
            Route::delete('{id}', 'destroy')->whereNumber('id')->name('admin.company.delete');
            Route::post('{id}/restore', 'restore')->whereNumber('id')->name('admin.company.restore');
            Route::delete('{id}/force', 'forceDelete')->whereNumber('id')->name('admin.company.forceDelete');
        });
    });
