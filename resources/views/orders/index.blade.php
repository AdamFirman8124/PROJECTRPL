@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Order yang Tersedia</h1>
    @if ($purchases->isEmpty())
        <div class="alert alert-info">Tidak ada order yang tersedia saat ini.</div>
    @else
        <div class="table-responsive" id="orders-table-container">
            <table class="table table-bordered table-striped table-hover shadow">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Nama Pelanggan</th>
                        <th>Nama Produk</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Catatan</th>
                        <th>Status</th>
                        <th>Hari Order</th>
                    </tr>
                </thead>
                <tbody id="order-table-body">
                    @foreach ($purchases as $purchase)
                        <tr class="{{ $purchase->status == 'new' ? 'bg-danger text-white' : ($purchase->status == 'viewed' ? 'bg-success text-white' : 'bg-light') }}" data-day="{{ $purchase->created_at->format('l') }}">
                            <td>{{ strtoupper($purchase->user->name) }}</td>
                            <td>{{ $purchase->product->name }}</td>
                            <td>{{ $purchase->quantity }}</td>
                            <td>Rp{{ number_format($purchase->total_price, 2, ',', '.') }}</td>
                            <td>{{ $purchase->notes ?? 'Tidak ada catatan' }}</td>
                            <td>{{ strtoupper($purchase->status) }}</td>
                            <td>{{ $purchase->created_at->format('l') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<script>
    $(document).ready(function() {
        $('table').hover(
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
                data: { status: 'newStatus' },
                success: function(response) {
                    alert('Status diperbarui!');
                    location.reload();
                }
            });
        });
    });
</script>
@endsection
