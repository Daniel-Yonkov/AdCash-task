<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\User;

class OrderController extends Controller
{
    public function index()
    {
    	$users = User::all();
    	$products = Product::all();
    	$order = new Order();
    	$results = $order->filter();
    	return view('welcome', compact('users', 'products', 'results'));
    }

    public function store()
    {
    	// products collection and quantity array forge
    	$this->validate(request(),[
    		'products.*' => 'required|exists:products,name',
    		'quantity.*' => 'required|integer|min:1',
    		'user' => 'required|exists:users,name'
    		]);
	   	list($_products, $quantity) = $this->inputForge();
		$products=Product::whereIn('name',($_products))->get();
		//user model
		$user = User::where('name','=',request('user'))->first();
		$order = new Order();
		$order->addOrder($products, $user, $quantity);

		return back();

    }

    public function edit(Order $order)
    {
    	$users = User::all();
    	$products = Product::all();

    	return view('edit', compact('users','products','order'));
    }

    public function update(Order $order){
    	$this->validate(request(),[
    		'products.*' => 'required|exists:products,name',
    		'quantity.*' => 'required|integer|min:0',
    		'user' => 'required|exists:users,name'
    		]);
    	list($_products, $quantity)=$this->inputForge();
		$products=Product::whereIn('name',$_products)->get();
		$user=User::where('name',request('user'))->first();
    	$order->edit($user, $products, $quantity);
    	return redirect('/');
    }

    public function destroy(Order $order){
    	$order->products()->sync([]);
    	$order->delete();

    	return back();
    }

    protected function setOrderId(Order $orders){
    	foreach (orders as $order) {
    				$this->orders_id[]= $order->id;
    			}
    }

    protected function inputForge(){
    	$_products=request('products');
		$_quantity=request('quantity');
		$productsNumber = count($_products);
		$quantity = array();
		for ($i=0; $i<$productsNumber; $i++) {
				if(array_key_exists($_products[$i],$quantity)){
				$quantity[$_products[$i]]+=$_quantity[$i];
				unset($_products[$i]);
				continue;
			}
			$quantity[$_products[$i]]=$_quantity[$i];
		}
		return array($_products, $quantity);
    }
}
