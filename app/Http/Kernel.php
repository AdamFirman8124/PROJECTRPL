<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        // Global middleware
    ];

    protected $middlewareGroups = [
        'web' => [
            // Middleware yang berlaku untuk web interface
            \Illuminate\Auth\Middleware\Authenticate::class,
            \App\Http\Middleware\AutoLogout::class,
        ],

        'api' => [
            // Middleware yang berlaku untuk API
        ],
    ];
}
