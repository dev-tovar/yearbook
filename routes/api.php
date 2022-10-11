<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Api'], function () {
  Route::group(['middleware' => 'jwt.auth'], function () {
      Route::group(['prefix' => 'social'], function () {
          Route::get('/', 'SocialController@get');
          Route::post('/attach/{provider}', 'SocialController@attach');
          Route::delete('/{provider}', 'SocialController@remove');
      });
  });

  Route::group(['prefix' => 'common'], function () {
      Route::get('/version', 'CommonController@getCurrentVersion');
  });
  Route::post('/image', 'ImageController@store');
  Route::post('image-bin', 'ImageController@storeBin');
  Route::post('/image/feeds', 'ImageController@feeds');

  Route::get('get/career', 'CareerController@get');

  Route::group(['prefix' => 'auth'], function () {
      Route::post('login', 'AuthController@login');
      Route::post('logout', 'AuthController@logout');
      Route::post('registration', 'AuthController@registration');
      Route::post('check_child', 'AuthController@checkChild');
  });

  Route::group(['prefix' => 'user'], function () {
      Route::group(['middleware' => 'jwt.auth'], function () {
          Route::get('ids/{userId?}', 'UserController@getIds');
          Route::post('ids/attach/{userId?}', 'UserController@attachId');
          Route::get('notifications/{id?}', 'NotificationController@index');
          Route::get('notifications/{id}/read', 'NotificationController@read');
          Route::delete('notifications/{id}', 'NotificationController@destroy');
          Route::post('privacy', 'UserController@savePrivacy');
          Route::post('profile', 'AlumniController@store');

      });
      Route::get('alumni-list', 'AlumniController@index');

      Route::group(['prefix' => 'settings'], function () {
          Route::post('change_password', 'SettingsController@password');
          Route::post('forgot_password', 'SettingsController@forgot');
          Route::post('setDeviceToken', 'SettingsController@setDeviceToken');
          Route::delete('deleteDeviceToken', 'SettingsController@deleteDeviceToken');
          Route::group(['middleware' => 'jwt.auth'], function () {
              Route::post('notification', 'SettingsController@notification');
              Route::post('email', 'SettingsController@changeEmail');
          });
      });
      Route::get('get/{child_id?}', 'UserController@get');
      Route::get('notifications-count', 'UserController@getMessagesCount');
      Route::delete('deleteChild/{child_id}', 'UserController@deleteChild');
      Route::post('addChild', 'UserController@addChild');
      Route::post('attach-careers', 'CareerController@attach');
  });

  Route::group(['prefix' => 'alumni'], function () {
      Route::get('messages-count/{school_id}', 'AlumniController@getMessagesCount');
  });

  Route::get('/v2/feeds/get/{child_id?}', 'NewsFeedController@get2');

  Route::group(['prefix' => 'feeds'], function () {
      Route::get('get/{child_id?}', 'NewsFeedController@get');

      Route::get('alumni/{school_id}', 'AlumniMessagesController@get');
      Route::get('alumni/messages/{id}/read', 'AlumniMessagesController@read');
      Route::delete('alumni/messages/{id}', 'AlumniMessagesController@destroy');

  });

  Route::group(['prefix' => 'events'], function () {
      Route::get('get/{child_id?}', 'EventsAlumniController@get');
      Route::post('confirmation', 'EventsAlumniController@confirm');
  });

  Route::group(['prefix' => 'info'], function () {
      Route::post('contact', 'ContactsController@store');
      Route::get('get', 'DataController@get');
      Route::group(['prefix' => 'get'], function () {
          Route::get('schools', 'DataController@getSchools');
          Route::get('cities', 'DataController@getCities');
          Route::get('states', 'DataController@getStates');
          Route::get('reasons', 'DataController@getReasons');
          Route::get('terms', 'DataController@getUserTerms');
          Route::get('policy', 'DataController@getUserPolicy');
      });
  });

  Route::group(['middleware' => 'jwt.auth'], function () {
      Route::get('feeds/{id}/view', 'NewsFeedController@view');
      Route::get('/like/{id}', 'LikeController@make');
      Route::post('/mark-image', 'MarkImageController@make');
      Route::post('/mark-image-confirm/{id}', 'MarkImageController@confirm');
      Route::get('/mark-image/user_list', 'MarkImageController@userList');
      Route::get('/get-mark', 'MarkImageController@getMark');
      Route::group(['prefix' => 'yearbook'], function () {
          Route::post('/wall', 'WallController@store');
          Route::post('wall-invite', 'WallController@storeWallInvite');
          Route::get('/wall/{id}/approve', 'WallController@approve');
          Route::get('/wall/{id}/decline', 'WallController@decline');
          Route::delete('/wall/{id}', 'WallController@delete');
          Route::get('/{yearbook}/likes/{id}', 'LikeController@index');
          Route::get('/my/{child_id?}', 'YearbookController@my');
          Route::get('/available/{child_id?}', 'YearbookController@available');
          Route::post('/buy', 'YearbookController@buy');
          Route::get('/{id}', 'YearbookController@show');
          Route::get('/{id}/profile/my/{child_id?}', 'YearbookProfileController@my');
          Route::get('/{id}/profile/show/{child_id}', 'YearbookProfileController@show');
          Route::put('/profile', 'YearbookProfileController@update');
          Route::get('/{id}/invite/list', 'InviteController@userList');
          Route::get('/{id}/notifications', 'YearbookNotificationController@index');
          Route::get('{id}/notifications/count', 'YearbookNotificationController@count');
          Route::post('/notifications/read', 'YearbookNotificationController@read');
          Route::delete('/notifications/{id}', 'YearbookNotificationController@destroy');
          Route::post('/invite', 'InviteController@store');
          Route::get('{yearbookId}/student_tribute/my/{studentId?}', 'StudentTributeController@my');
          Route::get('{yearbookId}/student_tribute/categories/{studentId}', 'StudentTributeController@categories');
          Route::post('student_tribute/buy', 'StudentTributeController@buy');
      });
  });

  Route::group(['prefix' => 'yearbook'], function () {
      Route::get('/profile/sports', 'YearbookProfileController@sports');
      Route::get('/profile/future_attending', 'YearbookProfileController@futureAttending');
      Route::get('/profile/future_aspirations', 'YearbookProfileController@futureAspirations');
  });

  Route::group(['prefix' => 'donate', 'middleware' => 'api.auth'], function () {
      Route::get('get-props', 'DonateController@openLending');
      Route::post('pay', 'DonateController@pay');
      Route::get('bank-account', 'BankController@get');
  });

});

Route::group(['namespace' => 'Api', 'prefix' => 'v2'], function () {
  Route::group(['prefix' => 'yearbook', 'middleware' => 'jwt.auth'], function () {
      Route::get('/{id}', 'YearbookController@showV2');
      Route::get('/category/{category_id}/pages', 'YearbookController@getPages');
      Route::get('/pages/{page_id}', 'YearbookController@getPageInfo');
  });

  Route::group(['prefix' => 'user'], function () {
      Route::group(['prefix' => 'settings'], function () {
          Route::post('setDeviceToken', 'SettingsController@setDeviceTokens');
          Route::post('deleteDeviceToken', 'SettingsController@deleteDeviceToken');
      });
  });
});

