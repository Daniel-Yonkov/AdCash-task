<?php

namespace App;

use App\Product;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class Order extends Model
{
    protected $total =0;
    protected $discount =0;
    //used in filtering based on product name
    protected $orders_id=array();

    public function products()
    {
    	return $this->belongsToMany(Product::class)->withPivot('quantity')->withTimestamps();
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function addOrder(Collection $products, User $user, array $quantity)
    {
    	$this->getOrderParams($products, $quantity);
    	$order=$this->create([
    		'user_id' => $user->id,
    		'discount' => $this->discount,
    		'total' => $this->total
    		]);
        $order->addQuantity($products, $order, $quantity);
    }

    public function edit(User $user, Collection $products, array $quantity)
    {
        $order= clone $this;
        $this->getOrderParams($products, $quantity);
        $this->user()->associate($user);
        $this->updateQuantity($products, $order, $quantity);
        $this->attributes['total']=$this->total;
        $this->attributes['discount']=$this->discount;
        $this->save();
    }

    protected function addQuantity(Collection $products, Order $order,  array $quantity)
    {
         foreach ($products as $product) {
            
            $order->products()->attach($product, ['quantity' => $quantity[$product->name]]);
        }
    }

     protected function updateQuantity(Collection $products, Order $order,  array $quantity)
    {
         foreach ($products as $product) {
            if(!$order->products()->updateExistingPivot($product->id, ['quantity' => $quantity[$product->name]])){
                $order->products()->attach($product, ['quantity' => $quantity[$product->name]]);
            }
        }
        $order->products()->sync($products);
    }

    protected function getOrderParams(Collection $products, array $quantity)
    {
        $discount = 0;
        $total = 0;

        foreach ($products as $product) {
            if(isset($quantity['Pepsi Cola'])>=3 && $product->name == 'Pepsi Cola'){
                $discount = 1;
            }
                $total += $product->price * $quantity[$product->name];
        }
        $total=$discount?$total*0.8:$total;
        $this->discount = $discount;
        $this->total = $total;
    }