<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\AuthHelpers;
use App\User;
use App\Following;


class FollowingController extends Controller
{

	/*

		in table: following_user_id = the person who is followed

	*/

		use AuthHelpers;
		private $guard_type;

		public function __construct()
		{
					$this->middleware('web');
					$this->guard_type = 'web';
		}

		//shows the people who the user is following
		public function show_following(Following $following){
				$follow_type = config('constants.following_page');

				$guard_type = $this->guard_type;
				$user = $this->check_and_get_user('web');

				$follow_url = url('ajax_following/'. $user->id);

				//get number of followers and following and show
				$user->following = $following->get_users_you_are_following_count($user->id);
				$user->followers = $following->get_your_followers_count($user->id);

				return view('follshow',compact('user','guard_type','follow_type','follow_url'));

		}

		//shows the people who are following the user
		public function show_followers(Following $following){
			$follow_type = config('constants.follower_page');

			$guard_type = $this->guard_type;
			$user = $this->check_and_get_user('web');

			$follow_url = url('ajax_followers/'. $user->id);

			//get number of followers and following and show
			$user->following = $following->get_users_you_are_following_count($user->id);
			$user->followers = $following->get_your_followers_count($user->id);

			return view('follshow',compact('user','guard_type','follow_type','follow_url'));
		}




		//shows the people who the user is following
		public function show_following_uid(Following $following, Request $request, User $user){
				$follow_type = config('constants.following_page');

				$guard_type = $this->guard_type;
				$user = $this->check_and_get_user('web');

				$user_get = $user->public_single_user_get($request->username);

				$follow_url = url('ajax_following/'. $user_get->id);

				//get number of followers and following and show
				$user_get->following = $following->get_users_you_are_following_count($user_get->id);
				$user_get->followers = $following->get_your_followers_count($user_get->id);

				return view('follshowuid',compact('user','user_get','guard_type','follow_type','follow_url'));

		}

		//shows the people who are following the user
		public function show_followers_uid(Following $following, Request $request, User $user){
			$follow_type = config('constants.follower_page');

			$guard_type = $this->guard_type;
			$user = $this->check_and_get_user('web');

			$user_get = $user->public_single_user_get($request->username);

			$follow_url = url('ajax_followers/'. $user_get->id);

			//get number of followers and following and show
			$user_get->following = $following->get_users_you_are_following_count($user_get->id);
			$user_get->followers = $following->get_your_followers_count($user_get->id);

			return view('follshowuid',compact('user','user_get','guard_type','follow_type','follow_url'));
		}

		//shows the people who the user is following
		public function get_following_ajax(Request $request, Following $following){
			$followings_get = $following->join('users','followings.following_user_id','=','users.id')
												->selectRaw('users.id as userid, users.username as username, users.name as userfullname, users.profile_image as user_image')
												->where('followings.user_id',$request->user_id)
												->orderByRaw('users.username asc')
												->paginate(config('constants.foll_page_limit'));
			return $followings_get;
		}


		//shows the people who are following the user
		public function get_followers_ajax(Request $request, Following $following){
			$followings_get = $following->join('users','followings.user_id','=','users.id')
												->selectRaw('users.id as userid, users.username as username, users.name as userfullname, users.profile_image as user_image')
												->where('followings.following_user_id',$request->user_id)
												->orderByRaw('users.username asc')
												->paginate(config('constants.foll_page_limit'));
			return $followings_get;
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
