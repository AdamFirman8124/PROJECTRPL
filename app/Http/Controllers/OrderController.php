<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        Log::info('Memulai pengambilan semua purchases');
        $purchases = Purchase::orderBy('created_at', 'desc')->get();
        Log::info('Pengambilan purchases selesai', ['purchases_count' => $purchases->count()]);

        $newOrdersCount = $this->countNewOrders();
        Log::info('Jumlah pesanan baru', ['new_orders_count' => $newOrdersCount]);
    
        // Update status purchases yang belum dilihat
        Log::info('Memulai update status purchases yang belum dilihat');
        Purchase::where('status', 'new')->update(['status' => 'viewed']);
        Log::info('Update status purchases selesai');
        
        // Log tambahan untuk memastikan view di-render dengan data yang benar
        Log::info('Rendering view orders.index dengan data', ['purchases' => $purchases, 'newOrdersCount' => $newOrdersCount]);

        return view('orders.index', compact('purchases', 'newOrdersCount'));
    }

    public function countNewOrders()
    {
        Log::info('Menghitung jumlah pesanan baru');
        $newOrdersCount = Purchase::where('status', 'new')->count(); // asumsikan ada kolom 'status'
        Log::info('Jumlah pesanan baru dihitung', ['new_orders_count' => $newOrdersCount]);
        return $newOrdersCount;
    }
}
