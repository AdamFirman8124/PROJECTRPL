@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center" style="margin-bottom: 30px;">Produk Warnet</h1>
    <div class="row justify-content-center">
        @if(auth()->check() && auth()->user()->role == 'admin')
            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addProductModal">Tambahkan Produk</button>
        @endif
        @foreach ($products as $product)
            <div class="col-md-4">
                <div class="card card-fixed-height" style="background-color: black; color: white; margin-bottom: 20px; border: 1px solid #ccc;">
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title" style="margin-bottom: 10px;">{{ $product->name }}</h5>
                        <p class="card-text" style="margin-bottom: 10px;">{{ $product->description }}</p>
                        <p class="card-text" style="margin-bottom: 10px;">Rp{{ number_format($product->price, 2) }}</p>
                        <div class="d-flex justify-content-start">
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" style="margin-right: 10px;">
                                @csrf
                                <button type="submit" class="btn btn-primary" style="height: auto;">Tambahkan Keranjang</button>
                            </form>
                            @if(auth()->check() && auth()->user()->role == 'admin')
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')" style="height: auto; width: 130px;">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
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

<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header">
        <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="name">Nama Produk</label>
            <input type="text" class="form-control" id="name" name="productName" required>
          </div>
          <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea class="form-control" id="description" name="productDescription" rows="3" required></textarea>
          </div>
          <div class="form-group">
            <label for="price">Harga</label>
            <input type="number" class="form-control" id="price" name="productPrice" required>
          </div>
          <div class="form-group">
            <label for="image">Gambar Produk</label>
            <input type="file" class="form-control-file" id="image" name="productImage" required>
          </div>
          <button type="submit" class="btn btn-primary">Tambah Produk</button>
        </form>
      </div>
    </div>
  </div>
</div>