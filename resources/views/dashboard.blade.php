<x-layouts.app-percikais>
    <x-slot name="title">Beranda Siswa</x-slot>

    <section class="mb-7 overflow-hidden rounded-[28px] bg-[#111B2E] p-7 shadow-[0_22px_70px_rgba(15,23,42,0.18)] dark:bg-[#101827] md:p-8">
        <div class="relative">
            <div class="absolute -right-16 -top-20 h-56 w-56 rounded-full bg-blue-500/20 blur-3xl"></div>
            <div class="absolute bottom-0 right-28 h-24 w-24 rounded-full bg-cyan-400/10 blur-2xl"></div>

            <div class="relative z-10 flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                <div>
                    <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-semibold text-blue-100">
                        Portal Informasi Akademik
                    </div>

                    <h1 class="text-2xl font-extrabold tracking-tight text-white md:text-3xl">
                        Halo, {{ auth()->user()->name }}!
                    </h1>

                    <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-300">
                        Selamat datang di PerCikAIS. Pantau jadwal belajar, presensi, dan administrasi sekolah dari satu tempat.
                    </p>
                </div>

                <a
                    href="https://perclms.hbii.my.id/"
                    target="_blank"
                    class="inline-flex items-center justify-center gap-3 rounded-2xl bg-white px-5 py-3.5 text-sm font-bold text-blue-600 shadow-xl shadow-black/10 transition hover:-translate-y-0.5 hover:shadow-2xl dark:bg-[#0F1524] dark:text-blue-300"
                >
                    Buka Ruang Belajar LMS
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <section class="mb-7 grid grid-cols-1 gap-5 md:grid-cols-3">
        <div class="rounded-[24px] border border-slate-100 bg-white p-6 shadow-[0_14px_45px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524]">
            <div class="mb-8 flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-500 dark:bg-blue-500/10 dark:text-blue-300">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M8 7V4m8 3V4M5 10h14M6.5 6h11A2.5 2.5 0 0 1 20 8.5v9A2.5 2.5 0 0 1 17.5 20h-11A2.5 2.5 0 0 1 4 17.5v-9A2.5 2.5 0 0 1 6.5 6Z" />
                </svg>
            </div>

            <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">Presensi Semester</p>
            <h3 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-950 dark:text-white">95%</h3>
            <p class="mt-3 text-sm font-medium text-slate-400">Status kehadiran baik</p>
        </div>

        <div class="rounded-[24px] border border-slate-100 bg-white p-6 shadow-[0_14px_45px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524]">
            <div class="mb-8 flex h-12 w-12 items-center justify-center rounded-2xl bg-violet-50 text-violet-500 dark:bg-violet-500/10 dark:text-violet-300">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M5 5.5A2.5 2.5 0 0 1 7.5 3H19v15.5A2.5 2.5 0 0 1 16.5 21H7.5A2.5 2.5 0 0 1 5 18.5v-13Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M8 7h8M8 11h8M8 15h5" />
                </svg>
            </div>

            <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">Mata Pelajaran</p>
            <h3 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-950 dark:text-white">12</h3>
            <p class="mt-3 text-sm font-medium text-slate-400">Aktif semester ini</p>
        </div>

        <div class="rounded-[24px] border border-slate-100 bg-white p-6 shadow-[0_14px_45px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524]">
            <div class="mb-8 flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-500 dark:bg-emerald-500/10 dark:text-emerald-300">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M3.75 7.75A2.75 2.75 0 0 1 6.5 5h11A2.75 2.75 0 0 1 20.25 7.75v8.5A2.75 2.75 0 0 1 17.5 19h-11a2.75 2.75 0 0 1-2.75-2.75v-8.5Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M4 10h16M8 15h1.5M12 15h2.5" />
                </svg>
            </div>

            <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">Status Administrasi</p>
            <h3 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-950 dark:text-white">Lengkap</h3>
            <p class="mt-3 text-sm font-medium text-slate-400">SPP dan tagihan terbaru</p>
        </div>
    </section>

    <section class="rounded-[28px] border border-slate-100 bg-white p-6 shadow-[0_14px_45px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524] md:p-8">
        <div class="flex flex-col gap-3 border-b border-slate-100 pb-6 dark:border-slate-800 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-xl font-extrabold tracking-tight text-slate-950 dark:text-white">
                    Jadwal Mapel Hari Ini
                </h2>
                <p class="mt-1 text-sm font-medium text-slate-400">
                    {{ now()->translatedFormat('l, d F Y') }}
                </p>
            </div>

            <a
                href="{{ route('attendance.index') }}"
                class="inline-flex items-center justify-center rounded-2xl bg-blue-50 px-4 py-2.5 text-sm font-bold text-blue-600 transition hover:bg-blue-100 dark:bg-blue-500/10 dark:text-blue-300 dark:hover:bg-blue-500/20"
            >
                Lihat Semua Jadwal
            </a>
        </div>

        <div class="mt-6 rounded-[24px] border border-slate-100 bg-slate-50 p-5 dark:border-slate-800 dark:bg-[#121929]">
            <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
                <div class="flex gap-4">
                    <div class="min-w-[64px] rounded-2xl bg-white px-3 py-3 text-center shadow-sm dark:bg-[#0F1524]">
                        <p class="text-sm font-extrabold text-slate-950 dark:text-white">08:00</p>
                        <p class="mt-1 text-xs font-semibold text-slate-400">10:30</p>
                    </div>

                    <div>
                        <p class="text-base font-extrabold text-slate-950 dark:text-white">
                            Teknologi Informasi & Komunikasi
                        </p>

                        <p class="mt-2 flex items-center gap-2 text-sm font-medium text-slate-400">
                            <svg class="h-4 w-4 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M12 21s7-4.7 7-11a7 7 0 1 0-14 0c0 6.3 7 11 7 11Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M12 12.5A2.5 2.5 0 1 0 12 7a2.5 2.5 0 0 0 0 5.5Z" />
                            </svg>
                            Ruang Lab Komputer B
                        </p>
                    </div>
                </div>

                <div class="md:text-right">
                    <span class="inline-flex rounded-2xl bg-emerald-50 px-4 py-2 text-sm font-extrabold text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-300">
                        Hadir
                    </span>

                    <p class="mt-2 text-xs font-semibold text-slate-400">
                        Diverifikasi oleh guru
                    </p>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app-percikais>