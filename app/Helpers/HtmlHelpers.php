<?php

	namespace App\Helpers;

	trait HtmlHelpers{


		public function remove_hashtag($string){
			$string = str_replace("#","",$string);
			return $string;
		}

		//set hashtag inline html for individual splats
		public function set_hashtag_url($hashtag){
			$hashtag_clean = $this->remove_hashtag($hashtag);
			$url = url('hashtag/'.$hashtag_clean);
			$html = '<a href="'.$url.'">'.$hashtag.'</a>';
			return $html;
		}



		public function remove_ampher($string){
			$string = str_replace("@","",$string);
			return $string;
		}

		//set shoutout inline html for individual splats
		public function set_shoutout_url($shoutout, $ampher = true){
			if($ampher){
				$shoutout_clean = $this->remove_ampher($shoutout);
			}
			else{
				$shoutout_clean = $shoutout;
				$shoutout = "@" . $shoutout;
			}
			$url = url('profile/'.$shoutout_clean);
			$html = '<a href="'.$url.'">'.$shoutout.'</a>';
			return $html;
		}

		public function set_follow_link($user_id, $to_follow_id, $iteration = false){
			$id = "";
			$script = "";
			if($iteration){
				$id_name = "follow" . $iteration;
				$id = ' id="'.$id_name.'"';

				$script = "<script>document.getElementById('".$id_name."').addEventListener('click',() =>{ alert('clicked')});</script>";
				$script = "<script>console.log('clicked');</script>";
			}
			return false;
			return $link = '<div><div '.$id.' class="small follow">FOLLOW</div></div>' . $script;
		}


	}
