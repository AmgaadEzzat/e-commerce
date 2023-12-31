<?php

use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\BrandController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\LoginController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\SliderController;
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
        Route::group(['namespace' => 'Dashboard', 'middleware' => 'auth:admin',
            'prefix' => 'admin'], function() {
            Route::get('/', [AdminController::class, 'index'])
                ->name('admin.index');
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
            Route::group(['prefix' => 'profile'], function() {
                Route::get('editProfile', [ProfileController::class, 'editProfile'])
                    ->name('admin.profile');
                Route::put('update', [ProfileController::class, 'updateProfile'])
                    ->name('update.admin.profile');
            });
            ////////////////////////////category routes///////////////
            Route::group(['prefix' => 'category'], function() {
                Route::get('/', [CategoriesController::class, 'index'])
                    ->name('get.all.categories');
                Route::get('create', [CategoriesController::class, 'create'])
                    ->name('create.category');
                Route::post('store', [CategoriesController::class, 'store'])
                    ->name('store.category');
                Route::get('edit/{id}', [CategoriesController::class, 'edit'])
                    ->name('edit.category');
                Route::post('update/{id}', [CategoriesController::class, 'update'])
                    ->name('update.category');
                Route::get('delete/{id}', [CategoriesController::class, 'delete'])
                    ->name('delete.category');
            });
            ////////////////////////////Brands///////////////////////
            Route::group(['prefix' => 'brand'], function() {
                Route::get('/', [BrandController::class, 'index'])
                    ->name('get.all.brands');
                Route::get('create', [BrandController::class, 'create'])
                    ->name('create.brand');
                Route::post('store', [BrandController::class, 'store'])
                    ->name('store.brand');
                Route::get('edit/{id}', [BrandController::class, 'edit'])
                    ->name('edit.brand');
                Route::post('update/{id}', [BrandController::class, 'update'])
                    ->name('update.brand');
                Route::get('delete/{id}', [BrandController::class, 'destroy'])
                    ->name('delete.brand');
            });
            /////////////////////////////product routs/////////////////////////////
            Route::group(['prefix' => 'products'], function () {
                Route::get('/', 'ProductsController@index')->name('admin.products');
                Route::get('general-information', 'ProductsController@create')
                    ->name('products.general.create');
                Route::post('store-general-information', 'ProductsController@store')
                    ->name('admin.products.general.store');

                Route::get('price/{id}', 'ProductsController@getPrice')
                    ->name('admin.products.price');
                Route::post('price', 'ProductsController@saveProductPrice')
                    ->name('admin.products.price.store');

                Route::get('stock/{id}', 'ProductsController@getStock')
                    ->name('admin.products.stock');
                Route::post('stock', 'ProductsController@saveProductStock')
                    ->name('admin.products.stock.store');

                Route::get('images/{id}', 'ProductsController@addImages')
                    ->name('admin.products.images');
                Route::post('images', 'ProductsController@saveProductImages')
                    ->name('admin.products.images.store');
                Route::post('images/db', 'ProductsController@saveProductImagesDB')
                    ->name('admin.products.images.store.db');
            });
            /////////////////////////////sliders////////////////////////
            Route::group(['prefix' => 'sliders'], function () {
                Route::get('/', [SliderController::class, 'addImages'])
                    ->name('admin.sliders.create');
                Route::post('images', [SliderController::class, 'saveSliderImages'])
                    ->name('admin.sliders.images.store');
                Route::post('images/db', [SliderController::class, 'saveSliderImagesDB'])
                    ->name('admin.sliders.images.store.db');

            });
        });

        Route::group(['namespace' => 'Dashboard', 'middleware' => 'guest:admin',
            'prefix' => 'admin'], function() {
            Route::get('login', [LoginController::class, 'login'])
            ->name('admin.login');
            Route::post('login', [LoginController::class, 'postAdminLogin'])
            ->name('post.admin.login');
        });
});
