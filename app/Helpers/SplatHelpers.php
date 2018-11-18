<?php

	namespace App\Helpers;


	trait SplatHelpers{

		/*
			Finds hashtags in string which have at least one succeeding alpha-numeric character
		*/
		public function find_hashtags($splat){
			//regex to find tweets
			preg_match_all("/(#\w+)/", $splat, $hashtags);
			return $hashtags[0];
		}
	}
