<x-layouts.teacher-percikais>
    <x-slot name="title">Dashboard Guru - PerCikAIS</x-slot>

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Panel Tenaga Pengajar</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Selamat datang kembali, mari kelola presensi murid hari ini.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white dark:bg-[#0A0F1C] p-6 rounded-3xl shadow-sm border border-gray-200 dark:border-gray-800 transition-colors">
            <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold mb-1 uppercase tracking-wider">Total Murid Terdaftar</p>
            <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalMurid }} <span class="text-sm font-normal text-gray-400">Siswa</span></h3>
        </div>
        <div class="bg-white dark:bg-[#0A0F1C] p-6 rounded-3xl shadow-sm border border-gray-200 dark:border-gray-800 transition-colors">
            <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold mb-1 uppercase tracking-wider">Presensi Hari Ini</p>
            <h3 class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $absensiHariIni }} <span class="text-sm font-normal text-gray-400">Tercatat</span></h3>
        </div>
    </div>

    <div class="bg-white dark:bg-[#0A0F1C] rounded-3xl p-8 border border-gray-200 dark:border-gray-800 shadow-sm text-center transition-colors">
        <div class="w-24 h-24 bg-green-100 dark:bg-green-900/20 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-green-600 dark:text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
        </div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Manajemen Presensi</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm max-w-md mx-auto mb-8">
            Pastikan setiap murid yang hadir telah tercatat dalam sistem. Kamu dapat menginput data presensi secara manual melalui menu Absensi Murid.
        </p>
        <a href="{{ route('teacher.attendance') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-xl transition-all shadow-lg shadow-blue-600/20">
            Buka Menu Absensi
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
        </a>
    </div>
</x-layouts.teacher-percikais>
