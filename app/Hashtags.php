<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Hashtags extends Model
{



		//checks if hashtag exists in the database, if so then get id, if not
		//enter and get id
		public function hashtag_exists_enter($hashtag){
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
