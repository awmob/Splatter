<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Following extends Model
{


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




}
