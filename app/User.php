<?php

namespace App;

use App\Order;
use Carbon\Carbon;

class User extends Model
{
	public function orders()
	{
		return $this->hasMany(Order::class);
	}
}
