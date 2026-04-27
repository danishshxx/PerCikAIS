<x-layouts.admin-percikais>
    <x-slot name="title">Dashboard Admin - PerCikAIS</x-slot>

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Panel Administrator</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Pusat manajemen data akademik dan operasional sekolah.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-[#0A0F1C] p-6 rounded-3xl shadow-sm border border-gray-200 dark:border-gray-800 transition-colors">
            <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold mb-1 uppercase tracking-wider">Total Siswa Aktif</p>
            <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalSiswa }} <span class="text-sm font-normal text-gray-400">Murid</span></h3>
        </div>
        <div class="bg-white dark:bg-[#0A0F1C] p-6 rounded-3xl shadow-sm border border-gray-200 dark:border-gray-800 transition-colors">
            <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold mb-1 uppercase tracking-wider">Pemasukan SPP (Lunas)</p>
            <h3 class="text-3xl font-bold text-green-600 dark:text-green-400">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
        </div>
        <div class="bg-white dark:bg-[#0A0F1C] p-6 rounded-3xl shadow-sm border border-gray-200 dark:border-gray-800 transition-colors">
            <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold mb-1 uppercase tracking-wider">Tunggakan Administrasi</p>
            <h3 class="text-3xl font-bold text-red-600 dark:text-red-400">Rp {{ number_format($totalTunggakan, 0, ',', '.') }}</h3>
        </div>
    </div>

    <div class="bg-white dark:bg-[#0A0F1C] rounded-3xl p-8 border border-gray-200 dark:border-gray-800 shadow-sm text-center transition-colors">
        <img src="https://ui-avatars.com/api/?name=Admin&background=2563eb&color=fff&rounded=true&size=128" alt="Welcome" class="w-20 h-20 mx-auto mb-4 shadow-lg rounded-full">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Selamat Bertugas, Admin!</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm max-w-md mx-auto">Gunakan menu navigasi untuk mengelola data murid, memverifikasi absensi harian, atau mengatur tagihan sekolah secara efisien.</p>
    </div>
</x-layouts.admin-percikais>
