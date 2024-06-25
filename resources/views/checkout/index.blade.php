@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Detail Checkout Produk</h2>
    <?php $totalPrice = 0; ?> <!-- Deklarasi di awal untuk memastikan variabel ini selalu terdefinisi -->
    @if(session('cart') && count(session('cart')) > 0)
        <form id="purchaseForm" action="{{ route('cart.purchase') }}" method="POST">
            @csrf
            @foreach(session('cart') as $id => $details)
                <input type="hidden" name="quantity[{{ $id }}]" value="{{ $details['quantity'] }}">
                <div class="card mb-3">
                    <div class="card-header">{{ $details['name'] }}</div>
                    <div class="card-body">
                        <p class="card-text">Jumlah:
                            <button type="button" class="btn btn-secondary btn-sm update-cart" data-id="{{ $id }}" data-action="decrease">-</button>
                            <span class="mx-2">{{ $details['quantity'] }}</span>
                            <button type="button" class="btn btn-secondary btn-sm update-cart" data-id="{{ $id }}" data-action="increase">+</button>
                        </p>
                        <p class="card-text">Harga per unit: Rp{{ number_format($details['price'], 2, ',', '.') }}</p>
                        <p class="card-text">Total: Rp{{ number_format($details['quantity'] * $details['price'], 2, ',', '.') }}</p>
                        <?php $totalPrice += $details['quantity'] * $details['price']; ?>
                        <!-- Input untuk catatan -->
                        <div class="form-group mb-2">
                            <label for="note-{{ $id }}" class="sr-only">Catatan</label>
                            <input type="text" class="form-control" id="note-{{ $id }}" name="notes[{{ $id }}]" placeholder="Tambahkan catatan untuk produk ini">
                        </div>
                        <!-- Tombol Hapus (opsional) -->
                        <form method="POST" action="{{ route('cart.remove', $id) }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger remove-from-cart" data-id="{{ $id }}">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
            <div class="d-flex justify-content-between mb-4">
                <h4>Total Harga: Rp{{ number_format($totalPrice, 2, ',', '.') }}</h4>
                <div>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">Tambah Produk Lain</a>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#confirmCheckoutModal">
                        Lanjut ke Pembayaran
                    </button>
                </div>
            </div>
        </form>
    @else
        <p>Belum ada barang yang ditambahkan ke keranjang.</p>
    @endif

    <!-- Modal -->
    <div class="modal fade" id="confirmCheckoutModal" tabindex="-1" aria-labelledby="confirmCheckoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: black; color: white;">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmCheckoutModalLabel" style="color: white;">Konfirmasi Pembelian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: white;">&times;</span>
                    </button>
                </div>
                <img src="{{ asset('images/Pembayaran BCA.jpg') }}" alt="Pembayaran" class="img-fluid">
                <div class="modal-body" style="color: white;">
                    Silahkan Melakukan Pembayaran Terlebih Dahulu
                    <?php
                    $referralCode = rand(1, 999); // Menghasilkan kode referral acak antara 1 dan 999
                    $totalWithReferral = $totalPrice + $referralCode; // Menambahkan kode referral ke total harga
                    ?>
                    <p>Total yang harus dibayar: Rp{{ number_format($totalWithReferral, 2, ',', '.') }} </p>
                    <p>Kode Referral: REF{{ $referralCode }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="confirmPurchase">Selesai Bayar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        // Pastikan event handler diinisialisasi setelah modal ditampilkan
        $('#confirmCheckoutModal').on('shown.bs.modal', function () {
            $('#confirmPurchase').click(function() {
                $('#purchaseForm').submit();
            });
        });

        // Fungsi untuk menghandle klik tombol hapus
        $('.remove-from-cart').click(function(event) {
            event.preventDefault();
            event.stopPropagation();
            var productId = $(this).data('id');
            $.ajax({
                url: '{{ route('cart.remove', '') }}/' + productId,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
                },
                error: function(xhr) {
                    // Tidak ada tindakan pada error
                }
            });
        });

        // Fungsi untuk menghandle klik tombol tambah/kurang
        $('.update-cart').click(function(event) {
            event.preventDefault();
            var productId = $(this).data('id');
            var action = $(this).data('action');
            $.ajax({
                url: '{{ route('cart.update', '') }}/' + productId,
                type: 'PATCH',
                data: {
                    _token: '{{ csrf_token() }}',
                    action: action
                },
                success: function(response) {
                    if (response.success) {
                        location.reload(); // Ini akan memuat ulang halaman, memastikan data terbaru ditampilkan
                    }
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText); // Menampilkan error jika ada
                }
            });
        });
    });
    </script>
</div>
@endsection
