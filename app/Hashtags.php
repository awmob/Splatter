<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Hashtags extends Model
{

		//processes hash tags into the database
    public function process_hash_tags($hash_tags_array, $splat_id, $user_id, $hashtag_splats){
			if(sizeof($hash_tags_array) > 0){
				//check if the hashtags have been entered into database
				foreach($hash_tags_array as $hash){
					$hash = strtolower($hash);
					$hash_id = $this->hashtag_exists_enter($hash);

					//now add the hashtag associations
					$hashtag_splats->save_hashtag_assoc($hash_id, $user_id, $splat_id);
				}
			}
		}

		//checks if hashtag exists in the database, if so then get id, if not
		//enter and get id
		private function hashtag_exists_enter($hashtag){
			$hash_get = $this->where('hashtag', '=', $hashtag)->get();

			if(sizeof($hash_get) > 0){
				return $hash_get[0]->id;
			}
			else{
				$this->hashtag = $hashtag;
				$this->save();
				return $this->id;
			}
		}


}
