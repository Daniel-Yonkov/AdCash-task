<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'OrderController@index');
Route::post('/order/create','OrderController@store');
// Route::post('/order/create',function(){
// 	$products=request('products');
// 	$quantity=request('quantity');
// 	$quantity1=array();
// 	for ($i=0; $i<count(request('products')); $i++) {
// 		$product_1[]= App\Product::where('name','=',$products[$i]);
// 		if(array_key_exists($products[$i],$quantity1)){
// 			$quantity1[$products[$i]]+=$quantity[$i];
// 			continue;
// 		}
// 		$quantity1[$products[$i]]=$quantity[$i];
// 	}
// 	return dd([$product_1,$quantity1]);
// 	return dd(request()->all());
// });