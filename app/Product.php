<?php

namespace App;

use App\Order;

class Product extends Model
{
    public function users()
    {
    	return $this->belongsToMany(Order::class)->withPivot('quantity');
    }
}
