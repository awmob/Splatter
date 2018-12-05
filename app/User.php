<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $guard = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function public_single_user_get($username){
      $user_get = $this->select('id','username','name','profile_image','profile_text');
			$user_get = $user_get->where('username','=',$username)->first();
      return $user_get;
    }

    //get details of a single user
    public function single_user_get_api($user_id){
      $user_get = $this->join('splats','users.id','=','splats.user_id')
                        ->selectRaw('splats.splat as splat, splats.id as splat_id, splats.created_at as splat_created, users.id as userid, users.username as username, users.name as userfullname, users.profile_image as user_image, splats.created_at as created_at')
                        ->where('users.id', '=', $user_id)
                        ->orderByRaw('splats.created_at desc')
                        ->paginate(config('constants.splat_page_limit'));

      return($user_get);
    }
}
