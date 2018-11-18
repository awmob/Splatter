<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AuthHelpers;
use App\Splats;


use Illuminate\Http\Request;

class HomeController extends Controller
{

		use AuthHelpers;
		private $guard_type;

		public function __construct()
		{
			$this->guard_type = 'web';
		}

		//display the home page.
		//not logged in show login page
		//if logged in show splat send page and show logged in as info
    public function home_show(Splats $splats)
		{

			//check if user is logged in and get user info if logged in, false if not
			//if(Auth::check() ){
			$user = $this->check_and_get_user('web');
			$guard_type = $this->guard_type;
			if($user){
				$splats_get = $splats->get_splats($user->id);
			}
			else{
				$splats_get = false;
			}

			return view('welcome',compact('user','guard_type','splats_get'));
		}
}
