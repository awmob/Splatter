<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Splats;
use App\Following;
use App\SplatLikes;

use App\Helpers\AuthHelpers;
use App\Helpers\SplatHelpers;
use App\Helpers\HtmlHelpers;

class UserController extends Controller
{

		use AuthHelpers;
		use SplatHelpers;
		use HtmlHelpers;
		private $guard_type;

		public function __construct(){
			$this->guard_type = 'web';
		}

    public function show_user_profile(Request $request, User $user_model, Splats $splats, Following $following){

			//check logged in user details
			$user = $this->check_and_get_user('web');

			//redirect to home page if the user and the search term are the same
			if($user){
				if($user->username == $request->username){
					return redirect()->route('home');
				}
			}

			//Get profile user details
			$user_get = $user_model->public_single_user_get($request->username);

			//if the user exists, display the user profile page
			if($user_get){
				//set guard
				$guard_type = $this->guard_type;

				//check that splats exist for that profile
				$splats_get = $splats->check_splats_exist($user_get->id);

				//get number of followers and following and show
				$user_get->following = $following->get_users_you_are_following_count($user_get->id);
				$user_get->followers = $following->get_your_followers_count($user_get->id);

				return view('public_profile', compact('guard_type','user','user_get','splats_get'));
			}
			//the reuested profile doesn't exist so tell the user and return to the home page
			else{
				$non_user = "@" . $request->username;
				session()->flash('message', $non_user . ' doesn\'t Splat on Splatter.');
				return redirect()->route('home');
			}

		}

		public function get_single_user(Request $request, User $user_model, Following $following, SplatLikes $splat_likes){
			$user = $this->check_and_get_user('web');
			$user_id = $user ? $user->id : false;

			//first get the user data
			$user_splats_get = $user_model->single_user_get_api($request->user_id);

			//turn shoutouts and hashtags into urls
			$user_splats_get = $this->process_splat_inline_urls($user_splats_get, $user_id, $following, $splat_likes);


			return $user_splats_get;
		}

		//get single user details to pass to api
		public function single_user_get_api(User $user, $username){
			$user_get = $user->public_single_user_get($this->remove_ampher($username));

			if($user_get){
				$user_get->success = true;
				return $user_get;
			}
			else{
				return json_encode(['success' => false]);
			}		
		}
}
