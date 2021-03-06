<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Splats extends Model
{

		//gets the splats for a particular user
		public function get_splats($user_id)
		{
			$splats = $this->where('user_id',$user_id);
			return $splats;
		}

		//checks splats exist for a particular user
		public function check_splats_exist($user_id)
		{
			$splats = $this->where('user_id',$user_id)->exists();
			return $splats;
		}




}
