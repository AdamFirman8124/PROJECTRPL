@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Available Orders</h1>
    @if ($purchases->isEmpty())
        <div class="alert alert-info">Tidak ada order yang tersedia saat ini.</div>
    @else
        <div class="row">
            @foreach ($purchases as $purchase)
                <div class="col-md-4 mb-3">
                    <div class="card h-100 shadow-sm hover-shadow">
                        <div class="card-header bg-primary text-white text-center">
                            <strong>NAMA: {{ strtoupper($purchase->user->name) }}</strong>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $purchase->product->name }}</h5>
                            <p class="card-text">Jumlah: {{ $purchase->quantity }}</p>
                            <p class="card-text">Total Harga: Rp{{ number_format($purchase->total_price, 2) }}</p>
                            <p class="card-text">Catatan: {{ $purchase->notes ?? 'Tidak ada catatan' }}</p>
                        </div>
                        <div class="card-footer d-flex justify-content-center align-items-center" style="{{ $purchase->status == 'new' ? 'background-color: red;' : ($purchase->status == 'viewed' ? 'background-color: green;' : '') }}">
                            <span class="badge" style="font-size: 1em;">{{ strtoupper($purchase->status) }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script>
    $(document).ready(function() {
        $('.card').hover(
            function() {
                $(this).addClass('shadow-lg').css('cursor', 'pointer');
            }, function() {
                $(this).removeClass('shadow-lg');
            }
        );

        $('.btn-update').on('click', function() {
            var orderId = $(this).data('id');
            $.ajax({
                url: '/orders/' + orderId + '/update',
                type: 'POST',
                data: { status: 'newStatus' }, // Sesuaikan dengan data yang dibutuhkan
                success: function(response) {
                    alert('Status updated!');
                    location.reload(); // Atau update DOM tanpa reload
                }
            });
        });
    });
</script>
@endsection