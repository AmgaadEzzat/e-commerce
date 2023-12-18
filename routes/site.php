<?php

use App\Http\Controllers\Site\VerificationCodeController;
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
        Route::get('/', function (){
            return view('front.home');
        })->name('home')->middleware('verifiedUser');

        Route::group(['namespace' => 'Site', 'middleware' => ['auth']
        ], function () {
            Route::get('verified', [VerificationCodeController::class,
                'getVerifyPage'])->name('verify-page');
            Route::post('verifiedUser', [VerificationCodeController::class, 'verify']
            )->name('verify-user');
        });

        Route::group(['namespace' => 'Site', 'middleware' => 'guest'], function () {

        });
});
