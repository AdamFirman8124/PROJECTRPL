<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CafeProduct;
use Illuminate\Support\Facades\Log;

class CafeProductController extends Controller
{
    public function store(Request $request)
    {
        Log::info('Memulai proses penyimpanan produk cafe');
        try {
            Log::info('Metode store dipanggil');

            // Validasi input
            $request->validate([
                'cafeProductName' => 'required|string|max:255',
                'cafeProductDescription' => 'required|string',
                'cafeProductPrice' => 'required|numeric',
                'cafeProductImage' => 'nullable|image|max:2048',
            ]);

            Log::info('Validasi berhasil');

            // Penanganan file gambar
            $imagePath = null;
            if ($request->hasFile('cafeProductImage')) {
                $imagePath = $request->file('cafeProductImage')->store('cafe_products', 'public');
                Log::info('Gambar diunggah', ['path' => $imagePath]);
            }

            // Penyimpanan data
            $cafeProduct = new CafeProduct([
                'name' => $request->cafeProductName,
                'description' => $request->cafeProductDescription,
                'price' => $request->cafeProductPrice,
                'image' => $imagePath,
            ]);

            $cafeProduct->save();
            Log::info('Produk disimpan', ['product' => $cafeProduct]);

            return redirect()->back()->with('success', 'Produk cafe berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Kesalahan saat menyimpan produk', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function index()
    {
        Log::info('Memuat semua produk cafe');
        $cafeProducts = CafeProduct::all();
        return view('cafe.index', compact('cafeProducts'));
    }

    public function destroy($id)
    {
        Log::info('Memulai proses penghapusan produk cafe', ['product_id' => $id]);
        $cafeProduct = CafeProduct::find($id);
        if ($cafeProduct) {
            $cafeProduct->delete();
            Log::info('Produk cafe berhasil dihapus', ['product_id' => $id]);
            return redirect()->back()->with('success', 'Produk cafe berhasil dihapus.');
        }
        Log::warning('Produk cafe tidak ditemukan', ['product_id' => $id]);
        return redirect()->back()->with('error', 'Produk cafe tidak ditemukan.');
    }
}

