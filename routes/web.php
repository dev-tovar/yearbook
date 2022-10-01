<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SchoolManagerController;
use Illuminate\Support\Facades\Auth;
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
    // return dd(Auth::guard('admin')->user()->email);

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'login']);






// Route::resource('/', 'Admin\DashboardController@index');
Route::resource('/info_dashboard', DashboardController::class);
Route::resource('/info_school_manager', SchoolManagerController::class);
Route::get('/create_school_manager',[SchoolManagerController::class, 'create']);
Route::get('/info_school_manager_super_admin/{id}',[SchoolManagerController::class, 'edit']);
Route::get('/remove_contract_file_school/{id}',[SchoolManagerController::class, 'removeContract']);
Route::post('/info_school_manager_update/{id}',[SchoolManagerController::class, 'update']);










Route::group(['prefix' => 'pyb'], function () {
    # DASHBOARD SUPERADMIN
    Route::get('/super-admin', function () {
        return view('super-admin.home');
    });
    Route::get('/super-admin/dashboard', function () {
        return view('super-admin.home');
    });
    Route::get('/super-admin/school_manager', function () {
        return view('super-admin.home');
    });
    Route::get('/super-admin/school_manager/create', function () {
        return view('super-admin.home');
    });
    Route::get('/super-admin/school_manager/{id_school}/edit', function () {
        return view('super-admin.home');
    });


    # DASHBOARD SUPERADMIN



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
    Route::get('/admin/user_manager/{id?}', function () {
        return view('admin.home');
    });
    Route::get('/admin/user_manager/{id?}/create', function () {
        return view('admin.home');
    });
    Route::get('/admin/content_manager', function () {
        return view('admin.home');
    });
    # DASHBOARD ADMIN

});
