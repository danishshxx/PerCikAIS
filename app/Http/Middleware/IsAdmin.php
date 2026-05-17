<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user login DAN rolenya ADMIN (huruf besar)
        if (Auth::check() && Auth::user()->role === 'ADMIN') {
            return $next($request);
        }
        
        return redirect('/dashboard');
    }
}