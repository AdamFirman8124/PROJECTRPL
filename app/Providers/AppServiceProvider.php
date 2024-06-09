<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Purchase;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('layouts.app', function ($view) {
            $newOrdersCount = Purchase::where('status', 'new')->count();
            $checkoutItemCount = session('cart') ? count(session('cart')) : 0; // Menghitung jumlah item di keranjang
            $view->with(compact('newOrdersCount', 'checkoutItemCount'));
        });
    }
}
