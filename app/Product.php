<?php

namespace App;

use App\Order;

class Product extends Model
{
    public function orders()
    {
    	return $this->belongsToMany(Order::class)->withPivot('quantity');
    }
}
