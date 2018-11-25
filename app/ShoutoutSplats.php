<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShoutoutSplats extends Model
{
	/*
		Enter the shoutout, splat id  and user id in database
	*/
	public function save_shoutout_assoc($shoutout_user_id, $user_id, $splat_id){
		$this->shoutout_user_id = $shoutout_user_id;
		$this->splat_id = $splat_id;
		$this->user_id = $user_id;
		$this->save();
	}
}
