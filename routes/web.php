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

//dd(session()->all());

/*
NOTE

Changed:
Illuminate\Foundation\Exceptions\Handler::unauthenticated($request, Illuminate\Auth\AuthenticationException

Changed:

this sets default auth routes
laravel/framework/src/Illuminate/Routing/Router.php
*/

Route::get('/', 'HomeController@home_show')->name('home');

//hashtag related pages
Route::get('/hashtag/{hashtag}', 'HashtagsController@show_hash_tag')->name('hashtag');
Route::get('/hashtag-splats/{hashtag}', 'HashtagsController@get_hashtag_splats')->name('hashtag_get_splats');   //for json

//show user
Route::get('/profile/{username}','UserController@show_user_profile')->name('user_profile');

//get single user details json
Route::get('user-info-get/{user_id}','UserController@get_single_user')->name('user_info');

//follow a user
Route::post('follow_user_ajax','FollowingController@follow_user')->middleware('auth');


//Login and auth related
Route::post('/customer-login', 'Auth\LoginController@login')->name('customer.login');
Route::get('/customer-logout', 'Auth\LoginController@logout')->name('customer.logout');

Route::post('/submit-splat', 'CustomerSplatsController@submit_splat')->name('customer.submit.splat')->middleware('auth');
Route::get('/customer-splats', 'CustomerSplatsController@get_your_splats')->name('customer.get_splats')->middleware('auth');




Route::prefix('admin')->group(function() {
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login')->middleware('guest:admin');
    Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/home', 'AdminController@index')->name('admin.home')->middleware('auth:admin');
});

//
