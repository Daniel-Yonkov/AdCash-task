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
Route::get('/order/{order}/edit', 'OrderController@edit');
Route::patch('/order/{order}','OrderController@update');
Route::delete('/order/{order}', 'OrderController@destroy');