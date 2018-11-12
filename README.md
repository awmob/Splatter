# laravel_oauth_basic
##  Laravel Api Oauth & Passport - Basic Structure

*This creates a basic bare-bones structure to create an API Oauth system in Laravel. Modified from* https://medium.com/modulr/create-api-authentication-with-passport-of-laravel-5-6-1dc2d400a7f 

STEPS:
--------------------------------------------------------------------------------------------------------
1. Command line
```laravel new apitest ```
--------------------------------------------------------------------------------------------------------
2. Command line 
```cd apitest```
```composer require laravel/passport```
--------------------------------------------------------------------------------------------------------
3. *Manually create a database in mysql
*Add a user
*Add database info to .env file
--------------------------------------------------------------------------------------------------------
4. Command line 
```php artisan migrate```
--------------------------------------------------------------------------------------------------------
5. Command line 
```php artisan passport:install```
Record the keys that appear on screen
--------------------------------------------------------------------------------------------------------
6. In App\User model:
	
```php
use Laravel\Passport\HasApiTokens;'''

and in class declaration: 
```php
			use Notifiable, HasApiTokens;'''
--------------------------------------------------------------------------------------------------------
7. In Provider/AuthServiceProvider:

			use Laravel\Passport\Passport;

			public function boot(){
				$this->registerPolicies();
				Passport::routes();
		    	}
--------------------------------------------------------------------------------------------------------
8. config/auth.php:

'guards' => [
    'web' => [
	'driver' => 'session',
	'provider' => 'users',
    ],
    'api' => [
	'driver' => 'passport',
	'provider' => 'users',
    ],
],
--------------------------------------------------------------------------------------------------------
9. routes/api.php

<?php

use Illuminate\Http\Request;

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
  
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});

--------------------------------------------------------------------------------------------------------
10.  php artisan make:controller AuthController



Add the following code to the new controller:

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;

class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $user->save();

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }
  
    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);

        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);

        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }
  
    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
  
    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}



--------------------------------------------------------------------------------------------------------



Basic application is complete. 













	
