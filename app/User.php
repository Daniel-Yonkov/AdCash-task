<?php

namespace App;

use App\Order;

class User extends Model
{
	public function orders()
	{
		return $this->hasMany(Order::class);
	}

}
