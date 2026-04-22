<?php

use Illuminate\Support\Facades\Route;
use Webkul\Company\Http\Controllers\Api\CompanyApiController;

Route::prefix('api/companies')->controller(CompanyApiController::class)->group(function () {
            Route::get('', 'index')->name('admin.company.api.companies.index');
            Route::post('', 'store')->name('admin.company.api.companies.store');
            Route::get('{id}', 'show')->whereNumber('id')->name('admin.company.api.companies.show');
            Route::put('{id}', 'update')->whereNumber('id')->name('admin.company.api.companies.update');
            Route::delete('{id}', 'destroy')->whereNumber('id')->name('admin.company.api.companies.destroy');
        });


// Route::middleware(['web', 'admin_locale', 'user'])
//     ->prefix(config('app.admin_path'))
//     ->group(function () {

//     });
