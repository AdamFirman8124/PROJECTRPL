<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function remove($id)
    {
        Log::info('Memulai proses penghapusan item dari keranjang dengan ID: ' . $id);
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            session()->save(); // Menyimpan sesi setelah perubahan
            Log::info('Item dengan ID: ' . $id . ' berhasil dihapus dari keranjang.');
            Log::info('Proses penghapusan item selesai untuk ID: ' . $id);
            return response()->json([
                'success' => true,
                'message' => 'Item berhasil dihapus dari keranjang.'
            ]);
        } else {
            Log::info('Percobaan menghapus item yang tidak ada di keranjang dengan ID: ' . $id);
            Log::info('Proses penghapusan item gagal karena item tidak ditemukan untuk ID: ' . $id);
            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan di keranjang.'
            ]);
        }
    }
}
