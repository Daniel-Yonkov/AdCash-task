<div class="col-md-10 offset-md-1">
    <div class="card">
      <div class="col-md-12">
        <table class="table">
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
          @if($results)
          @foreach($results as $user)
            @foreach($user->orders as $order)
            <tr>
              <td>{{$user->name}}</td>
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
                <td><a href="/order/{{$order->id}}/edit">Edit</a> /
                    <a href="/order/{{$order->id}}" data-method="delete" data-token="{{csrf_token()}}">
                    Delete
                    </a>
                </td>
              @endforeach
            </tr>
          @endforeach
        @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>