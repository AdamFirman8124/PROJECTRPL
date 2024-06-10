<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AutoLogout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $lastActivity = session('lastActivityTime');
        if ($user && time() - $lastActivity > 1800) { // 1800 detik = 30 menit
            Log::info('Logging out user due to inactivity.', ['user_id' => $user->id]);
            Auth::logout();
            session()->flash('warning', 'Anda telah logout karena tidak ada aktivitas lebih dari 30 menit.');
            return redirect('/login');
        }
        session(['lastActivityTime' => time()]);
        return $next($request);
    }
}
