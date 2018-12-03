<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\AuthHelpers;
use App\User;
use App\SplatLikes;
use App\Splats;

class SplatLikesController extends Controller
{

	use AuthHelpers;
	private $guard_type;

	public function __construct()
	{
				$this->middleware('web');
				$this->guard_type = 'web';
	}


	//like or unlike a splat depending on status - $request->tolike = true is like, false unlike
	public function like_splat(Request $request, Splats $splats, SplatLikes $splat_likes){
		$user = $this->check_and_get_user('web');
		//check that the splat exists
		$splat_get = $splats->find($request->splat_id);

		//if the splat exists
		if($splat_get){
			//check if already liked
			$splat_liked = $splat_likes->check_like_exists($user->id, $request->splat_id);
			//if not already liked then add and return success ,otherwise don't add and return fail
			if(!$splat_liked && $request->to_like){
				//like or unlike splat depending on status
				$splat_likes->add_splat_like($user->id, $request->splat_id);
				$status = array('success' => true);
				return json_encode($status);
			}
			else if($splat_liked && !$request->to_like){
				$splat_likes->remove_splat_like($user->id, $request->splat_id);
				$status = array('success' => true);
				return json_encode($status);
			}
			else{
				$status = array('success' => false);
				return json_encode($status);
			}
		}
		else{
			$status = array('success' => false);
			return json_encode($status);
		}

	}



	public function get_like_count_ajax(Request $request, SplatLikes $splat_likes){
		if($request->splat_id){
			$splat_likes_count = $splat_likes->get_like_count($request->splat_id);
			$status = array('success' => $splat_likes_count);
			return json_encode($status);
		}
		else{
			$status = array('success' => false);
			return json_encode($status);
		}
	}

}
