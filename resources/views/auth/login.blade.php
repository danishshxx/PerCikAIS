<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - PErC LMS Integrasi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-[#050B14] min-h-screen flex flex-col justify-center items-center selection:bg-blue-500 selection:text-white transition-colors duration-500">

    <div class="mb-6 bg-white dark:bg-[#121A2F] p-4 rounded-3xl shadow-sm dark:shadow-[0_0_20px_rgba(37,99,235,0.15)] border border-gray-200 dark:border-gray-800/50 transition-colors duration-500">
        <svg class="w-8 h-8 text-blue-600 dark:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path>
        </svg>
    </div>

    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2 tracking-tight transition-colors duration-500">Selamat Datang</h2>
    <p class="text-gray-500 dark:text-gray-400 mb-8 text-sm transition-colors duration-500">Silakan melakukan Login untuk melanjutkan</p>

    <div class="w-full max-w-[420px] bg-white dark:bg-[#0A0F1C] border border-gray-200 dark:border-gray-800/60 rounded-3xl p-8 shadow-xl dark:shadow-2xl transition-colors duration-500">
        
        @if(session('error'))
            <div class="mb-6 p-4 text-sm text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800/50 rounded-xl text-center transition-colors duration-500" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gray-50 dark:bg-[#121A2F] rounded-2xl flex items-center justify-center mx-auto mb-4 border border-gray-200 dark:border-gray-800 transition-colors duration-500">
                <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white transition-colors duration-500">Akses Siswa</h3>
            <p class="text-xs text-gray-500 mt-1 transition-colors duration-500">Gunakan email Google Workspace sekolah yang telah didaftarkan oleh admin.</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- NIM / Email Input -->
            <div>
                <label for="login" class="block text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2">NIM / Email</label>
                <input type="text" id="login" name="login" required placeholder="Masukkan NIM atau Email Anda" 
                    value="{{ old('login') }}"
                    class="w-full h-12 rounded-2xl border border-gray-200 dark:border-gray-850 bg-gray-50 dark:bg-[#121929] px-4 text-sm font-semibold text-gray-800 dark:text-white outline-none transition focus:border-blue-500 focus:bg-white dark:focus:bg-[#121929] focus:ring-4 focus:ring-blue-500/10">
                @error('login')
                    <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password Input -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Password</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs font-semibold text-blue-600 dark:text-blue-400 hover:underline">Lupa Password?</a>
                    @endif
                </div>
                <input type="password" id="password" name="password" required placeholder="••••••••" 
                    class="w-full h-12 rounded-2xl border border-gray-200 dark:border-gray-850 bg-gray-50 dark:bg-[#121929] px-4 text-sm font-semibold text-gray-800 dark:text-white outline-none transition focus:border-blue-500 focus:bg-white dark:focus:bg-[#121929] focus:ring-4 focus:ring-blue-500/10">
                @error('password')
                    <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 dark:border-gray-700 text-blue-600 shadow-sm focus:ring-blue-500 dark:bg-gray-900">
                <label for="remember_me" class="ml-2 text-xs font-semibold text-gray-500 dark:text-gray-400">Ingat saya di perangkat ini</label>
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                class="w-full h-12 text-white bg-blue-600 hover:bg-blue-700 font-bold rounded-2xl text-sm px-5 py-2.5 text-center flex items-center justify-center transition shadow-lg shadow-blue-500/10 hover:shadow-blue-500/20">
                Masuk ke Akun
            </button>
        </form>

        <div class="flex items-center gap-4 my-6">
            <div class="h-px bg-gray-200 dark:bg-gray-850 flex-1"></div>
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Atau masuk dengan</span>
            <div class="h-px bg-gray-200 dark:bg-gray-850 flex-1"></div>
        </div>

        <div class="grid grid-cols-2 gap-3">
            <a href="{{ url('/auth/google') }}" 
                onclick="prosesLoginGoogle(event, '{{ url('/auth/google') }}')"
                class="text-gray-700 dark:text-gray-200 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 font-bold rounded-2xl text-sm px-4 py-3 text-center flex items-center justify-center transition-colors">
                Google
            </a>

            <button type="button" onclick="openQrModal()"
                class="text-gray-700 dark:text-gray-200 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 font-bold rounded-2xl text-sm px-4 py-3 text-center flex items-center justify-center transition-colors">
                Kode QR
            </button>
        </div>

        <p class="text-center text-xs text-gray-400 dark:text-gray-600 mt-8 transition-colors duration-500">Hubungi Administrator jika akun bermasalah.</p>
    </div>

    <!-- QR Modal -->
    <div id="qr-modal" class="fixed inset-0 z-[100] bg-black/50 backdrop-blur-sm hidden flex-col items-center justify-center">
        <div class="bg-white dark:bg-[#121A2F] rounded-3xl p-8 max-w-sm w-full shadow-2xl relative animate-in zoom-in-95 duration-300">
            <button onclick="closeQrModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 mb-4">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Login dengan QR</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                    Buka aplikasi MyPercik, lalu scan QR code ini.
                </p>
                
                <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-2xl flex items-center justify-center min-h-[250px]">
                    <div id="qr-loading" class="animate-spin text-gray-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    </div>
                    <img id="qr-image" class="hidden rounded-xl shadow-sm" alt="QR Code" />
                </div>
                
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-6 animate-pulse">
                    Menunggu hasil scan...
                </p>
                <div id="qr-error" class="hidden text-xs text-red-500 mt-2"></div>
            </div>
        </div>

    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <script>
        function prosesLoginGoogle(event, url) {
            event.preventDefault(); // Tahan dulu biar ga langsung pindah

            // Munculin layar loading logo
            const loader = document.getElementById('custom-loader');
            if (loader) {
                loader.classList.remove('hidden');
                loader.classList.add('flex');
            }

            // Kasih jeda 0.5 detik biar animasinya nongol dulu, baru pindah ke Google
            setTimeout(() => {
                window.location.href = url;
            }, 300);
        }

        let qrPollInterval = null;

        async function openQrModal() {
            const modal = document.getElementById('qr-modal');
            const loading = document.getElementById('qr-loading');
            const qrImage = document.getElementById('qr-image');
            const errorDiv = document.getElementById('qr-error');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            loading.classList.remove('hidden');
            qrImage.classList.add('hidden');
            errorDiv.classList.add('hidden');

            try {
                // Generate QR Token dari Backend Rust
                const res = await fetch('https://percikapi.hbii.my.id/api/auth/qr/generate', { method: 'POST' });
                if (!res.ok) throw new Error('Gagal terhubung ke server');
                const data = await res.json();
                const token = data.qr_token;

                // Tampilkan QR Code (pake API goqr.me biar gampang tanpa library berat)
                qrImage.src = `https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=${token}`;
                qrImage.onload = () => {
                    loading.classList.add('hidden');
                    qrImage.classList.remove('hidden');
                };

                // Mulai Polling
                if (qrPollInterval) clearInterval(qrPollInterval);
                qrPollInterval = setInterval(async () => {
                    try {
                        const statusRes = await fetch(`https://percikapi.hbii.my.id/api/auth/qr/status?token=${token}`);
                        if (!statusRes.ok) return;
                        const statusData = await statusRes.json();

                        if (statusData.status === 'approved' && statusData.token) {
                            clearInterval(qrPollInterval);
                            
                            // Kirim JWT ke Laravel buat diproses login
                            const loginRes = await fetch('/auth/qr-login', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({ qrJwt: statusData.token })
                            });

                            const loginData = await loginRes.json();
                            if (loginData.success) {
                                window.location.href = loginData.redirect;
                            } else {
                                errorDiv.textContent = loginData.error || 'Gagal login ke SIAKAd';
                                errorDiv.classList.remove('hidden');
                            }
                        }
                    } catch (e) {
                        console.error('Polling error', e);
                    }
                }, 2000);

            } catch (error) {
                loading.classList.add('hidden');
                errorDiv.textContent = error.message;
                errorDiv.classList.remove('hidden');
            }
        }

        function closeQrModal() {
            if (qrPollInterval) clearInterval(qrPollInterval);
            const modal = document.getElementById('qr-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>

    <div id="custom-loader" class="fixed inset-0 z-[9999] bg-white/80 dark:bg-[#050B14]/90 backdrop-blur-md hidden flex-col items-center justify-center transition-all duration-300">
        <div class="relative w-28 h-28 mb-6 flex items-center justify-center">
            <img src="https://ui-avatars.com/api/?name=S&background=2563EB&color=fff&rounded=true&size=128" alt="Logo" class="w-20 h-20 object-contain animate-pulse drop-shadow-2xl z-10 relative">
            <div class="absolute inset-0 border-4 border-blue-200 dark:border-blue-900/50 rounded-full"></div>
            <div class="absolute inset-0 border-4 border-blue-600 rounded-full border-t-transparent animate-spin"></div>
        </div>
        <h3 class="text-xl font-bold text-gray-900 dark:text-white tracking-wider uppercase mb-1">Perguruan Cikini</h3>
        <p class="text-sm font-medium text-blue-600 dark:text-blue-400 animate-pulse">Menghubungkan ke Google...</p>
    </div>

</body>
</html>