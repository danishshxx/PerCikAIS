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

    // Nangkap kembalian dari Google setelah user pilih email
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // CEK KEAMANAN: Cari apakah email Google ini ada di database kita?
            $registeredUser = User::where('email', $googleUser->email)->first();

            if ($registeredUser) {
                // Kalau terdaftar, langsung loginin
                Auth::login($registeredUser);
                return redirect()->intended('/dashboard');
            } else {
                // Kalau gak terdaftar (misal pake email pribadi), tendang balik!
                return redirect('/login')->with('error', 'Akses ditolak! Email tidak terdaftar di sistem sekolah. Silakan hubungi Administrator.');
            }

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Terjadi kesalahan saat login dengan Google.');
        }
    }
}