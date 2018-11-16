<?php

//namespace App\Http\Controllers;
namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    /**
     * Show the application’s login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
				$user = false;
        return view('authadmin.admin-login', compact('user'));
    }

    protected function guard(){
        return Auth::guard('admin');
    }

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = route('admin.home');

    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function __construct()
    {

        //$this->middleware('guest:admin')->except('logout');
    }


		public function login(Request $request){
			$this->validate($request, [
				'email' => 'required|email',
				'password' => 'required'
			]);

			$remember = true;

			if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $remember)){
				return redirect()->intended(route('admin.home'));
			}

			session()->flash('message', 'Those credentials do not match the users in our database...');
			return redirect()->back()->withInput($request->only('email','remember'));

		}


}
