<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Splats;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AuthHelpers;
use App\User;


/*
		Controller to manage customer-specific splats
*/

class CustomerSplatsController extends Controller
{

	use AuthHelpers;
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
	public function submit_splat(Request $request, Splats $splats){

		$this->validate($request, [
			'splat' => 'required|min:10|max:' . config('constants.splat_limit') ,
		]);

		$user = $this->check_and_get_user('web');
		$guard_type = $this->guard_type;

		$splats->splat = $request->splat;
		$splats->user_id = $user->id;
		$splats->save();


		session()->flash('message', $user->name . '. Your splat has been posted!');

		return redirect()->route('home');

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
	public function get_your_splats(Splats $splats, User $user){
		$user = $this->check_and_get_user('web');

		$splats_get = $splats->where('user_id','=',$user->id);
		$splats_get = $splats_get->orderBy('created_at','desc');
		$splats_get = $splats_get->paginate(config('constants.splat_page_limit'));

		return $splats_get;
	}

}
