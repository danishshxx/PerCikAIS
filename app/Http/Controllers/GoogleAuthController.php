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
    // public function callback()
    // {
    //     try {
    //         $googleUser = Socialite::driver('google')->user();

    //         // CEK KEAMANAN: Cari apakah email Google ini ada di database kita?
    //         $registeredUser = User::where('email', $googleUser->email)->first();

    //         if ($registeredUser) {
    //             // Kalau terdaftar, langsung loginin
    //             Auth::login($registeredUser);
    //             return redirect()->intended('/dashboard');
    //         } else {
    //             // Kalau gak terdaftar (misal pake email pribadi), tendang balik!
    //             return redirect('/login')->with('error', 'Akses ditolak! Email tidak terdaftar di sistem sekolah. Silakan hubungi Administrator.');
    //         }

    //     } catch (\Exception $e) {
    //         // MATIIN SEMENTARA REDIRECT-NYA, KITA MUNCULIN ERROR ASLINYA 👇
    //         dd($e->getMessage()); 
            
    //         // return redirect('/login')->with('error', 'Terjadi kesalahan saat login dengan Google.');
    //     }
    // }

    public function callback()
    {
        try {
        // 1. Tangkap data dari Google
        $googleUser = Socialite::driver('google')->user();

        // 2. Cari user di database, atau daftarin kalau belum ada
        $user = User::where('email', $googleUser->getEmail())->first();
        
        if (!$user) {
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                // Password diacak aja karena loginnya pake Google
                'password' => bcrypt(uniqid()), 
                // Otomatis jadi siswa kalau baru pertama kali daftar
                'role' => 'student' 
            ]);
        }

        // 3. MASUKIN DIA KE SISTEM LARAVEL (LOGIN) - Wajib sebelum ngecek role!
        Auth::login($user);

        // 4. PERSIMPANGAN JALAN (Cek role pakai variabel $user langsung)
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard'); // Lempar ke Dapur Admin
        }

        return redirect()->route('dashboard'); // Lempar ke Halaman Siswa

    } catch (\Exception $e) {
        // Balikin peredam kejutnya biar aman
        // dd($e->getMessage()); // (Bisa lu hapus atau di-comment aja sekarang)
        return redirect('/login')->with('error', 'Terjadi kesalahan saat login dengan Google.');
    }
    }
}