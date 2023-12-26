<?php

use App\Http\Controllers\Site\CategoryController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\ProductController;
use App\Http\Controllers\Site\VerificationCodeController;
use App\Http\Controllers\Site\WishlistController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Site Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect',
            'localeViewPath']
    ], function() {
        Route::group(['namespace' => 'Site', 'middleware' => ['auth']
        ], function () {
            Route::get('verified', [VerificationCodeController::class,
                'getVerifyPage'])->name('verify-page');
            Route::post('verifiedUser', [VerificationCodeController::class, 'verify']
            )->name('verify-user');
        });

        Route::group(['namespace' => 'Site'], function () {
            Route::get('/', [HomeController::class, 'home'])->name('home')
                ->middleware('verifiedUser');
            route::get('category/{slug}', [CategoryController::class, 'productsBySlug'])
                ->name('category');
            route::get('product/{slug}', [ProductController::class, 'productsBySlug'])
                ->name('product.details');
        });
});

Route::group(['namespace' => 'Site', 'middleware' => 'auth'], function () {
    Route::post('wishlist', [WishlistController::class, 'store'])
        ->name('wishlist.store');
    Route::delete('wishlist', [WishlistController::class, 'destroy'])
        ->name('wishlist.destroy');
    Route::get('wishlist/products', [WishlistController::class, 'index'])
        ->name('wishlist.products.index');
});
