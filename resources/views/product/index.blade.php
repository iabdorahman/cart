@extends('layouts.app')

@section('content')


  <div class="container">
    @if(session()->has('success'))
      <div class="alert alert-success">
        {{ session()->get('success') }}
      </div>
    @endif
    <section>
      <div class="row">
        @foreach($products as $product)

          <div class="col-md-4">
            <div class="card mb-2">
            <img src="{{ $product->image }}" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">{{ $product->title }}</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              <p class="card-text">$ {{ $product->price }}</p>
              <a href="{{ route('cart.add', $product->id) }}" class="btn btn-primary">Buy</a>
              </div>
            </div>
          </div>

        @endforeach
      </div>
    </section>

  </div>


@endsection