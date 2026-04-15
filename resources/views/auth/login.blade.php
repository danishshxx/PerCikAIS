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
    <p class="text-gray-400 mb-8 text-sm">Silakan masuk ke akun pErC LMS Anda</p>

    <div class="w-full max-w-[420px] bg-[#0A0F1C] border border-gray-800/60 rounded-3xl p-8 shadow-2xl">
        
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-6">
                <label for="email" class="block text-[11px] font-semibold text-gray-400 mb-2 uppercase tracking-widest">Identifier / ID Pengguna</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                        </svg>
                    </div>
                    <input type="email" name="email" id="email" class="w-full bg-[#121A2F] border border-gray-800 text-white text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block pl-12 p-3.5 transition-colors placeholder-gray-600" placeholder="e.g murid@sekolah.com" required autofocus autocomplete="username">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-xs" />
            </div>

            <div class="mb-8">
                <div class="flex justify-between items-center mb-2">
                    <label for="password" class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest">Kata Sandi</label>
                    <a href="{{ route('password.request') }}" class="text-xs text-blue-500 hover:text-blue-400 transition-colors">Lupa Akses?</a>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                    </div>
                    <input type="password" name="password" id="password" class="w-full bg-[#121A2F] border border-gray-800 text-white text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block pl-12 p-3.5 transition-colors placeholder-gray-600" placeholder="••••••••" required autocomplete="current-password">
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-xs" />
            </div>

            <button type="submit" class="w-full text-white bg-[#3B82F6] hover:bg-[#2563EB] focus:ring-4 focus:outline-none focus:ring-blue-500/50 font-medium rounded-xl text-sm px-5 py-3.5 text-center shadow-[0_0_20px_rgba(59,130,246,0.4)] transition-all flex justify-center items-center gap-2">
                Masuk Ke LMS
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </form>

        <p class="text-center text-xs text-gray-500 mt-8">Akun dibuat oleh Administrator sistem.</p>
    </div>

</body>
</html>