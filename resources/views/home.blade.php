@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-center">Produk dan Cafe Produk</h1>
    <div class="row">
        <div class="col-md-6">
            <h2 class="mb-3">Produk</h2>
            @foreach($products as $product)
                <div class="card mb-3 card-custom">
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">Rp{{ number_format($product->price, 2) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-md-6">
            <h2 class="mb-3">Cafe Produk</h2>
            @foreach($cafeProducts as $cafeProduct)
                <div class="card mb-3 card-custom">
                    <img src="{{ asset('storage/' . $cafeProduct->image) }}" class="card-img-top" alt="{{ $cafeProduct->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $cafeProduct->name }}</h5>
                        <p class="card-text">Rp{{ number_format($cafeProduct->price, 2) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
