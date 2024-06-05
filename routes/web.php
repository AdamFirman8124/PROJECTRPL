<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CafeProductController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home'); // Menggunakan HomeController yang sudah di-import
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::post('/cafe-products/store', [CafeProductController::class, 'store'])->name('cafeProducts.store');
