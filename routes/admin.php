<?php

use App\Http\Controllers\DashBoard\AdminController;
use App\Http\Controllers\DashBoard\LoginController;
use App\Http\Controllers\DashBoard\SettingController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

///The prefix is admin for all belong to Admin///
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function() {
        Route::get('test', function() {
            return 'test';
        });
        Route::group(['namespace' => 'DashBoard', 'middleware' => 'auth:admin',
            'prefix' => 'admin'], function() {
            Route::get('/', [AdminController::class, 'index'])->name('admin.index');
            Route::group(['prefix' => 'setting'], function() {
                Route::get('shipping-method/{type}',
                    [SettingController::class, 'editShippingMethod'])
                ->name('edit-shipping-method');
                Route::put('shipping-method/{id}',
                    [SettingController::class, 'updateShippingMethod'])
                ->name('update-shipping-method');
                Route::get('logout', [LoginController::class, 'logout'])
                    ->name('admin.logout');
            });
        });

        Route::group(['namespace' => 'DashBoard', 'middleware' => 'guest:admin',
            'prefix' => 'admin'], function() {
            Route::get('login', [LoginController::class, 'login'])
            ->name('admin.login');
            Route::post('login', [LoginController::class, 'postAdminLogin'])
            ->name('post.admin.login');
        });
});
