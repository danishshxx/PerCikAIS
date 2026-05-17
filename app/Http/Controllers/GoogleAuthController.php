<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleAuthController extends Controller
{
    // Arahin user ke halaman login Google
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    // Nangkap kembalian dari Google
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // KARENA KITA CUMA FE: Kita cuma bertugas "Membaca" (Read), bukan "Membuat" (Create)
            $user = User::where('email', $googleUser->getEmail())->first();

            // dd($user->role, $user->email);

            if ($user) {
                // Lolos masuk sistem
                Auth::login($user);

                // Arahkan sesuai role
                if ($user->isAdmin()) return redirect()->route('admin.dashboard'); 
                if ($user->isTeacher()) return redirect()->route('teacher.dashboard');
                
                return redirect()->route('dashboard'); 
            } else {
                // Email belum didaftarin sama Admin / Backend
                return redirect('/login')->with('error', 'Akses ditolak! Email Anda belum terdaftar di SIAKAd Cikini. Silakan hubungi Administrator.');
            }

        } catch (\Exception $e) {
            dd($e->getMessage()); 
        }
    }

    // Login via Scanner QR (Tetep dibiarin buat fitur bypass)
    public function qrLoginCallback(Request $request)
    {
        try {
            $qrJwt = $request->input('qrJwt');
            if (!$qrJwt) return response()->json(['error' => 'No QR token provided'], 400);

            $parts = explode('.', $qrJwt);
            if (count($parts) < 2) return response()->json(['error' => 'Invalid token'], 400);
            
            $payload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $parts[1])));
            if (!$payload || !isset($payload->sub)) return response()->json(['error' => 'Invalid token payload'], 400);

            $user = User::where('email', $payload->sub)->first();
            if (!$user) return response()->json(['error' => 'User not found in database'], 404);

            Auth::login($user);

            $redirectUrl = route('dashboard');
            if ($user->isAdmin()) $redirectUrl = route('admin.dashboard');
            else if ($user->isTeacher()) $redirectUrl = route('teacher.dashboard');

            return response()->json(['success' => true, 'redirect' => $redirectUrl]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}