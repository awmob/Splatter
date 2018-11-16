<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Splats extends Model
{


		public function get_splats($user_id)
		{
			$splats = $this->where('user_id','=','$user_id');
			return $splats;
		}
}
