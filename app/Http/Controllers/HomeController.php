<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Pastikan menggunakan model yang tepat
use App\Models\CafeProduct; // Menggunakan model CafeProduct
use Illuminate\Support\Facades\Log; // Tambahkan library untuk logging

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Hapus atau komentari baris ini jika tidak ingin memerlukan autentikasi untuk index
        $this->middleware('auth')->except('index');
        Log::info('HomeController diinisialisasi'); // Log informasi inisialisasi controller
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::all(); // Mengambil semua produk dari database
        Log::info('Semua produk diambil dari database'); // Log informasi pengambilan produk

        $cafeProducts = CafeProduct::all(); // Mengambil semua produk cafe dari database
        Log::info('Semua produk cafe diambil dari database'); // Log informasi pengambilan produk cafe

        return view('home', compact('products', 'cafeProducts')); // Mengirimkan data ke view dengan produk dan produk cafe
        Log::info('Data dikirim ke view home'); // Log informasi pengiriman data ke view
    }
}
