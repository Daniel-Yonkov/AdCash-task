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

	public function userOrdersFilter($time = 'all'){
		if($time!='all'){
	        //specific time eager load for specific user
			return $this->load([
                        'orders' => function ($query) use($time) {
                        $query->where('updated_at', '>=', new Carbon($time));
                        },
                        'orders.products'
                    ]);
        }
        else{
            //all time eager load for specific user
            return $this->load(['orders'=>function($query){
                $query->latest();
            },
            'orders.products']);
        }
	}

	public function userOrderProductFilter(Product $product, $time = 'all'){
		$orders_id=$this->getOrdersIdBasedOnProduct($product);
		if(request('time')!='all'){
                    //in speicfic time eager load of the searched product
                    return $this->load([
                        'orders' => function($query) use ($orders_id, $time){
                            $query->whereIn('id',$orders_id)
                                  ->where('updated_at', '>=', new Carbon($time))->latest();
                            },
                        'orders.products'
                    ]);
        }
        else {
            return $this->load([
                'orders' => function($query) use ($orders_id, $time){
                    $query->whereIn('id',$orders_id)->latest();},
                'orders.products'
                ]);
        }
	}

	protected function getOrdersIdBasedOnProduct(Product $product){
        $orders=$product->orders;
        foreach ($orders as $order) {
            $orders_id[]=$order->id;
        }
        return $orders_id;
    }
}
