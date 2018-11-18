<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AuthHelpers;


class AdminController extends Controller{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

		use AuthHelpers;
		private $guard_type;

    public function __construct()
    {
        $this->middleware('auth:admin');
				$this->guard_type = 'admin';
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

		//display the main admin dashboard
    public function index()
		{

				$user = $this->check_and_get_user('admin');
				$guard_type = $this->guard_type;

        return view('authadmin.admin-home',compact('user','guard_type'));
    }
}
