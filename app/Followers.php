<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Followers extends Model
{


    public function new_follower($follow_user, $follower_user_id){
			$this->user_id = $follow_user;
			$this->follower_user_id = $follower_user_id;
			$this->save();
		}


}
