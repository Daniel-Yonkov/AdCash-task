<div class="col-md-10 offset-md-1">
    <form method="POST" class="form-horizontal card" action="/order/create">
      {{csrf_field()}}
      <div class="col-md-12">
        <h3>Create new order</h3> 
        <div class="input-group">
          <label for="user" class="col-sm-2 col-form-label">User</label>
          <select class="custom-select col-sm-3" name="user" id="user">
            @foreach($users as $user)
            <option value="{{$user->name}}">{{$user->name}}</option>
            @endforeach
          </select>
        </div>
        <div class="products col-md-6">
          <div class="input-group">
            <label for="product" class="col-sm-4 col-form-label">Product</label>
            <select class="custom-select col-sm-6" name="products[]" id="product">
              @foreach($products as $product)
              <option value="{{$product->name}}">{{$product->name}}</option>

              @endforeach
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
  @include('layouts.errors')