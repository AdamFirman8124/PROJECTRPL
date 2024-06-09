<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index()
    {
        Log::info('Memasuki halaman checkout');
        return view('checkout.index');
    }
}

