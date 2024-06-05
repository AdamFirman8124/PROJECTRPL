<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CafeProduct;
use Illuminate\Support\Facades\Log;

class CafeProductController extends Controller
{
    public function store(Request $request)
    {
        try {
            Log::info('Store method called');

            // Validasi input
            $request->validate([
                'cafeProductName' => 'required|string|max:255',
                'cafeProductDescription' => 'required|string',
                'cafeProductPrice' => 'required|numeric',
                'cafeProductImage' => 'nullable|image|max:2048',
            ]);

            Log::info('Validation passed');

            // Penanganan file gambar
            $imagePath = null;
            if ($request->hasFile('cafeProductImage')) {
                $imagePath = $request->file('cafeProductImage')->store('cafe_products', 'public');
                Log::info('Image uploaded', ['path' => $imagePath]);
            }

            // Penyimpanan data
            $cafeProduct = new CafeProduct([
                'name' => $request->cafeProductName,
                'description' => $request->cafeProductDescription,
                'price' => $request->cafeProductPrice,
                'image' => $imagePath,
            ]);

            $cafeProduct->save();
            Log::info('Product saved', ['product' => $cafeProduct]);

            return redirect()->back()->with('success', 'Produk cafe berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Error storing product', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}