<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SplatLikes extends Model
{

    public function check_like_exists($user_id, $splat_id){
			$splat_like_get = $this->where('user_id',$user_id)->where('splat_id',$splat_id)->first();
      return($splat_like_get);
		}

		public function get_splat_likes($user_id, $splat_id){
			$splat_like_get = $this->where('user_id',$user_id)->where('splat_id',$splat_id)->get();
			return $splat_like_get;
		}

		public function add_splat_like($user_id, $splat_id){
			$this->user_id = $user_id;
			$this->splat_id = $splat_id;
			$this->save();
		}

    public function remove_splat_like($user_id, $splat_id){
      $this->where('user_id',$user_id)->where('splat_id',$splat_id)->delete();
    }

    public function get_like_count($splat_id){
      return $this->where('splat_id',$splat_id)->count();
    }
}
