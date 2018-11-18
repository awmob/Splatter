<?php

	namespace App\Helpers;
	use Illuminate\Support\Facades\Auth;

	trait AuthHelpers{

		public function check_and_get_user($type){
			if(Auth::guard($type)->check())
			{
				 $user = Auth::user();
			}
			else{
				$user = false;
			}

			return $user;
		}

		

	}
