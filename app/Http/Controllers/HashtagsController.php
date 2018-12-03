<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\AuthHelpers;
use App\Helpers\SplatHelpers;
use App\Helpers\HtmlHelpers;

use App\Splats;
use App\Hashtags;
use App\HashtagSplats;
use App\Following;
use App\SplatLikes;

class HashtagsController extends Controller
{

		use AuthHelpers;
		use SplatHelpers;
		use HtmlHelpers;
		private $guard_type;


		public function __construct()
		{
			$this->guard_type = 'web';
		}

    public function show_hash_tag(Request $request){
			//check if the hashtag is in the dbase
			$hashtag = $request->hashtag;

			$user = $this->check_and_get_user('web');
			$guard_type = $this->guard_type;
			return view('hashtags',compact('user','guard_type','hashtag'));
		}


		//get the splats for a specific hashtag and return the json collection
		public function get_hashtag_splats($hashtag_text, Hashtags $hashtags, HashtagSplats $hashtag_splats, Following $following, SplatLikes $splat_likes){
			$user = $this->check_and_get_user('web');
			$user_id = $user ? $user->id : false;

			//check for sql injection
			$hash_get = $hashtags->where('hashtag','=','#'.$hashtag_text)->get();

			if($hash_get){
				//splat and user information
				$hashtag_splats_get = $this->get_raw_splats($hash_get[0]->id, $hashtag_splats);

				//turn hashtags and shoutouts and other elements into urls
				$hashtag_splats_get = $this->process_splat_inline_urls($hashtag_splats_get, $user_id, $following, $splat_likes);

				//insert the username preceding the splat
				return($hashtag_splats_get);
			}
			else{
				//change to single-element json "No splats to see here".
				return false;
			}

		}

		//get the splats that relate to this hashtag.
		//also get the user information for these splats
		public function get_raw_splats($hashtag_id, HashtagSplats $hashtag_splats){

			//change to prepared statement to prevent injection - also move to HashtagSplats model
			$hashtag_splats_get = $hashtag_splats
						->join('splats','hashtag_splats.splat_id','=','splats.id')
						->join('users','hashtag_splats.user_id','=','users.id')
						->selectRaw('splats.splat as splat, splats.id as splat_id, splats.created_at as splat_created, users.id as userid, users.username as username, users.name as userfullname, users.profile_image as user_image')
						->where('hashtag_splats.hashtag_id', '=', $hashtag_id)
						->orderByRaw('splats.created_at desc')
						->paginate(config('constants.splat_page_limit'));

			return $hashtag_splats_get;
		}


}
