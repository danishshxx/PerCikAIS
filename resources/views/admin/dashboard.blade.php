<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel - PerCikAIS</title>
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

    <aside class="w-64 bg-white dark:bg-[#0A0F1C] border-r border-gray-200 dark:border-gray-800 flex flex-col justify-between overflow-y-auto">
        <div class="p-6">
            <div class="flex items-center justify-between mb-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center font-bold text-xl text-white shadow-lg shadow-blue-600/20">A</div>
                    <span class="text-lg font-bold tracking-wider text-gray-900 dark:text-white">Admin</span>
                </div>
                <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none rounded-lg text-sm p-2.5 transition-colors">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path></svg>
                </button>
            </div>
            
            <nav class="space-y-2 text-sm font-medium">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-500 border border-blue-200 dark:border-blue-500/20 transition-colors">
                    Dasbor Utama
                </a>
                <a href="{{ route('admin.students') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-[#121A2F] transition-colors">
                    Kelola Siswa
                </a>
                <a href="{{ route('admin.attendance') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-[#121A2F] transition-colors">
                    Input Absensi & Jadwal
                </a>
                <a href="{{ route('admin.finance') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-[#121A2F] transition-colors">
                    Kelola Tagihan (Keuangan)
                </a>
            </nav>
        </div>
        <div class="p-6 border-t border-gray-200 dark:border-gray-800">
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-4 font-medium">Sistem Administrator</p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 py-3 rounded-xl transition-all shadow-md shadow-blue-600/20">Keluar Sistem</button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-8 overflow-y-auto">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dasbor Administrator</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Pusat kendali akademik dan keuangan PerCikAIS.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-[#0A0F1C] p-6 rounded-3xl shadow-sm border border-gray-200 dark:border-gray-800 transition-colors">
                <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold mb-1 uppercase tracking-wider">Total Siswa Aktif</p>
                <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalSiswa }} <span class="text-sm font-normal text-gray-400">orang</span></h3>
            </div>
            <div class="bg-white dark:bg-[#0A0F1C] p-6 rounded-3xl shadow-sm border border-gray-200 dark:border-gray-800 transition-colors">
                <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold mb-1 uppercase tracking-wider">Pendapatan (Lunas)</p>
                <h3 class="text-3xl font-bold text-green-600 dark:text-green-400">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
            </div>
            <div class="bg-white dark:bg-[#0A0F1C] p-6 rounded-3xl shadow-sm border border-gray-200 dark:border-gray-800 transition-colors">
                <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold mb-1 uppercase tracking-wider">Tunggakan (Pending)</p>
                <h3 class="text-3xl font-bold text-red-600 dark:text-red-400">Rp {{ number_format($totalTunggakan, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="bg-white dark:bg-[#0A0F1C] rounded-3xl p-8 border border-gray-200 dark:border-gray-800 shadow-sm text-center transition-colors">
            <img src="https://ui-avatars.com/api/?name=Admin&background=2563eb&color=fff&rounded=true&size=128" alt="Welcome" class="w-20 h-20 mx-auto mb-4 shadow-lg rounded-full">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Selamat Bekerja, Admin!</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm max-w-md mx-auto">Silakan pilih menu di sebelah kiri untuk mulai mengelola data siswa, menyebarkan tagihan SPP, atau menginput kehadiran kelas hari ini.</p>
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