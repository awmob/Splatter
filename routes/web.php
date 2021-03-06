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

Route::get('/user-get-api/{username}','UserController@single_user_get_api')->name('user_getter');


//get single user details json
Route::get('user-info-get/{user_id}','UserController@get_single_user')->name('user_info');

//follow a user
Route::post('follow_user_ajax','FollowingController@follow_user')->middleware('auth');
Route::delete('unfollow_user_ajax','FollowingController@unfollow_user')->middleware('auth');

//like posts
Route::post('like-splat','SplatLikesController@like_splat')->middleware('auth');
Route::delete('unlike-splat','SplatLikesController@like_splat')->middleware('auth');
Route::get('get-like-count/{splat_id}','SplatLikesController@get_like_count_ajax')->middleware('auth');

//Login and auth related
Route::post('/customer-login', 'Auth\LoginController@login')->name('customer.login');
Route::get('/customer-logout', 'Auth\LoginController@logout')->name('customer.logout');

Route::post('/submit-splat', 'CustomerSplatsController@submit_splat')->name('customer.submit.splat')->middleware('auth');
Route::get('/customer-splats', 'CustomerSplatsController@get_your_splats')->name('customer.get_splats')->middleware('auth');


//show followers and following
Route::get('/followers', 'FollowingController@show_followers')->name('show.followers')->middleware('auth');
Route::get('/following', 'FollowingController@show_following')->name('show.following')->middleware('auth');

//show followers and following
Route::get('/followers/{username}', 'FollowingController@show_followers_uid')->name('show.followers.uid')->middleware('auth');
Route::get('/following/{username}', 'FollowingController@show_following_uid')->name('show.following.uid')->middleware('auth');

Route::get('/ajax_following/{user_id}','FollowingController@get_following_ajax')->middleware('auth');
Route::get('/ajax_followers/{user_id}','FollowingController@get_followers_ajax')->middleware('auth');

Route::prefix('admin')->group(function() {
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login')->middleware('guest:admin');
    Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/home', 'AdminController@index')->name('admin.home')->middleware('auth:admin');
});

//
