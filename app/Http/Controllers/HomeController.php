<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CafeProduct; // Menambahkan use statement untuk model CafeProduct

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::all();
        $cafeProducts = CafeProduct::all(); // Tambahkan ini
        return view('home', compact('products', 'cafeProducts')); // Tambahkan 'cafeProducts'
    }
}
