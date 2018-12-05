<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Splats;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Hashtags;
use App\HashtagSplats;
use App\ShoutoutSplats;
use App\SplatLikes;

use App\Helpers\AuthHelpers;
use App\Helpers\SplatHelpers;
use App\Helpers\HtmlHelpers;

/*
		Controller to manage customer-specific splats
*/

class CustomerSplatsController extends Controller
{
	use HtmlHelpers;
	use AuthHelpers;
	use SplatHelpers;


	private $guard_type;

	public function __construct()
	{
        $this->middleware('web');
				$this->guard_type = 'web';
	}

	/*
		Receive a Splat from the entry form
		Check that user exists and logged in
		Submit a 140 character splat to the database
	*/
	public function submit_splat(Request $request, Splats $splats, User $user){

		$this->validate($request, [
			'splat' => 'required|min:10|max:' . config('constants.splat_limit') ,
		]);



		//check that the user is logged in
		$user = $this->check_and_get_user('web');
		$guard_type = $this->guard_type;

		//clean up splat - remove obscenities
		$splat_clean = $this->clean_splat_input($request->splat);

		//finds hashtags in string and returns array of hashtags && //remove duplicate hashtags
		$hashtags_get_array = $this->find_hashtags($request->splat);
		$hashtags_get_array = array_unique($hashtags_get_array);

		//set hashtags to lowercase in splat
		$lower_splat_hashes = $this->inline_elements_lower_assign($hashtags_get_array);
		$splat_clean = $this->replace_in_splat($splat_clean, $lower_splat_hashes);

		//find shoutouts in splat && remove duplicate
		$shoutouts_get_array = $this->find_shoutouts($request->splat);
		$shoutouts_get_array = array_unique($shoutouts_get_array);

		//set shoutouts to lower case in splat
		$lower_shoutout_hashes = $this->inline_elements_lower_assign($shoutouts_get_array);
		$splat_clean = $this->replace_in_splat($splat_clean, $lower_shoutout_hashes);

		//check and save the splat to db with correct user id
		$splats->splat = $splat_clean;
		$splats->user_id = $user->id;
		$splats->save();

		//now process the hashtags
		$this->process_hash_tag_inputs($hashtags_get_array, $splats->id, $user->id);

		//now process shoutouts
		$this->process_shoutout_inputs($shoutouts_get_array, $splats->id, $user->id, $user);

		session()->flash('message', $user->name . '. Your splat has been posted!');

		return redirect()->route('home');

	}


	private function process_shoutout_inputs($shoutouts_get_array, $splat_id, $user_id, $user_model){
		/*
			loop through shoutouts
			check if user exists in dbase
			if exists then add to the databse
		*/

		foreach($shoutouts_get_array as $shout){
			//get data from database - find the user corresponding to the shoutout
			$username = str_replace('@','',$shout);
			$username = strtolower($username);
			$shoutout_user_get = $user_model->where('username', $username)->first();

			//if exists then add to db
			if($shoutout_user_get){
				$shoutout_splats = new ShoutoutSplats;
				$shoutout_splats->save_shoutout_assoc($shoutout_user_get->id, $user_id, $splat_id);
			}

		}

	}

	//loop through the current hashtags and insert hashtags into the dbase
	private function process_hash_tag_inputs($hashtags_get_array, $splat_id, $user_id){
		foreach($hashtags_get_array as $hash){
			$hashtags = new Hashtags;
			$hashtag_splats = new HashtagSplats;

			$hash = strtolower($hash);
			$hash_id = $hashtags->hashtag_exists_enter($hash);

			//now add the hashtag associations
			$hashtag_splats->save_hashtag_assoc($hash_id, $user_id, $splat_id);
		}
	}

	private function clean_splat_input($splat){
		$splat_clean = strip_tags($splat);

		$splat_clean = str_ireplace("fuck","F_CK",$splat_clean);
		$splat_clean = str_ireplace("shit","SH_T",$splat_clean);
		$splat_clean = str_ireplace("asshole","AS_HOLE",$splat_clean);
		$splat_clean = str_ireplace("nigger","N_R",$splat_clean);
		$splat_clean = str_ireplace("faggot","F_T",$splat_clean);

		return $splat_clean;
	}



	/*
		First find max
		Get splats in lots of 5 for the current user
		Order splats by date - descending
		return splats
		get pagination for splats
		return next set of splats from pagination if the pagination is not null

	*/

	//gets splats for ajax
	public function get_your_splats(Splats $splats, User $user, SplatLikes $splat_likes){
		$user = $this->check_and_get_user('web');

		$splats_get = $this->get_splats($user->id, $splats);

		//turn shoutouts and hashtags into urls
		$splats_get = $this->process_splat_inline_urls($splats_get, $user->id, false, $splat_likes);

		return $splats_get;
	}


	//use this only for pure api
	public function get_splats($user_id, Splats $splats){
		$splats_get = $splats->where('user_id','=',$user_id);
		$splats_get = $splats_get->orderBy('created_at','desc');
		$splats_get = $splats_get->paginate(config('constants.splat_page_limit'));

		return $splats_get;
	}






}
