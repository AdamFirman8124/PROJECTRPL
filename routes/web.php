<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CafeProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CartController;

Route::get('/', [HomeController::class, 'index'])->name('welcome');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home'); // Menggunakan HomeController yang sudah di-import
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->middleware('auth');
Route::post('/products', [ProductController::class, 'store'])->middleware('auth')->name('products.store');
Route::post('/cafe-products/store', [CafeProductController::class, 'store'])->middleware('auth')->name('cafeProducts.store');

// Tambahkan route untuk menampilkan data produk di database
Route::get('/products', [ProductController::class, 'index'])->middleware('auth')->name('products.index');

// Tambahkan route untuk halaman pricing
Route::get('/game', [ProductController::class, 'index'])->middleware('auth')->name('game');

// Tambahkan route untuk menampilkan produk cafe
Route::get('/cafe', [CafeProductController::class, 'index'])->middleware('auth')->name('cafe');

// Tambahkan route untuk halaman kontak
Route::get('/contact', function () {
    return view('contact');
})->middleware('auth')->name('contact');

// Tambahkan route untuk menghapus produk
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->middleware('auth')->name('products.destroy');
Route::delete('/cafe-products/{id}', [CafeProductController::class, 'destroy'])->middleware('auth')->name('cafeProducts.destroy');

// Tambahkan route untuk checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->middleware('auth')->name('checkout');

// Rute untuk pembelian
Route::post('/cart/purchase', [ProductController::class, 'purchase'])->middleware('auth')->name('cart.purchase');

// Tambahkan route untuk available orders
Route::get('/available-orders', [OrderController::class, 'index'])->middleware('auth')->name('available.orders');

// Tambahkan route untuk checkout produk
Route::post('/checkout', [ProductController::class, 'checkout'])->middleware('auth')->name('products.checkout');

// Tambahkan route untuk menghapus item dari keranjang
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->middleware('auth')->name('cart.remove');

// Tambahkan route untuk menambahkan produk ke keranjang
Route::get('/cart/add/{id}', [ProductController::class, 'addToCart'])->middleware('auth')->name('cart.add');
Route::post('/cart/add/{id}', [ProductController::class, 'addToCart'])->middleware('auth')->name('cart.add');

// Tambahkan route untuk menampilkan keranjang
Route::get('/cart', [CartController::class, 'index'])->middleware('auth')->name('cart.index');

// Tambahkan route untuk mengupdate item di keranjang
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->middleware('auth')->name('cart.update');
