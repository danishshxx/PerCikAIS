<x-layouts.app-percikais>
    <x-slot name="title">Beranda</x-slot>

    {{-- ═══════ Page Header (SnowUI style) ═══════ --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Ikhtisar</h1>
            <p class="text-[13px] text-slate-400 mt-1">Selamat datang, {{ auth()->user()->name }}!</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-[13px] text-slate-500 dark:text-slate-400">{{ now()->translatedFormat('l, d F Y') }}</span>
        </div>
    </div>

    {{-- ═══════ Stat Cards (SnowUI lavender style) ═══════ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
        {{-- Presensi Semester --}}
        <div class="bg-[#F0EBFF] dark:bg-violet-500/10 rounded-2xl p-5 relative overflow-hidden group">
            <p class="text-[12px] font-medium text-violet-500 dark:text-violet-400 mb-1">Presensi Semester</p>
            <div class="flex items-end gap-3">
                <h3 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">95%</h3>
                <span class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-0.5 mb-1.5">
                    +2.1%
                    <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7" /></svg>
                </span>
            </div>
            {{-- Mini sparkline --}}
            <svg class="absolute bottom-2 right-3 h-8 w-16 text-violet-400/30" viewBox="0 0 64 32" fill="none">
                <path d="M2 28 L12 22 L22 24 L32 16 L42 18 L52 8 L62 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none"/>
            </svg>
        </div>

        {{-- Mata Pelajaran --}}
        <div class="bg-[#F0EBFF] dark:bg-violet-500/10 rounded-2xl p-5 relative overflow-hidden group">
            <p class="text-[12px] font-medium text-violet-500 dark:text-violet-400 mb-1">Mata Pelajaran</p>
            <div class="flex items-end gap-3">
                <h3 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">12</h3>
                <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 mb-1.5">
                    Aktif
                </span>
            </div>
            <svg class="absolute bottom-2 right-3 h-8 w-16 text-violet-400/30" viewBox="0 0 64 32" fill="none">
                <path d="M2 20 L12 18 L22 20 L32 14 L42 16 L52 10 L62 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none"/>
            </svg>
        </div>

        {{-- Status SPP --}}
        <div class="bg-[#F0EBFF] dark:bg-violet-500/10 rounded-2xl p-5 relative overflow-hidden group">
            <p class="text-[12px] font-medium text-violet-500 dark:text-violet-400 mb-1">Status SPP</p>
            <div class="flex items-end gap-3">
                <h3 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Lunas</h3>
                <span class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-0.5 mb-1.5">
                    ✓
                </span>
            </div>
            <svg class="absolute bottom-2 right-3 h-8 w-16 text-violet-400/30" viewBox="0 0 64 32" fill="none">
                <path d="M2 24 L12 20 L22 18 L32 22 L42 12 L52 8 L62 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none"/>
            </svg>
        </div>

        {{-- Ruang Belajar --}}
        <a href="https://perclms.hbii.my.id/" target="_blank" class="bg-[#F0EBFF] dark:bg-violet-500/10 rounded-2xl p-5 relative overflow-hidden group hover:bg-violet-100 dark:hover:bg-violet-500/20 transition cursor-pointer">
            <p class="text-[12px] font-medium text-violet-500 dark:text-violet-400 mb-1">Ruang Belajar</p>
            <div class="flex items-end gap-3">
                <h3 class="text-xl font-extrabold text-slate-900 dark:text-white tracking-tight">Buka LMS →</h3>
            </div>
            <svg class="absolute bottom-2 right-3 h-8 w-16 text-violet-400/30" viewBox="0 0 64 32" fill="none">
                <path d="M2 26 L12 24 L22 20 L32 24 L42 14 L52 10 L62 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none"/>
            </svg>
        </a>
    </div>

    {{-- ═══════ Main Content Grid ═══════ --}}
    <div class="grid grid-cols-1 xl:grid-cols-5 gap-6">
        {{-- Jadwal Hari Ini (3 col span) --}}
        <div class="xl:col-span-3 bg-white dark:bg-[#0F1524] border border-slate-200/70 dark:border-slate-800/50 rounded-2xl">
            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100 dark:border-slate-800/50">
                <div>
                    <h2 class="text-[15px] font-bold text-slate-900 dark:text-white">Jadwal Hari Ini</h2>
                    <p class="text-[12px] text-slate-400 mt-0.5">{{ now()->translatedFormat('l, d F Y') }}</p>
                </div>
                <a href="{{ route('attendance.index') }}" class="text-[12px] font-semibold text-violet-600 dark:text-violet-400 hover:underline">
                    Lihat Semua →
                </a>
            </div>

            <div class="divide-y divide-slate-100 dark:divide-slate-800/50">
                {{-- Schedule Item 1 --}}
                <div class="flex items-center gap-5 px-6 py-4 hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition">
                    <div class="text-center w-14 shrink-0">
                        <p class="text-[13px] font-bold text-slate-900 dark:text-white">08:00</p>
                        <p class="text-[11px] text-slate-400">10:30</p>
                    </div>
                    <div class="h-10 w-1 rounded-full bg-violet-400"></div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[13px] font-semibold text-slate-800 dark:text-slate-100 truncate">Teknologi Informasi & Komunikasi</p>
                        <p class="text-[12px] text-slate-400 mt-0.5">Ruang Lab Komputer B</p>
                    </div>
                    <span class="text-[11px] font-bold px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 shrink-0">Hadir</span>
                </div>

                {{-- Schedule Item 2 --}}
                <div class="flex items-center gap-5 px-6 py-4 hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition">
                    <div class="text-center w-14 shrink-0">
                        <p class="text-[13px] font-bold text-slate-900 dark:text-white">10:45</p>
                        <p class="text-[11px] text-slate-400">12:15</p>
                    </div>
                    <div class="h-10 w-1 rounded-full bg-blue-400"></div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[13px] font-semibold text-slate-800 dark:text-slate-100 truncate">Matematika</p>
                        <p class="text-[12px] text-slate-400 mt-0.5">Kelas XI-A</p>
                    </div>
                    <span class="text-[11px] font-bold px-3 py-1.5 rounded-lg bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400 shrink-0">Menunggu</span>
                </div>

                {{-- Schedule Item 3 --}}
                <div class="flex items-center gap-5 px-6 py-4 hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition">
                    <div class="text-center w-14 shrink-0">
                        <p class="text-[13px] font-bold text-slate-900 dark:text-white">13:00</p>
                        <p class="text-[11px] text-slate-400">14:30</p>
                    </div>
                    <div class="h-10 w-1 rounded-full bg-cyan-400"></div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[13px] font-semibold text-slate-800 dark:text-slate-100 truncate">Bahasa Inggris</p>
                        <p class="text-[12px] text-slate-400 mt-0.5">Kelas XI-A</p>
                    </div>
                    <span class="text-[11px] font-bold px-3 py-1.5 rounded-lg bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400 shrink-0">Belum</span>
                </div>
            </div>
        </div>

        {{-- Distribusi Kehadiran (2 col span) --}}
        <div class="xl:col-span-2 bg-white dark:bg-[#0F1524] border border-slate-200/70 dark:border-slate-800/50 rounded-2xl">
            <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800/50">
                <h2 class="text-[15px] font-bold text-slate-900 dark:text-white">Distribusi Kehadiran</h2>
                <p class="text-[12px] text-slate-400 mt-0.5">Semester ini</p>
            </div>

            <div class="p-6">
                {{-- Simple bar-style stats --}}
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-[12px] mb-1.5">
                            <span class="font-medium text-slate-600 dark:text-slate-300">Hadir</span>
                            <span class="font-bold text-slate-900 dark:text-white">85%</span>
                        </div>
                        <div class="h-2 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-500 rounded-full" style="width: 85%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-[12px] mb-1.5">
                            <span class="font-medium text-slate-600 dark:text-slate-300">Izin</span>
                            <span class="font-bold text-slate-900 dark:text-white">8%</span>
                        </div>
                        <div class="h-2 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-500 rounded-full" style="width: 8%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-[12px] mb-1.5">
                            <span class="font-medium text-slate-600 dark:text-slate-300">Sakit</span>
                            <span class="font-bold text-slate-900 dark:text-white">5%</span>
                        </div>
                        <div class="h-2 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                            <div class="h-full bg-amber-500 rounded-full" style="width: 5%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-[12px] mb-1.5">
                            <span class="font-medium text-slate-600 dark:text-slate-300">Alpa</span>
                            <span class="font-bold text-slate-900 dark:text-white">2%</span>
                        </div>
                        <div class="h-2 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                            <div class="h-full bg-red-500 rounded-full" style="width: 2%"></div>
                        </div>
                    </div>
                </div>

                {{-- Summary --}}
                <div class="mt-6 pt-5 border-t border-slate-100 dark:border-slate-800/50 grid grid-cols-2 gap-4">
                    <div class="text-center">
                        <p class="text-2xl font-extrabold text-slate-900 dark:text-white">120</p>
                        <p class="text-[11px] text-slate-400 mt-1">Total Hari</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-extrabold text-emerald-600 dark:text-emerald-400">102</p>
                        <p class="text-[11px] text-slate-400 mt-1">Hari Hadir</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layouts.app-percikais>