@extends('layouts.app')
@section('content')


  <div class="container">
    <div class="row">
      <div class="col-md-9">
        @foreach ($carts as $cart)
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Image</th>
            <th scope="col">Price</th>
            <th scope="col">Quantity</th>
            <th scope="col">Total</th>
          </tr>
        </thead>
        <tbody>

          <?php $i = 0; // set counter to 0 ?>
          @foreach ($cart->items as $key => $item)
            <tr>
            <th scope="row">{{ ++$i }}</th>
              <td>{{ $item['title'] }}</td>
              <td><a href="{{ $item['image'] }}" target="_blank"></a></td>
              <td>{{ $item['price'] }}</td>
              <td>{{ $item['qty']  }}</td>
              <td>{{ $item['qty'] * $item['price'] }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <button type="button" class="btn btn-primary">
        Total <span class="badge badge-light">$ {{ $cart->totalPrice }}</span>
          <span class="sr-only">unread messages</span>
        </button>
      @endforeach
      </div>
      <div class="col-md-3">

      </div>
    </div>
  </div>


@endsection