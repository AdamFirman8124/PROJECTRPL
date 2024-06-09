@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Detail Checkout Produk</h2>
    @if(session('cart') && count(session('cart')) > 0)
        <form id="purchaseForm" action="{{ route('cart.purchase') }}" method="POST">
            @csrf
            @foreach(session('cart') as $id => $details)
                <div class="card mb-3">
                    <div class="card-header">{{ $details['name'] }}</div>
                    <div class="card-body">
                        <p class="card-text">Jumlah: {{ $details['quantity'] }}</p>
                        <p class="card-text">Harga: Rp{{ number_format($details['price'], 2, ',', '.') }}</p>
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
            <!-- Tombol untuk lanjut ke pembayaran atau menambah produk lain -->
            <div class="d-flex justify-content-between mb-4">
                <a href="{{ route('products.index') }}" class="btn btn-primary">Tambah Produk Lain</a>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#confirmCheckoutModal">
                    Lanjut ke Pembayaran
                </button>
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
                <div class="modal-body" style="color: white;">
                    Apakah Anda yakin ingin melanjutkan pembelian?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="confirmPurchase">Konfirmasi</button>
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
    });
    </script>
</div>
@endsection
