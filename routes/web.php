<?php

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

    \App\Helpers\MediaRoutes::routes();

    Route::get('gallery', 'Admin\GalleryController@index');
    Route::get('gallery_content', 'Admin\GalleryController@content');

    Route::get('/backSuperAdmin', 'Auth\AdminLoginController@backSuperAdmin');
    Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

    Route::get('user_manager/{id}/export', 'Admin\UsersManagerController@export');
    Route::get('user_manager/import', 'Admin\UsersManagerController@importUser');
    Route::post('user_manager/import', 'Admin\UsersManagerController@handleImportUser');
    Route::get('user_manager/filter', 'Admin\UsersManagerController@filter');
    Route::get('user_manager/block', 'Admin\UsersManagerController@block');
    Route::post('user_manager/push', 'Admin\UsersManagerController@push');
    Route::post('user_manager/move-users', 'Admin\UsersManagerController@moveUsers');
    Route::resource('user_manager', 'Admin\UsersManagerController');
    Route::get('yearbook/{yearbook_id}/user_manager/paid', 'Admin\UsersManagerController@paidForAll');

    Route::group(['prefix' => 'content_manager', 'middleware' => 'school_admin'], function () {
        Route::get('mark-profiles-ready','Admin\PageController@markProfilesReady');
      Route::post('create', 'Admin\ContentManagerController@create');
      Route::post('delete', 'Admin\ContentManagerController@delete');
      Route::get('template', 'Admin\ContentManagerController@template');
      Route::get('template_list', 'Admin\TemplateController@getList');

        Route::group(['prefix' => 'tmp'], function () {
            Route::get('cover', 'Admin\ContentManagerController@cover');
            Route::get('students_profile', 'Admin\ContentManagerController@studentsProfile');
            Route::get('students_tribute', 'Admin\ContentManagerController@studentsTribute');
            Route::get('grades', 'Admin\ContentManagerController@grades');
        });

        Route::post('/{yearbook_id}/category', 'Admin\ContentManagerController@createCategory');
        Route::get('/{yearbook_id}/change-tribute', 'Admin\YearBookController@changeTribute');
        Route::post('/category/sort', 'Admin\ContentManagerController@sort');
        Route::post('/category/{id}/edit', 'Admin\ContentManagerController@rename');
        Route::get('/category/{id}/delete', 'Admin\ContentManagerController@deleteCategory');

      Route::group(['prefix' => 'page'], function () {
        Route::post('sort/{id}', 'Admin\PageController@sort');
        Route::post('store', 'Admin\PageController@store');
        Route::post('update/{id}', 'Admin\PageController@update');
        Route::get('edit_profile/{category}/{user}', 'Admin\PageController@editProfile');
        Route::get('edit/{id}', 'Admin\PageController@edit');
        Route::get('delete/{id}', 'Admin\PageController@destroy');
      });

      Route::get('{id}/preview', 'Admin\ContentManagerController@preview');
      Route::get('/show/{id}', 'Admin\ContentManagerController@show');
      Route::get('{name}', 'Admin\ContentManagerController@index');
    });

    Route::get('news_feed/{id}/preview', 'Admin\NewsFeedController@preview');
    Route::post('news_feed/attach/delete', 'Admin\NewsFeedController@attachDelete');

    Route::resource('news_feed', 'Admin\NewsFeedController')->except('show');

    Route::get('alumni_events/{id}/preview', 'Admin\AlumniEventsController@preview');
    Route::post('alumni_events/attach/delete', 'Admin\AlumniEventsController@attachDelete');
    Route::resource('alumni_events', 'Admin\AlumniEventsController')->except('show');
    Route::get('convert_alumni/{id}', 'Admin\ConvertToAlumniController');

    Route::get('donates', 'Admin\DonateController@index');
    Route::post('donates', 'Admin\DonateController@update');
    Route::post('donates-delete', 'Admin\DonateController@destroy');

//        Route::get('contact_us/reply', 'Admin\ContactsController@reply');
    Route::post('contact_us/reply', 'Admin\ContactsController@reply');
    Route::resource('contact_us', 'Admin\ContactsController');

    Route::get('bank-account/{school_id?}', 'Admin\BankAccountController@index');
    Route::post('bank-account', 'Admin\BankAccountController@store');
    Route::post('bank-account-delete', 'Admin\BankAccountController@destroy')->name('bank.delete');

    Route::resource('year_book', 'Admin\YearBookController');
    Route::get('year_book/{id}/publish', 'Admin\YearBookController@publish');
    Route::get('year_book/{id}/publish/final', 'Admin\YearBookController@finalPublish');

    Route::post('school_manager/{id}/contract_remove', 'Admin\SchoolManagerController@removeContract');
    Route::post('school_manager/{id}/contract', 'Admin\SchoolManagerController@contract');
    Route::resource('school_manager', 'Admin\SchoolManagerController');
    Route::resource('users', 'Admin\AdminsController')->except('show', 'delete');
    Route::resource('school', 'Admin\SchoolController');
    Route::resource('future_attending', 'Admin\FutureAttendingController');
    Route::resource('future_aspiration', 'Admin\FutureAspirationController');
    Route::resource('sport_club', 'Admin\SportClubController');
    Route::resource('alumni', 'Admin\AlumniController')->only(['index']);
    Route::get('alumni/{id}', 'Admin\AlumniController@getInfo');
    Route::get('alumni/{id}/view', 'Admin\AlumniController@view');
    Route::post('push', 'Admin\AlumniController@push');
  });
});

Route::get('/', function () {
    return view('welcome');
    // return dd(Auth::guard('admin')->user()->email);

});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'login']);



Route::group(['prefix' => 'pyb'], function () {
  # DASHBOARD SUPERADMIN
  Route::get('/super-admin', function () { return view('super-admin.home'); });
  Route::get('/super-admin/dashboard', function () { return view('super-admin.home'); });

  # DASHBOARD SUPERADMIN
  
  # DASHBOARD ADMIN
  Route::get('/admin', function () { return view('admin.home'); });
  Route::get('/admin/news_feed', function () { return view('admin.home'); });
  Route::get('/admin/news_feed/create', function () { return view('admin.home'); });
  Route::get('/admin/user_manager/{id?}', function () { return view('admin.home'); });
  Route::get('/admin/user_manager/{id?}/create', function () { return view('admin.home'); });
  Route::get('/admin/content_manager', function () { return view('admin.home'); });
  # DASHBOARD ADMIN
});
