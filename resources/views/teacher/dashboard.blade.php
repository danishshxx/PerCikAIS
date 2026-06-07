<x-layouts.teacher-percikais>
    <x-slot name="title">Dashboard</x-slot>

    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Dashboard</h1>
            <p class="text-[13px] text-slate-400 mt-1">Kelola kelas dan pantau aktivitas siswa</p>
        </div>
        <span class="text-[13px] text-slate-500 dark:text-slate-400">{{ now()->translatedFormat('l, d F Y') }}</span>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
        <div class="bg-[#F0EBFF] dark:bg-violet-500/10 rounded-2xl p-5 relative overflow-hidden">
            <p class="text-[12px] font-medium text-violet-500 dark:text-violet-400 mb-1">Mata Pelajaran</p>
            <h3 class="text-3xl font-extrabold text-slate-900 dark:text-white">{{ $totalCourses ?? 0 }}</h3>
            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">Mapel diampu</p>
            <svg class="absolute bottom-2 right-3 h-8 w-16 text-violet-400/30" viewBox="0 0 64 32" fill="none"><path d="M2 28 L12 22 L22 24 L32 16 L42 18 L52 8 L62 4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
        </div>

        <div class="bg-[#E8F4FD] dark:bg-blue-500/10 rounded-2xl p-5 relative overflow-hidden">
            <p class="text-[12px] font-medium text-blue-500 dark:text-blue-400 mb-1">Murid Ter-enroll</p>
            <h3 class="text-3xl font-extrabold text-slate-900 dark:text-white">{{ $totalEnrolledStudents ?? 0 }}</h3>
            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">Siswa aktif</p>
            <svg class="absolute bottom-2 right-3 h-8 w-16 text-blue-400/30" viewBox="0 0 64 32" fill="none"><path d="M2 20 L12 18 L22 20 L32 14 L42 16 L52 10 L62 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
        </div>

        <div class="bg-[#ECFDF5] dark:bg-emerald-500/10 rounded-2xl p-5 relative overflow-hidden">
            <p class="text-[12px] font-medium text-emerald-500 dark:text-emerald-400 mb-1">Absensi Hari Ini</p>
            <h3 class="text-3xl font-extrabold text-slate-900 dark:text-white">{{ $totalTodayAttendances ?? 0 }}</h3>
            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">Data tercatat</p>
            <svg class="absolute bottom-2 right-3 h-8 w-16 text-emerald-400/30" viewBox="0 0 64 32" fill="none"><path d="M2 24 L12 20 L22 18 L32 22 L42 12 L52 8 L62 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
        </div>

        <div class="bg-[#FFF7ED] dark:bg-amber-500/10 rounded-2xl p-5 relative overflow-hidden">
            <p class="text-[12px] font-medium text-amber-500 dark:text-amber-400 mb-1">Menunggu Verifikasi</p>
            <h3 class="text-3xl font-extrabold text-slate-900 dark:text-white">{{ $totalPendingRequests ?? 0 }}</h3>
            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">Sakit / izin siswa</p>
            <svg class="absolute bottom-2 right-3 h-8 w-16 text-amber-400/30" viewBox="0 0 64 32" fill="none"><path d="M2 26 L12 24 L22 20 L32 24 L42 14 L52 10 L62 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="bg-white dark:bg-[#0F1524] border border-slate-200/70 dark:border-slate-800/50 rounded-2xl">
        <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800/50">
            <h2 class="text-[15px] font-bold text-slate-900 dark:text-white">Akses Cepat</h2>
            <p class="text-[12px] text-slate-400 mt-0.5">Fitur utama untuk mengelola kelas</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-px bg-slate-100 dark:bg-slate-800/50">
            <a href="{{ route('teacher.attendance') }}" class="flex items-center gap-4 px-6 py-5 bg-white dark:bg-[#0F1524] hover:bg-slate-50 dark:hover:bg-slate-800/30 transition group">
                <div class="h-10 w-10 rounded-xl bg-violet-50 dark:bg-violet-500/10 flex items-center justify-center text-violet-500 dark:text-violet-400 group-hover:scale-110 transition-transform">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 4h8M9 4v3h6V4M7 7h10a2 2 0 0 1 2 2v9.5a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2Z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m8.5 14 2 2 5-5" /></svg>
                </div>
                <div>
                    <p class="text-[13px] font-semibold text-slate-800 dark:text-white group-hover:text-violet-600 dark:group-hover:text-violet-400 transition">Absensi Siswa</p>
                    <p class="text-[12px] text-slate-400 mt-0.5">Catat hadir, sakit, izin, dan alpa</p>
                </div>
                <svg class="h-4 w-4 ml-auto text-slate-300 group-hover:text-violet-400 transition" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7" /></svg>
            </a>

            <a href="{{ route('teacher.enrollments') }}" class="flex items-center gap-4 px-6 py-5 bg-white dark:bg-[#0F1524] hover:bg-slate-50 dark:hover:bg-slate-800/30 transition group">
                <div class="h-10 w-10 rounded-xl bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center text-blue-500 dark:text-blue-400 group-hover:scale-110 transition-transform">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 20v-1.5A4.5 4.5 0 0 0 11.5 14h-4A4.5 4.5 0 0 0 3 18.5V20" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.5 10.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7ZM21 8l-3 3-1.5-1.5" /></svg>
                </div>
                <div>
                    <p class="text-[13px] font-semibold text-slate-800 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">Enroll Murid</p>
                    <p class="text-[12px] text-slate-400 mt-0.5">Daftarkan murid ke mata pelajaran</p>
                </div>
                <svg class="h-4 w-4 ml-auto text-slate-300 group-hover:text-blue-400 transition" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7" /></svg>
            </a>
        </div>
    </div>

</x-layouts.teacher-percikais>