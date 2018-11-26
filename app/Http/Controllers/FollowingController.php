<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\AuthHelpers;
use App\User;
use App\Following;


class FollowingController extends Controller
{

		use AuthHelpers;
		private $guard_type;

		public function __construct()
		{
					$this->middleware('web');
					$this->guard_type = 'web';
		}

		//follows a user
    public function follow_user(Request $request, User $user, Following $following){
			$user = $this->check_and_get_user('web');

			//check that the requested followee exists
			$followee_get = $user->first()->find($request->follow_user);

			if($followee_get){
				//if not already following, follow the user - add to following table and followers table
				if(!$following->get_following($user->id, $request->follow_user)){
					$following->new_following($user->id, $request->follow_user);
					$arr = array("success" => true);
				}
				else{
					$arr = array("success" => false);
				}
			}
			else{
				$arr = array("success" => false);
			}
			return json_encode($arr);

		}


		public function unfollow_user(Request $request, User $user, Following $following){

			$user = $this->check_and_get_user('web');

			//check that the requested followee exists
			$followee_get = $user->first()->find($request->follow_user);

			if($followee_get){
				//if following, unfollow the user by removing the entry from the table
				$following_get = $following->get_following($user->id, $request->follow_user);

				if($following_get){
					//unfollow
					$following->remove_following($following_get->id);
					$arr = array("success" => true);
				}
				else{
					$arr = array("success" => false);
				}
			}
			else{
				$arr = array("success" => false);
			}

			return json_encode($arr);

		}




}
