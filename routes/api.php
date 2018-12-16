<?php

use Illuminate\Http\Request;

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

//http://127.0.0.1:8000/api/auth/user

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::get('login', function () {
        $user = false;



        return view('welcome',compact('user'));
    });
    Route::post('signup', 'AuthController@signup');
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});



/*

Client ID: 1
Client Secret: owpO4SPTLp3XBWveVT4QvszuovtYsjyTH08ZpLhl
Password grant client created successfully.
Client ID: 2
Client Secret: RrmqrfRh9AP524PZk3JmIe2daM0kWh0PFJhu44xb


*/
