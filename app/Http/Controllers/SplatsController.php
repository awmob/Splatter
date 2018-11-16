<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Splats;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AuthHelpers;

class SplatsController extends Controller
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

}
