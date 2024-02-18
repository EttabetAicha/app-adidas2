@extends('products.layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Search Results</h1>
                @if ($products->isEmpty())
                    <p>No products found.</p>
                @else
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <img src="{{ asset('assets/' . $product->images) }}" class="card-img-top" alt="Product Image">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->product_name }}</h5>
                                        <p class="card-text">{{ $product->description }}</p>
                                        <p class="card-text">Price: {{ $product->price }}</p>
                                        <a href="{{ url('/products/' . $product->id) }}" class="btn btn-primary">View Details</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
