<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HashtagSplats extends Model
{

	/*
		Enter the hashtag, splat id  and user id in database
	*/
	public function save_hashtag_assoc($hash_id, $user_id, $splat_id){
		$this->hashtag_id = $hash_id;
		$this->splat_id = $splat_id;
		$this->user_id = $user_id;
		$this->save();
	}

}
