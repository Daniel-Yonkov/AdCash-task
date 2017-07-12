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
    //relationship defined array for automatic filtering;
    static $relationships=array('user','products');

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
        $this->getOrderParams($products, $quantity);
        $this->user()->associate($user);
        $this->attributes['total']=$this->total;
        $this->attributes['discount']=$this->discount;
        $this->save();
        $this->updateQuantity($products,$quantity);
    }

    protected function addQuantity(Collection $products, Order $order,  array $quantity)
    {
         foreach ($products as $product) {
            
            $order->products()->attach($product, ['quantity' => $quantity[$product->name]]);
        }
    }

     protected function updateQuantity(Collection $products, array $quantity)
    {
         foreach ($products as $product) {
            if(!$this->products()->updateExistingPivot($product->id, ['quantity' => $quantity[$product->name]])){
                $this->products()->attach($product, ['quantity' => $quantity[$product->name]]);
            }
        }
        $this->products()->sync($products);
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

    public static function orderFilter($term=null, Carbon $time = null){
        $orders = self::orderBy('updated_at','desc')->get();
        $relation = null;
        $filter = null;

        if($term) {
            if((User::where('name',$term)->get())->isNotEmpty()){
                $relation = 'user';
                $filter = 'name';
            }
            elseif((Product::where('name', $term)->get())->isNotEmpty()){
                $relation = 'products';
                $filter = 'name';
            }
            else {
                return collect([]);
            }
            $orders = Order::whereHas($relation, function($query) use($filter, $term){
                $query->where($filter, $term);
                })->orderBy('updated_at','desc')->get();
        }
        if($time){
            $orders = $orders->where('updated_at','>=',$time);
        }

        return self::filteredResults($orders, $relation, $filter, $term);
    }

    protected static function filteredResults(Collection $orders, $relation, $filter, $term){
            return$orders->each(function($order){
                $order->load(self::$relationships);
            });
    }

}