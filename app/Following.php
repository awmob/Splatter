<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Following extends Model
{
	/*

		in table: following_user_id = the person who is followed

	*/

		public function new_following($main_user_id, $followee_user_id){
			$this->user_id = $main_user_id;
			$this->following_user_id = $followee_user_id;
			$this->save();
		}

		public function get_following($main_user_id, $followee_user_id){
			$following_get = $this->where('user_id',$main_user_id)
												->where('following_user_id',$followee_user_id)->first();

			return $following_get;

		}

		public function remove_following($id){
			$this->find($id)->delete();
		}


		public function get_users_you_are_following_count($main_user_id){
			return $this->where('user_id',$main_user_id)
						->count();
		}

		public function get_your_followers_count($main_user_id){
			return $this->where('following_user_id',$main_user_id)
						->count();
		}




}
