<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


# DASHBOARD ADMIN
Route::get('/admin', function () {
    return view('admin.home');
});
Route::get('/admin/news_feed', function () {
    return view('admin.home');
});
Route::get('/admin/news_feed/create', function () {
    return view('admin.home');
});
# DASHBOARD ADMIN
