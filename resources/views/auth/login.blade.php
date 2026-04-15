<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - PErC LMS Integrasi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#050B14] min-h-screen flex flex-col justify-center items-center selection:bg-blue-500 selection:text-white">

    <div class="mb-6 bg-[#121A2F] p-4 rounded-3xl shadow-[0_0_20px_rgba(37,99,235,0.15)] border border-gray-800/50">
        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path>
        </svg>
    </div>

    <h2 class="text-3xl font-bold text-white mb-2 tracking-tight">Selamat Datang</h2>
    <p class="text-gray-400 mb-8 text-sm">Silakan masuk ke portal terpadu pErC LMS</p>

    <div class="w-full max-w-[420px] bg-[#0A0F1C] border border-gray-800/60 rounded-3xl p-8 shadow-2xl">
        
        @if(session('error'))
            <div class="mb-6 p-4 text-sm text-red-400 bg-red-900/30 border border-red-800/50 rounded-xl text-center" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-[#121A2F] rounded-2xl flex items-center justify-center mx-auto mb-4 border border-gray-800">
                <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-white">Akses Siswa</h3>
            <p class="text-xs text-gray-500 mt-1">Gunakan email Google Workspace sekolah yang telah didaftarkan oleh admin.</p>
        </div>

        <a href="{{ route('google.login') }}" class="w-full text-white bg-[#3B82F6] hover:bg-[#2563EB] focus:ring-4 focus:outline-none focus:ring-blue-500/50 font-medium rounded-xl text-sm px-5 py-3.5 text-center shadow-[0_0_20px_rgba(59,130,246,0.4)] transition-all flex justify-center items-center gap-2 cursor-pointer">
            Masuk dengan Google
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </a>

        <p class="text-center text-xs text-gray-600 mt-8">Hubungi Administrator jika akun bermasalah.</p>
    </div>

</body>
</html>