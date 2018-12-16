<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\AuthHelpers;

class FollowersController extends Controller
{

	use AuthHelpers;

	private $guard_type;

	public function __construct(){
		$this->guard_type = 'web';
	}



}
