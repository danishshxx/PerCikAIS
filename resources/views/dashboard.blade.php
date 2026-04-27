<x-layouts.app-percikais>
    <x-slot name="title">Beranda Siswa - PerCikAIS</x-slot>

    <div class="bg-blue-600 rounded-3xl p-8 mb-8 flex flex-col md:flex-row justify-between items-center shadow-[0_10px_30px_rgba(37,99,235,0.2)] bg-gradient-to-r from-blue-600 to-blue-500 relative overflow-hidden gap-6">
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 text-white text-center md:text-left">
            <h1 class="text-2xl md:text-3xl font-bold mb-2">Halo, {{ Auth::user()->name }}! 👋</h1>
            <p class="text-blue-100 text-sm max-w-md">Selamat datang di Portal Informasi Akademik Perguruan Cikini.</p>
        </div>
        
        <a href="https://perclms.hbii.my.id/" target="_blank" class="relative z-10 bg-white dark:bg-[#050B14] text-blue-600 dark:text-white px-6 py-3.5 rounded-xl text-sm font-semibold transition-all border border-transparent dark:border-gray-800 shadow-xl flex items-center gap-3 group hover:scale-105 whitespace-nowrap">
            Buka Ruang Belajar (LMS)
            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-[#121A2F] border border-gray-200 dark:border-gray-800/60 p-6 rounded-2xl shadow-sm dark:shadow-none transition-colors duration-300">
            <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold mb-1 uppercase tracking-wider">Presensi Semester</p>
            <h3 class="text-2xl font-bold mb-2">95%</h3>
            <span class="text-xs text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-500/10 px-2 py-1 rounded-md font-medium">Status: Rajin</span>
        </div>
        <div class="bg-white dark:bg-[#121A2F] border border-gray-200 dark:border-gray-800/60 p-6 rounded-2xl shadow-sm dark:shadow-none transition-colors duration-300">
            <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold mb-1 uppercase tracking-wider">Mata Pelajaran</p>
            <h3 class="text-2xl font-bold mb-2">12 <span class="text-sm font-normal text-gray-400 dark:text-gray-500">Tuntas</span></h3>
            <div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-1.5 mt-3">
                <div class="bg-blue-500 h-1.5 rounded-full" style="width: 85%"></div>
            </div>
        </div>
        <div class="bg-white dark:bg-[#121A2F] border border-gray-200 dark:border-gray-800/60 p-6 rounded-2xl shadow-sm dark:shadow-none transition-colors duration-300 flex flex-col justify-between">
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold mb-1 uppercase tracking-wider">Status Administrasi</p>
                <h3 class="text-2xl font-bold mb-2 text-gray-900 dark:text-white">Lengkap</h3>
            </div>
            <a href="{{ route('finance.index') }}" class="w-full mt-2 text-center text-xs font-semibold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-500/10 hover:bg-blue-100 dark:hover:bg-blue-500/20 py-2 rounded-lg transition-colors border border-blue-200 dark:border-blue-500/20 block">
                Riwayat SPP
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-[#0A0F1C] border border-gray-200 dark:border-gray-800/60 rounded-3xl p-6 shadow-sm dark:shadow-xl transition-colors duration-300">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Jadwal Mapel Hari Ini</h2>
            <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">{{ now()->format('d M Y') }}</span>
        </div>
        
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 bg-gray-50 dark:bg-[#121A2F] border border-gray-100 dark:border-gray-800 rounded-2xl transition-colors duration-300 gap-4">
            <div class="flex gap-4">
                <div class="text-center min-w-[50px]">
                    <p class="text-sm font-bold text-gray-900 dark:text-white">08:00</p>
                    <p class="text-xs text-gray-500">10:30</p>
                </div>
                <div class="w-px bg-gray-200 dark:bg-gray-800 hidden sm:block"></div>
                <div>
                    <p class="text-sm font-bold text-blue-600 dark:text-blue-400">Teknologi Informasi & Komunikasi</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Ruang Lab Komputer B
                    </p>
                </div>
            </div>
            
            <div class="text-right w-full sm:w-auto">
                <span class="text-xs font-bold px-3 py-1.5 rounded-lg bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400">
                    Hadir
                </span>
                <p class="text-[10px] text-gray-500 mt-2">Diverifikasi oleh Guru</p>
            </div>
        </div>
    </div>
</x-layouts.app-percikais>
