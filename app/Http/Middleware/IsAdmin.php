<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Kalau dia udah login DAN role-nya admin, silakan masuk
        if (Auth::check() && Auth::user()->role == 'admin') {
            return $next($request);
        }

        // Kalau dia siswa, tendang balik ke dashboard siswa!
        return redirect('/dashboard')->with('error', 'Akses Ditolak! Kamu bukan Admin.');
    }
}