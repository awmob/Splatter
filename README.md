# laravel_oauth_basic
##  Laravel Api Oauth & Passport - Basic Structure

*This creates a basic bare-bones structure to create an API Oauth system in Laravel. Modified from* https://medium.com/modulr/create-api-authentication-with-passport-of-laravel-5-6-1dc2d400a7f  <br>

STEPS: 
-------------------------------------------------------------------------------------------------------- 
1. Command line

			laravel new apitest
-------------------------------------------------------------------------------------------------------- 
2. Command line

			cd apitest

			composer require laravel/passport
-------------------------------------------------------------------------------------------------------- 
3. Manually create a database in mysql

Add a user

Add database info to .env file

--------------------------------------------------------------------------------------------------------
4. Command line 

			php artisan migrate

--------------------------------------------------------------------------------------------------------
5. Command line 

			php artisan passport:install

			Record the keys that appear on screen

--------------------------------------------------------------------------------------------------------
6. In App\User model:
	

			use Laravel\Passport\HasApiTokens;

and in class declaration: 

			use Notifiable, HasApiTokens;
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
10.  Add a new controller in command line:

			php artisan make:controller AuthController



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

Run Laravel dev server with:

			php artisan serve

We can now test with Postman or Chrome Advanced Rest Client.

Let's try an example where we register a new user. Open Chrome Advanced Rest Client:

## New User Registration Example

Request URL:				
				http://127.0.0.1:8000/api/auth/signup

Header Name: 				
				accept
Header Value: 				
				application/json

Header Name: 				
				Content-Type
Header Value: 				
				application/json

Method: 				
				Post

Body: 

				{
				  "email": "tester@tester.com",
				  "name": "tester",
				  "password": "12345678",
				  "password_confirmation": "12345678"
				}

Press "Send"

If the request is successful, the response will be:

				{
				"message": "Successfully created user!"
				}

## User Login Example

Using the login information for the user we just registered, use the following:

Request URL:				
				http://127.0.0.1:8000/api/auth/login

Header Name: 				
				accept
Header Value: 				
				application/json

Header Name: 				
				Content-Type
Header Value: 				
				application/json

Method: 				
				Post

Body: 

				{
				  "email": "tester@tester.com",
				  "password": "12345678",
				  "remember_me":true
				}

Press "Send"

If the request is successful, the response will be something like:

				{
				"access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjZhMTY1OGVjYWNhMTA1M2ViNjFhYTQ1N2E4N2MzMzAxOGNhMjU2OWEyNGY3NTZhOTlmNzFmMDNmNGMzNmFhNTg3YWE2OTA2NzExNGM3OWQzIn0.eyJhdWQiOiIxIiwianRpIjoiNmExNjU4ZWNhY2ExMDUzZWI2MWFhNDU3YTg3YzMzMDE4Y2EyNTY5YTI0Zjc1NmE5OWY3MWYwM2Y0YzM2YWE1ODdhYTY5MDY3MTE0Yzc5ZDMiLCJpYXQiOjE1NDIwMTg0NjYsIm5iZiI6MTU0MjAxODQ2NiwiZXhwIjoxNTczNTU0NDY2LCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.SVdO40jDSvkDueKTcNDcsAbUOmyPm93oUhWNWrym8Mtmh1hwgokXB2mN1mYr2uqg-oSV3nWjBTZdC00Z9Panu9pG2HOO_pAqL97BdrCxu5Whr_mdJeVpQxaygM_8u5q5eZNCZuLgRuZwjHev3Ai82LHE_Akx6D_N2GO6uqmlhcxh0VHJrMFNsSawOt_2sSSpeIklZKCnDYcCOeF5K1i1I5rB0f9MubJzW80-l-92JgaRVkIfy9IqmtB5wXCV8XF8_LpZY2HGXgYKoJgPNhqPm2BidpAR56GJg2mO0f2IrccjtYh6ObB1I0l7BW2hRVnqqL9GDEro63T3iDOrLy_0vfqLlayuXczh23ZIi31vSxeF-nfaB2lDi6NmRnhPdWEWY8EMdVA1Ti7rWOKPVrSJOl9z4-H3irJqzCVwgydpnOFU1g-O4riLi-W6LpgcxK9cWbjWFYbv_3DQ74tOrx7bUj-7Gx0XDlr4esoLzIVRJawLsWoVOOnsoyQPbOG0mgeLKn9V_52B1C3SArTAO5AZRcxPDrXR_Y5FG-EtKXQk1QJNuHf8QORb0hlJwjr-4qjTyc0QIDHRCX1D8Tbj8R0PDS0Q_rS8jnGA3cNlZ1a5nLJ3uez7RPLg--fOSHrZbROpC53yIUvH9nHQ_XYU3ADl6ri0pgoSK9T2yGXQ98GWLwc",
				"token_type": "Bearer",
				"expires_at": "2018-11-19 10:27:46"
				}

This temporary access token should be stored in a secure manner for use during the session. 

## User Logout Example

Using the login information for the user we just registered, use the following:

Request URL:				
				http://127.0.0.1:8000/api/auth/logout

Header Name: 				
				accept
Header Value: 				
				application/json

Header Name: 				
				Content-Type
Header Value: 				
				application/json

Header Name: 				
				Authorization
Header Value: 				
				Bearer 			eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjZhMTY1OGVjYWNhMTA1M2ViNjFhYTQ1N2E4N2MzMzAxOGNhMjU2OWEyNGY3NTZhOTlmNzFmMDNmNGMzNmFhNTg3YWE2OTA2NzExNGM3OWQzIn0.eyJhdWQiOiIxIiwianRpIjoiNmExNjU4ZWNhY2ExMDUzZWI2MWFhNDU3YTg3YzMzMDE4Y2EyNTY5YTI0Zjc1NmE5OWY3MWYwM2Y0YzM2YWE1ODdhYTY5MDY3MTE0Yzc5ZDMiLCJpYXQiOjE1NDIwMTg0NjYsIm5iZiI6MTU0MjAxODQ2NiwiZXhwIjoxNTczNTU0NDY2LCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.SVdO40jDSvkDueKTcNDcsAbUOmyPm93oUhWNWrym8Mtmh1hwgokXB2mN1mYr2uqg-oSV3nWjBTZdC00Z9Panu9pG2HOO_pAqL97BdrCxu5Whr_mdJeVpQxaygM_8u5q5eZNCZuLgRuZwjHev3Ai82LHE_Akx6D_N2GO6uqmlhcxh0VHJrMFNsSawOt_2sSSpeIklZKCnDYcCOeF5K1i1I5rB0f9MubJzW80-l-92JgaRVkIfy9IqmtB5wXCV8XF8_LpZY2HGXgYKoJgPNhqPm2BidpAR56GJg2mO0f2IrccjtYh6ObB1I0l7BW2hRVnqqL9GDEro63T3iDOrLy_0vfqLlayuXczh23ZIi31vSxeF-nfaB2lDi6NmRnhPdWEWY8EMdVA1Ti7rWOKPVrSJOl9z4-H3irJqzCVwgydpnOFU1g-O4riLi-W6LpgcxK9cWbjWFYbv_3DQ74tOrx7bUj-7Gx0XDlr4esoLzIVRJawLsWoVOOnsoyQPbOG0mgeLKn9V_52B1C3SArTAO5AZRcxPDrXR_Y5FG-EtKXQk1QJNuHf8QORb0hlJwjr-4qjTyc0QIDHRCX1D8Tbj8R0PDS0Q_rS8jnGA3cNlZ1a5nLJ3uez7RPLg--fOSHrZbROpC53yIUvH9nHQ_XYU3ADl6ri0pgoSK9T2yGXQ98GWLwc

Method: 				
				Get

The long string in the Authorization header is identical to the access token recorded at login in the previous step.

Press "Send"

If the request is successful, the response will be:

				{
				"message": "Successfully logged out"
				}


--------------------------------------------------------------------------------------------------------

There you have it - a super-quick and easy way to establish a basic Oauth server using Laravel and Passport. You can easily build upon this. 

Until next time, tata!















	
