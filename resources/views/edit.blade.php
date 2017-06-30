@extends('layouts.master')

@section('content')

	<div class="col-md-10 offset-md-1">
    <form method="POST" class="form-horizontal card" action="/order/{{$order->id}}">
      {{csrf_field()}}
      {{ method_field('PATCH') }}
      <div class="col-md-12">
        <h3>Edit order</h3> 
        <div class="input-group">
          <label for="user" class="col-sm-2 col-form-label">User</label>
          <select class="custom-select col-sm-3" name="user" id="user">
            @foreach($users as $user)
            <option value="{{$user->name}}">{{$user->name}}</option>
            @endforeach
          </select>
        </div>
        @foreach($order->products as $orderProduct)
        <div class="products col-md-6">
          <div class="input-group">
            <label for="product" class="col-sm-4 col-form-label">Product</label>
            <select class="custom-select col-sm-6" arial-label="close" name="products[]" id="product">
              @foreach($products as $product)
              @if($orderProduct->name == $product->name)
              	<option value="{{$product->name}}" selected>{{$product->name}}</option>
              	<?php continue; ?>
              @endif
              <option value="{{$product->name}}">{{$product->name}}</option>
              @endforeach
            </select>
            <i class="fa fa-window-close" aria-hidden="true"></i>
          </div>
          <div class="input-group">
            <label for="quantity" class="col-sm-4 col-form-label">Quantity</label>
            <input type="text" name="quantity[]" value="{{$orderProduct->pivot->quantity}}" class="form-control col-sm-6" id="quantity">
          </div>
        </div>
        @endforeach
        <button type="button" class="btn btn-primary button" id="new-product">More products</button>
        <button type="submit" class="btn btn-success col-md-3">Save</button>
          </div>
      </div>
    </form>
  </div>
@include('layouts.errors')
@endsection

@section('footer')
	<script src="/js/script.js"></script>
@endsection