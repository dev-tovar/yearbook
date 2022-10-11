<?php

use App\Http\Controllers\Admin\AdminsController;
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

/* Migrating routes */
Route::post('/update', 'SystemController@updateServer');
Route::get('/test', function (){
    dd((new \App\User())->generatePassword());
});

Route::get('/', function (){
    return redirect('/admin');
});

Route::group(['prefix' => 'admin'], function () {

  Auth::routes();

  Route::any('users_statistics', 'Admin\UsersManagerController@getUsersForDashboard');
  // Group for auth users only
  Route::group(['middleware' => 'auth:admin'], function () {

    Route::get('/', 'Admin\DashboardController@index');


    Route::get('gallery', 'Admin\GalleryController@index');
    Route::get('gallery_content', 'Admin\GalleryController@content');


// Route::resource('/', 'Admin\DashboardController@index');
Route::resource('/info_dashboard', DashboardController::class);

    Route::group(['prefix' => 'content_manager', 'middleware' => 'school_admin'], function () {
        Route::get('mark-profiles-ready','Admin\PageController@markProfilesReady');
      Route::post('create', 'Admin\ContentManagerController@create');
      Route::post('delete', 'Admin\ContentManagerController@delete');
      Route::get('template', 'Admin\ContentManagerController@template');
      Route::get('template_list', 'Admin\TemplateController@getList');

Route::resource('/info_school_manager', SchoolManagerController::class);
Route::get('/create_school_manager',[SchoolManagerController::class, 'create']);
Route::get('/info_school_manager_super_admin/{id}',[SchoolManagerController::class, 'edit']);
Route::get('/remove_contract_file_school/{id}',[SchoolManagerController::class, 'removeContract']);
Route::post('/info_school_manager_update/{id}',[SchoolManagerController::class, 'update']);


Route::resource('/info_admins', AdminsController::class);
Route::get('/info_admins_super_admin/{id}',[AdminsController::class, 'edit']);
Route::post('/info_admins_update/{id}',[AdminsController::class, 'update']);






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
    Route::get('/super-admin/contact_us', function () {
        return view('super-admin.home');
    });
    Route::get('/super-admin/admins', function () {
        return view('super-admin.home');
    });
    Route::get('/super-admin/admins/create', function () {
        return view('super-admin.home');
    });
    Route::get('/super-admin/admins/{id_admin}/edit', function () {
        return view('super-admin.home');
    });
    Route::get('/super-admin/college_attending', function () {
        return view('super-admin.home');
    });
    Route::get('/super-admin/future_aspirations', function () {
        return view('super-admin.home');
    });
    Route::get('/super-admin/sports_clubs', function () {
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
