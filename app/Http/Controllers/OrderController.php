<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
    	$users = User::has('orders')->get();
    	if(request('time') !==null && request('term') !== null){
    		if($users=User::where('name','=',request('term'))){
    			if(request('time') !='all'){
    				$users->load(['orders.products' => function ($query) {
    					$query->where('updated_at', '>=', new Carbon(request('time')));
						}]);
    			}
    			else{
    				$users->load('orders.products');
    			}
    		}
    		elseif(Product::where('name','=',request('term'))){
				if(request('time')!='all'){
					$users->load(['orders.products' => function ($query) {
						$query->where([
							['updated_at', '>=', new Carbon(request('time'))],
							['name','=','Fanta']]);
				    }]);

				}
				else {
					$users->load(['orders.products' => function ($query){
						$query->where('name','=',request('term'));
					}]);
				}
    		}
    	}

    	else{
    		if(request('time') != 'all' && request('time') !==null)
    		$users->load(['orders.order_product.products'=>function($query) {
    			$query->where('pivot_updated_at','>=',new Carbon(request('time')));
    	}]);
    		else {
    			$users = User::has('orders.products')->get();
    		}
    	}
    	// dd($users);
    	return view('welcome', compact('users'));
    }

    public function store()
    {
    	//products collection and quantity array forge
	    $_products=array_unique(request('products'));
		$_quantity=request('quantity');
		$products=Product::whereIn('name',$_products)->get();
		for ($i=0; $i<count($_products); $i++) {
			if(array_key_exists($_products[$i],$_quantity)){
				$quantity[$_products[$i]]+=$_quantity[$i];
				continue;
			}
			$quantity[$_products[$i]]=$_quantity[$i];
		}
		//user model
		$user = User::where('name','=',request('user'))->first();
		// dd($user);
		$order = new Order();
		$order->addOrder($products, $user, $quantity);

		return back();

    }
}
