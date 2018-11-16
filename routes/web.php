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

*/

Route::get('/', 'HomeController@home_show')->name('home');

Route::post('/customer-login', 'Auth\LoginController@login')->name('customer.login');

Route::get('/customer-logout', 'Auth\LoginController@logout')->name('customer.logout');

Route::post('/submit-splat', 'SplatsController@submit_splat')->name('customer.submit.splat')->middleware('auth');






Route::prefix('admin')->group(function() {
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login')->middleware('guest:admin');
    Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/home', 'AdminController@index')->name('admin.home')->middleware('auth:admin');
});

//
