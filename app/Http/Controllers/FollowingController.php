<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FollowingController extends Controller
{

		private $guard_type;

		public function __construct()
		{
					$this->middleware('web');
					$this->guard_type = 'web';
		}

    public function follow_user(Request $request){

			$arr = array("data" => "SUCCESSFUL!");

			return json_encode($arr);

		}
}
