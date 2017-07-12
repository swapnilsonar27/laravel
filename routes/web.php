<?php

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

/*Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes();

//Route::get('/home', 'HomeController@index');
Route::post('signup', 'AuthenticateController@signUp');
Route::post('signin', 'AuthenticateController@signIn');
Route::post('signout', 'AuthenticateController@signOut');
Route::get('verify/{token}', 'AuthenticateController@verifyToken');
Route::resource('profile', 'ProfileController');
Route::resource('portfolio', 'PortfolioController');
Route::post('business/location', 'BusinessController@setupLocation');
Route::post('business/available', 'BusinessController@setupAvailability');
Route::post('business/unavailable', 'BusinessController@setupUnavailability');
Route::post('business/service', 'BusinessController@setupService');
Route::post('business/preference', 'BusinessController@setupPreference');
Route::get('business/location/{id}', 'BusinessController@getLocation');
Route::get('business/available/{id}', 'BusinessController@getAvailability');
Route::get('business/unavailable/{id}', 'BusinessController@getUnavailability');
Route::get('business/service/{id}', 'BusinessController@getService');
Route::get('business/preference/{id}', 'BusinessController@getPreference');
Route::put('account/{id}', 'ProfileController@updateAccount');
Route::get('booking', 'BookingController@getBookings');
Route::post('booking', 'BookingController@confirmBooking');
Route::post('device', 'NotificationController@saveDeviceId');
Route::post('account/payout', 'ProfileController@updatePayoutDetails');
Route::get('account/payout/{id}', 'ProfileController@getPayoutDetails');
Route::post('message', 'ChatController@store');
Route::get('message', 'ChatController@getMessages');

