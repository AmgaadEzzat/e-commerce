<?php

use App\Http\Controllers\DashBoard\AdminController;
use App\Http\Controllers\DashBoard\LoginController;
use Illuminate\Support\Facades\Route;

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
Route::group(['namespace' => 'DashBoard', 'middleware' => 'auth:admin'], function() {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
});

Route::group(['namespace' => 'DashBoard', 'middleware' => 'guest:admin'], function() {
    Route::get('login', [LoginController::class, 'login'])->name('admin.login');
    Route::post('login', [LoginController::class, 'postAdminLogin'])
        ->name('post.admin.login');
});
