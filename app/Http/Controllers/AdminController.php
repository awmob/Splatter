<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
		{

				if(Auth::guard('admin')->check())
				{
					 $user = Auth::user();
					 $guard_type = 'admin';
				}
				else{
					$user = false;
				}
        return view('authadmin.admin-home',compact('user','guard_type'));
    }
}
