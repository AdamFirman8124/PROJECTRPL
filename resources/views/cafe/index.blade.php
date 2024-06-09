@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center" style="margin-bottom: 30px;">Produk Cafe</h1>
    <div class="row justify-content-center">
        @if(auth()->check() && auth()->user()->role == 'admin')
            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addCafeProductModal">Tambah Produk Cafe</button>
        @endif
        @foreach ($cafeProducts as $product)
            <div class="col-md-4">
                <div class="card card-fixed-height" style="background-color: black; color: white; margin-bottom: 20px; border: 1px solid #ccc;">
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title" style="margin-bottom: 10px;">{{ $product->name }}</h5>
                        <p class="card-text" style="margin-bottom: 10px;">{{ $product->description }}</p>
                        <p class="card-text" style="margin-bottom: 10px;">Rp{{ number_format($product->price, 2) }}</p>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('cart.add', $product->id) }}" class="btn btn-primary" style="height: 48px;">Tambahkan ke Keranjang</a>
                            @if(auth()->check() && auth()->user()->role == 'admin')
                                <form action="{{ route('cafeProducts.destroy', $product->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')" style="height: 48px; width: 110px;">Hapus</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

<div class="modal fade" id="addCafeProductModal" tabindex="-1" role="dialog" aria-labelledby="addCafeProductModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header">
        <h5 class="modal-title" id="addCafeProductModalLabel">Tambah Produk Cafe Baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('cafeProducts.store') }}" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="name">Nama Produk</label>
            <input type="text" class="form-control" id="productName" name="cafeProductName" required>
          </div>
          <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea class="form-control" id="description" name="cafeProductDescription" rows="3" required></textarea>
          </div>
          <div class="form-group">
            <label for="price">Harga</label>
            <input type="number" class="form-control" id="price" name="cafeProductPrice" required>
          </div>
          <div class="form-group">
            <label for="image">Gambar Produk</label>
            <input type="file" class="form-control-file" id="image" name="cafeProductImage" required>
          </div>
          <button type="submit" class="btn btn-primary">Tambah Produk</button>
        </form>
      </div>
    </div>
  </div>
</div>