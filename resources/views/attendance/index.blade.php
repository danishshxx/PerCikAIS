<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jadwal & Absensi - SIAKAD</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-[#050B14] text-gray-900 dark:text-white flex h-screen overflow-hidden transition-colors duration-300">

    <aside class="w-64 bg-white dark:bg-[#0A0F1C] border-r border-gray-200 dark:border-gray-800 flex flex-col justify-between">
        <div class="p-6">
            <div class="flex items-center justify-between mb-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center font-bold text-xl text-white">S</div>
                    <span class="text-lg font-bold tracking-wider">SIAKAD</span>
                </div>
                <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg text-sm p-2.5">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path></svg>
                </button>
            </div>
            <nav class="space-y-2 text-sm font-medium">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-[#121A2F]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dasbor
                </a>
                <a href="{{ route('attendance.index') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-500 border border-blue-200 dark:border-blue-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Jadwal & Absensi
                </a>
            </nav>
        </div>
        <div class="p-6 border-t border-gray-200 dark:border-gray-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-xs font-semibold text-red-500 bg-red-50 dark:bg-red-500/10 py-2.5 rounded-lg">Keluar Sistem</button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-8 overflow-y-auto">
        <div class="mb-8">
            <h1 class="text-2xl font-bold">Jadwal & Riwayat Absensi</h1>
            <p class="text-sm text-gray-500">Pantau kehadiranmu secara real-time.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white dark:bg-[#0A0F1C] border border-gray-200 dark:border-gray-800 rounded-3xl p-6">
                    <h2 class="font-bold mb-4">Jadwal Mingguan</h2>
                    <div class="p-4 bg-gray-50 dark:bg-[#121A2F] rounded-2xl flex justify-between items-center">
                        <div>
                            <p class="font-bold text-blue-600">Integrasi Aplikasi Enterprise</p>
                            <p class="text-xs text-gray-500">Senin, 08:00 - 10:30</p>
                        </div>
                        <form action="{{ route('attendance.store') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-blue-600 text-white text-xs px-4 py-2 rounded-lg">Absen Sekarang</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-[#0A0F1C] border border-gray-200 dark:border-gray-800 rounded-3xl p-6">
                <h2 class="font-bold mb-4">Riwayat Terbaru</h2>
                <div class="space-y-3">
                    @forelse($history as $log)
                    <div class="p-3 bg-gray-50 dark:bg-[#121A2F] rounded-xl border border-gray-100 dark:border-gray-800 flex justify-between items-center">
                        <span class="text-xs font-medium">{{ \Carbon\Carbon::parse($log->attendance_date)->format('d M Y') }}</span>
                        <span class="text-[10px] font-bold uppercase text-green-500">Hadir</span>
                    </div>
                    @empty
                    <p class="text-xs text-gray-500 text-center">Belum ada data.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </main>

    <script>
        var themeToggleBtn = document.getElementById('theme-toggle');
        var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

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