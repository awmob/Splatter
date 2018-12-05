<?php

	namespace App\Helpers;

	trait SplatHelpers{

		//combined umbrella function to find and set html elements in splats
		private function process_splat_inline_urls($splats_get, $main_user_id, $following_model = false, $splat_like_model = false){
			for($i = 0; $i < sizeof($splats_get); $i++){
				//id hack for different return info from main user to non main user
				$splats_get[$i]->splat_id = $splats_get[$i]->splat_id ? $splats_get[$i]->splat_id : $splats_get[$i]->id;

				//inline elements
				$splats_get[$i]->splat = $this->process_single_splat_shoutouts($splats_get[$i]->splat);
				$splats_get[$i]->splat = $this->process_single_splat_hashtag_urls($splats_get[$i]->splat);

				//set user elements that appear above inline elements
				$html_link = $this->set_shoutout_url($splats_get[$i]->username, false);
				$splats_get[$i]->user_url = $html_link;

				$splats_get[$i]->created = $this->fix_date_time($splats_get[$i]->created_at);

				//set follow forms / links
				if($main_user_id){

					$splats_get[$i]->allow_follow = $main_user_id == $splats_get[$i]->userid ? false : true;
					//if true //check whether following or not
					if($following_model){
						$following_get = $following_model->get_following($main_user_id, $splats_get[$i]->userid);
						$splats_get[$i]->following = $following_get ? true : false;
					}

					//check if user has liked or not
					if($splat_like_model){
						$likes_check = $splat_like_model->check_like_exists($main_user_id, $splats_get[$i]->splat_id);
						$splats_get[$i]->liked = $likes_check ? true : false;
						$splats_get[$i]->likes_count = $splat_like_model->get_like_count($splats_get[$i]->splat_id);
					}

					$splats_get[$i]->main_user_id = $main_user_id;

				}
				//if not logged in then not allowed to follow nor set main id
				else{
					$splats_get[$i]->main_user_id = false;
					$splats_get[$i]->allow_follow = false;
				}

			}
			return $splats_get;
		}

		//presents time in nicer format
		private function fix_date_time($date_time){
			$date_fix = strtotime($date_time);
			$date_fix = date('d M, Y', $date_fix);


			return $date_fix;
		}


		//Finds hashtags in string which have at least one succeeding alpha-numeric character
		//returns an array of the hashtags
		public function find_hashtags($splat){
			//regex to find hashtags
			preg_match_all("/(#\w+)/", $splat, $hashtags);
			return $hashtags[0];
		}


		//Finds shoutouts in string which have at least one succeeding alpha-numeric character
		//returns an array of the shoutouts
		public function find_shoutouts($splat){
			//regex to find shoutouts
			preg_match_all("/(@\w+)/", $splat, $shoutouts);

			return $shoutouts[0];
		}

		//set to lowercase and also create array of original [$i][0] and new [$i][1]
		public function inline_elements_lower_assign($elements){
			$eler = array();
			for($i=0;$i<sizeof($elements);$i++){
				$eler[$i][0] = $elements[$i];
				$eler[$i][1] = strtolower($elements[$i]);
			}
			return $eler;
		}


		//loop through splats and process hashtags
		private function process_splat_shoutout_urls($splats_get){
			for($i = 0; $i < sizeof($splats_get); $i++){
				$splats_get[$i]->splat = $this->process_single_splat_shoutouts($splats_get[$i]->splat);
			}
			return $splats_get;
		}


		//processes the @shoutouts in a splat into urls
		private function process_single_splat_shoutouts($splat){
			//first get the shoutouts
			$shoutouts = $this->find_shoutouts($splat);

			//now process the shoutouts into array of shoutout / url pairings
			$shoutout_urls = $this->process_shoutout_urls($shoutouts);

			//now reassign the shoutouts in the splat to urls
			return $this->replace_in_splat($splat, $shoutout_urls);
		}


		//loops through hashtags and appends a hashtag url to the array elements
		private function process_shoutout_urls($shoutouts){
			$shouty = array();
			for($i=0;$i<sizeof($shoutouts);$i++){
				//set original element
				$shouty[$i][0] = $shoutouts[$i];

				//add url element - from Helpers/HtmlHelper Trait
				$shouty[$i][1] = $this->set_shoutout_url($shoutouts[$i]);
			}
			return $shouty;
		}



		//loop through splats and process hashtags
		private function process_splat_hashtag_urls($splats_get){
			for($i = 0; $i < sizeof($splats_get); $i++){
				$splats_get[$i]->splat = $this->process_single_splat_hashtag_urls($splats_get[$i]->splat);
			}
			return $splats_get;
		}


		//processes the hashtags in a splat into urls
		private function process_single_splat_hashtag_urls($splat){
			//first get the hashtags
			$hashtags = $this->find_hashtags($splat);

			//now process the hashtags into array of hashtag / url pairings
			$hashtag_urls = $this->process_hashtag_urls($hashtags);

			//now reassign the hashtags in the splat to urls
			return $this->replace_in_splat($splat, $hashtag_urls);
		}



		//loops through hashtags and appends a hashtag url to the array elements
		private function process_hashtag_urls($hashtags){
			$hashy = array();
			for($i=0;$i<sizeof($hashtags);$i++){
				//set original element
				$hashy[$i][0] = $hashtags[$i];

				//add url element - from Helpers/HtmlHelper Trait
				$hashy[$i][1] = $this->set_hashtag_url($hashtags[$i]);
			}
			return $hashy;
		}



		//loops through changes array and replaces the element [x][0] with [x][1]
		//$changes_array is [][] array - [x][0] is original el, [x][1] is new element
		private function replace_in_splat($splat, $changes_array){
			foreach($changes_array as $ch){

				//pattern matches all words with trailing word boundary and ignoring case
				$pattern = "/$ch[0]\b/iu";
				$splat = preg_replace($pattern, $ch[1], $splat);
			}
			return $splat;
		}




	}
