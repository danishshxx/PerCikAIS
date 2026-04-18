<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dasbor SIAKAD - Integrasi LMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-[#050B14] text-gray-900 dark:text-white flex h-screen overflow-hidden transition-colors duration-300 selection:bg-blue-500 selection:text-white">

    <aside class="w-64 bg-white dark:bg-[#0A0F1C] border-r border-gray-200 dark:border-gray-800 flex flex-col justify-between transition-colors duration-300">
        <div class="p-6">
            <div class="flex items-center justify-between mb-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center font-bold text-xl text-white">S</div>
                    <span class="text-lg font-bold tracking-wider">SIAKAD</span>
                </div>
                
                <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none rounded-lg text-sm p-2.5 transition-colors">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                </button>
            </div>

            <nav class="space-y-2 text-sm font-medium">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-500 border border-blue-200 dark:border-blue-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dasbor
                </a>
                <a href="{{ route('attendance.index') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-[#121A2F] hover:text-gray-900 dark:hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Rekap Kehadiran
                </a>
                <a href="{{ route('finance.index') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-[#121A2F] hover:text-gray-900 dark:hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    Keuangan
                </a>
            </nav>
        </div>

        <div class="p-6 border-t border-gray-200 dark:border-gray-800">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden flex items-center justify-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Siswa Aktif</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-xs font-semibold text-red-500 dark:text-red-400 bg-red-50 dark:bg-red-500/10 hover:bg-red-100 dark:hover:bg-red-500/20 py-2.5 rounded-lg transition-colors">
                    Keluar Sistem
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-8 overflow-y-auto">
        
        <div class="bg-blue-600 rounded-3xl p-8 mb-8 flex justify-between items-center shadow-[0_10px_30px_rgba(37,99,235,0.2)] bg-gradient-to-r from-blue-600 to-blue-500 relative overflow-hidden">
            <div class="absolute -right-20 -top-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            
            <div class="relative z-10 text-white">
                <h1 class="text-3xl font-bold mb-2">Selamat datang, {{ Auth::user()->name }}! ✨</h1>
                <p class="text-blue-100 text-sm max-w-md">Sistem Informasi Akademik Terpadu. Pantau rekap kehadiranmu dan cek materi terbaru di LMS.</p>
            </div>
            
            <a href="https://perclms.hbii.my.id/" target="_blank" class="relative z-10 bg-white dark:bg-[#050B14] text-blue-600 dark:text-white px-6 py-3.5 rounded-xl text-sm font-semibold transition-all border border-transparent dark:border-gray-800 shadow-xl flex items-center gap-3 group hover:scale-105">
                Akses pErC LMS
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-[#121A2F] border border-gray-200 dark:border-gray-800/60 p-6 rounded-2xl shadow-sm dark:shadow-none transition-colors duration-300">
                <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold mb-1 uppercase tracking-wider">Kehadiran Semester</p>
                <h3 class="text-2xl font-bold mb-2">95%</h3>
                <span class="text-xs text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-500/10 px-2 py-1 rounded-md font-medium">Aman dari SP</span>
            </div>
            <div class="bg-white dark:bg-[#121A2F] border border-gray-200 dark:border-gray-800/60 p-6 rounded-2xl shadow-sm dark:shadow-none transition-colors duration-300">
                <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold mb-1 uppercase tracking-wider">Total SKS</p>
                <h3 class="text-2xl font-bold mb-2">84 <span class="text-sm font-normal text-gray-400 dark:text-gray-500">/ 144</span></h3>
                <div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-1.5 mt-3">
                    <div class="bg-blue-500 h-1.5 rounded-full" style="width: 58%"></div>
                </div>
            </div>
            <div class="bg-white dark:bg-[#121A2F] border border-gray-200 dark:border-gray-800/60 p-6 rounded-2xl shadow-sm dark:shadow-none transition-colors duration-300 flex flex-col justify-between">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold mb-1 uppercase tracking-wider">Status Pembayaran</p>
                    <h3 class="text-2xl font-bold mb-2 text-gray-900 dark:text-white">Pending</h3>
                </div>
                <a href="{{ route('finance.index') }}" class="w-full mt-2 text-center text-xs font-semibold text-yellow-600 dark:text-yellow-500 bg-yellow-50 dark:bg-yellow-500/10 hover:bg-yellow-100 dark:hover:bg-yellow-500/20 py-2 rounded-lg transition-colors border border-yellow-200 dark:border-yellow-500/20 block">
                    Cek Keuangan
                </a>
            </div>
        </div>

        <div class="bg-white dark:bg-[#0A0F1C] border border-gray-200 dark:border-gray-800/60 rounded-3xl p-6 shadow-sm dark:shadow-xl transition-colors duration-300">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-bold">Jadwal Kelas Hari Ini</h2>
                <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">{{ now()->format('d M Y') }}</span>
            </div>
            
            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-[#121A2F] border border-gray-100 dark:border-gray-800 rounded-2xl transition-colors duration-300">
                <div class="flex gap-4">
                    <div class="text-center">
                        <p class="text-sm font-bold">08:00</p>
                        <p class="text-xs text-gray-500">10:30</p>
                    </div>
                    <div class="w-px bg-gray-200 dark:bg-gray-800"></div>
                    <div>
                        <p class="text-sm font-bold text-blue-600 dark:text-blue-400">Integrasi Aplikasi Enterprise</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Ruang Lab B
                        </p>
                    </div>
                </div>
                
                <div class="text-right">
                    <span class="text-xs font-bold px-3 py-1.5 rounded-lg bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400">
                        Tercatat Hadir
                    </span>
                    <p class="text-[10px] text-gray-500 mt-2">Diinput oleh Guru</p>
                </div>
                
            </div>
        </div>

    </main>

    <script>
        var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

        var themeToggleBtn = document.getElementById('theme-toggle');

        themeToggleBtn.addEventListener('click', function() {
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            if (localStorage.getItem('color-theme')) {
                if (localStorage.getItem('color-theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            }
        });
    </script>
</body>
</html>