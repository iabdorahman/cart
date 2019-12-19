@extends('layouts.app')

@section('content')

  <div class="container">
    <div class="row">
      @if($cart)
      <div class="col-md-8">
        @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
        @endif
        @foreach( $cart->items as $product)
          <div class="card mb-2">
            <div class="card-body">
              <h5 class="card-title">
                {{ $product['title'] }}
              </h5>
              <div class="card-text">
                $ {{ $product['price'] }}
              </div>
              
              {{-- <a href="#" class="btn btn-secondary btn-sm">Change</a> --}}
              <form action="{{ route('product.updateQty', $product['id']) }}" method="post" class="text-left d-inline">
                @csrf
                @method('put')
                <input type="text" name="qty" id="qty" value="{{ $product['qty']}}">
                <button type="submit" class="btn btn-secondary btn-sm mr-0">
                  Change
                </button>
              </form>
            <form action="{{ route('product.remove', $product['id']) }}" method="post" class="text-right d-inline">
              @csrf
              @method('delete')
              <button type="submit" class="btn btn-danger btn-sm mr-0 float-right">
                Remove
              </button>
            </form>
            </div>

          </div>
        @endforeach
        <p class="font-weight-bold">Total : $ {{ $cart->totalPrice }}</p>
      </div>

      <div class="col-md-4">
        <div class="card bg-primary text-white">
          <div class="card-body">
            <h3 class="card-title">{{Auth::user() ? Auth::user()->name . "'s" : 'your'}} cart</h3>
            <hr>
            <div class="card-text">
              <p>Total amount is $ {{ $cart->totalPrice }}</p>
              <p>Total Quantities is {{ $cart->totalQty }}</p>
            <a href="{{ route('cart.checkout', $cart->totalPrice) }}" class="btn btn-info">CheckOut</a>
            </div>
          </div>
        </div>
      </div>

      @else
        <p class="alert alert-warning alert-dismissible fade show">There are no items in the cart.</p>
      @endif
    </div>
  </div>


@endsection