@extends('layouts.master')

@section('content')    
  <div class="col-md-10 offset-md-1">
    <form method="POST" class="form-horizontal card" action="/order/create">
      {{csrf_field()}}
      <div class="col-md-12">
        <h3>Create new order</h3> 
        <div class="input-group">
          <label for="user" class="col-sm-2 col-form-label">User</label>
          <select class="custom-select col-sm-3" name="user" id="user">
            <option value="John Doe">John Doe</option>
            <option value="Jane Doe">Jane Doe</option>
            <option value="John Smith">John Smith</option>
          </select>
        </div>
        <div class="products col-md-6">
          <div class="input-group">
            <label for="product" class="col-sm-4 col-form-label">Product</label>
            <select class="custom-select col-sm-6" name="products[]" id="product">
              <option value="Coca Cola">Coca Cola</option>
              <option value="Pepsi Cola">Pepsi Cola</option>
              <option value="Fanta">Fanta</option>
            </select>
          </div>
          <div class="input-group">
            <label for="quantity" class="col-sm-4 col-form-label">Quantity</label>
            <input type="text" name="quantity[]" class="form-control col-sm-6" id="quantity">
          </div>
        </div>
          <button type="button" class="btn btn-primary button" id="new-product">More products</button>
          <div class="offset-5 submit">
        <button type="submit" class="btn btn-success col-md-3">Save</button>
          </div>
      </div>
    </form>
  </div>
  
  <div class="col-md-10 offset-md-1">
    <form method="GET" class="form-inline card search" action="/">
        <div class="col-md-12">
        <h3>Search</h3> 
          <select class="form-control custom-select col-sm-3" name="time">
            <option value="all">All Time</option>
            <option value="7 days ago">Last 7 days</option>
            <option value="today">Today</option>
          </select>
            <input type="text" name="term" class="form-control col-sm-6" id="quantity">
          <div class="offset-2 inline col-md-4">
        <button type="submit" class="btn btn-success col-md-8">Search</button>
          </div>
        </div>
    </form>
  </div>

  <div class="col-md-10 offset-md-1">
    <div class="card">
      <div class="col-md-12">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>User</th>
              <th>Product</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Total</th>
              <th>Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          @foreach($users as $user)
            <tr>
              <td>{{$user->name}}</td>
              @foreach($user->orders as $order)
              <td>
                <table class="table table-sm">
                @foreach($order->products as $product)
                
                    <tr>
                    <td>{{$product->name}}</td>
                  </tr>
                @endforeach
                </table>
              </td>
              <td>
                <table class="table table-sm">
                @foreach($order->products as $product)
                  
                    <tr>
                      <td>{{$product->price}}</td>
                    </tr>
                @endforeach
                </table>
              </td>
                <td>
                  <table class="table table-sm">
                @foreach($order->products as $product)
                  
                    <tr>
                      <td>{{$product->pivot->quantity}}</td>
                    </tr>
                @endforeach
                </table>
                </td>
                <td>{{$order->total}}</td>
                <td>{{$order->updated_at->toDayDateTimeString()}}</td>
                <td><a href="/order/{{$order->id}}">Edit</a> /
                    <a href="/order/{{$order->id}}/delete">Delete</a>
                </td>
              @endforeach
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

 @endsection

 @section('footer')
  <script
        src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
      $('#new-product').click(function(){
        let products = $('.products:last');
        let clone=products.clone();
        $('option',clone).filter(function(){
          return products.find('option:selected[value="'+$(this).val()+'"]').val();
        }).remove();
        if($('option',clone).length ==1){
          clone.insertBefore("#new-product");
          $('#new-product').remove();
        }
        clone.insertBefore("#new-product");
      });
});
 @endsection