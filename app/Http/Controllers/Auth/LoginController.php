<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }


    public function login(Request $request){
      $this->validate($request, [
        'email' => 'required|email',
        'password' => 'required'
      ]);

      $remember = true;

      if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password], $remember)){



        return redirect()->intended(route('home'));
      }

      session()->flash('message', 'Those credentials do not match the users in our database...');
      return redirect()->back()->withInput($request->only('email','remember'));

    }


}
