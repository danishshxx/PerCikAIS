<x-layouts.admin-percikais>
    <x-slot name="title">Dashboard Admin</x-slot>

    @php
        $totalSiswaValue = $totalSiswa ?? 0;
        $totalPendapatanValue = $totalPendapatan ?? 0;
        $totalTunggakanValue = $totalTunggakan ?? 0;
        $totalGuruValue = $totalGuru ?? 0;
    @endphp

    <section class="mb-7 overflow-hidden rounded-[28px] bg-[#111B2E] p-7 shadow-[0_22px_70px_rgba(15,23,42,0.18)] dark:bg-[#101827] md:p-8">
        <div class="relative">
            <div class="absolute -right-16 -top-20 h-56 w-56 rounded-full bg-blue-500/20 blur-3xl"></div>
            <div class="absolute bottom-0 right-28 h-24 w-24 rounded-full bg-cyan-400/10 blur-2xl"></div>

            <div class="relative z-10 flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                <div>
                    <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-semibold text-blue-100">
                        Konsol Administrator
                    </div>

                    <h1 class="text-2xl font-extrabold tracking-tight text-white md:text-3xl">
                        Panel Administrator PerCikAIS
                    </h1>

                    <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-300">
                        Pusat kendali untuk mengelola data murid, guru, absensi, dan administrasi keuangan sekolah.
                    </p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 p-4">
                    <p class="text-xs font-bold uppercase tracking-widest text-slate-400">
                        Hari ini
                    </p>
                    <p class="mt-2 text-sm font-extrabold text-white">
                        {{ now()->translatedFormat('l, d F Y') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-7 grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-[24px] border border-slate-100 bg-white p-6 shadow-[0_14px_45px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524]">
            <div class="mb-8 flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-500 dark:bg-blue-500/10 dark:text-blue-300">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M16 20v-1.5A4.5 4.5 0 0 0 11.5 14h-4A4.5 4.5 0 0 0 3 18.5V20M9.5 10.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z" />
                </svg>
            </div>

            <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">Total Siswa Aktif</p>
            <h3 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-950 dark:text-white">
                {{ number_format($totalSiswaValue, 0, ',', '.') }}
            </h3>
            <p class="mt-3 text-sm font-medium text-slate-400">Murid terdaftar</p>
        </div>

        <div class="rounded-[24px] border border-slate-100 bg-white p-6 shadow-[0_14px_45px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524]">
            <div class="mb-8 flex h-12 w-12 items-center justify-center rounded-2xl bg-violet-50 text-violet-500 dark:bg-violet-500/10 dark:text-violet-300">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M12 14a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M4 20a8 8 0 0 1 16 0" />
                </svg>
            </div>

            <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">Total Guru</p>
            <h3 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-950 dark:text-white">
                {{ number_format($totalGuruValue, 0, ',', '.') }}
            </h3>
            <p class="mt-3 text-sm font-medium text-slate-400">Tenaga pengajar</p>
        </div>

        <div class="rounded-[24px] border border-slate-100 bg-white p-6 shadow-[0_14px_45px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524]">
            <div class="mb-8 flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-500 dark:bg-emerald-500/10 dark:text-emerald-300">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M15 9.5A2.6 2.6 0 0 0 12.5 8h-1A2.1 2.1 0 0 0 9.4 10.1c0 1 .72 1.75 1.76 2l1.86.38A2.1 2.1 0 0 1 14.6 14.5 2.5 2.5 0 0 1 12 17h-.8A3 3 0 0 1 8.5 15.5M12 6.5V8M12 17v1.5" />
                </svg>
            </div>

            <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">Pemasukan SPP</p>
            <h3 class="mt-2 text-2xl font-extrabold tracking-tight text-emerald-600 dark:text-emerald-300">
                Rp {{ number_format($totalPendapatanValue, 0, ',', '.') }}
            </h3>
            <p class="mt-3 text-sm font-medium text-slate-400">Pembayaran lunas</p>
        </div>

        <div class="rounded-[24px] border border-slate-100 bg-white p-6 shadow-[0_14px_45px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524]">
            <div class="mb-8 flex h-12 w-12 items-center justify-center rounded-2xl bg-red-50 text-red-500 dark:bg-red-500/10 dark:text-red-300">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M12 9v4M12 17h.01" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M10.3 4.2 2.8 17.5A2 2 0 0 0 4.5 20.5h15a2 2 0 0 0 1.7-3L13.7 4.2a2 2 0 0 0-3.4 0Z" />
                </svg>
            </div>

            <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">Tunggakan</p>
            <h3 class="mt-2 text-2xl font-extrabold tracking-tight text-red-600 dark:text-red-300">
                Rp {{ number_format($totalTunggakanValue, 0, ',', '.') }}
            </h3>
            <p class="mt-3 text-sm font-medium text-slate-400">Administrasi belum lunas</p>
        </div>
    </section>

    <section class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div class="rounded-[28px] border border-slate-100 bg-white p-6 shadow-[0_14px_45px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524] md:p-8 xl:col-span-2">
            <div class="flex flex-col gap-3 border-b border-slate-100 pb-6 dark:border-slate-800 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-xl font-extrabold tracking-tight text-slate-950 dark:text-white">
                        Akses Cepat Admin
                    </h2>
                    <p class="mt-1 text-sm font-medium text-slate-400">
                        Pilih fitur utama untuk mengelola operasional sekolah.
                    </p>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                <a href="{{ route('admin.students') }}" class="group rounded-3xl border border-slate-100 bg-slate-50 p-5 transition hover:-translate-y-0.5 hover:bg-blue-50 dark:border-slate-800 dark:bg-[#121929] dark:hover:bg-blue-500/10">
                    <p class="text-base font-extrabold text-slate-950 group-hover:text-blue-600 dark:text-white dark:group-hover:text-blue-300">
                        Kelola Data Murid
                    </p>
                    <p class="mt-2 text-sm font-medium leading-6 text-slate-400">
                        Tambah dan pantau data siswa aktif.
                    </p>
                </a>

                <a href="{{ route('admin.teachers') }}" class="group rounded-3xl border border-slate-100 bg-slate-50 p-5 transition hover:-translate-y-0.5 hover:bg-violet-50 dark:border-slate-800 dark:bg-[#121929] dark:hover:bg-violet-500/10">
                    <p class="text-base font-extrabold text-slate-950 group-hover:text-violet-600 dark:text-white dark:group-hover:text-violet-300">
                        Kelola Data Guru
                    </p>
                    <p class="mt-2 text-sm font-medium leading-6 text-slate-400">
                        Atur data guru dan akses pengajar.
                    </p>
                </a>

                <a href="{{ route('admin.attendance') }}" class="group rounded-3xl border border-slate-100 bg-slate-50 p-5 transition hover:-translate-y-0.5 hover:bg-cyan-50 dark:border-slate-800 dark:bg-[#121929] dark:hover:bg-cyan-500/10">
                    <p class="text-base font-extrabold text-slate-950 group-hover:text-cyan-600 dark:text-white dark:group-hover:text-cyan-300">
                        Absensi & Mapel
                    </p>
                    <p class="mt-2 text-sm font-medium leading-6 text-slate-400">
                        Pantau kehadiran dan jadwal pelajaran.
                    </p>
                </a>

                <a href="{{ route('admin.finance') }}" class="group rounded-3xl border border-slate-100 bg-slate-50 p-5 transition hover:-translate-y-0.5 hover:bg-emerald-50 dark:border-slate-800 dark:bg-[#121929] dark:hover:bg-emerald-500/10">
                    <p class="text-base font-extrabold text-slate-950 group-hover:text-emerald-600 dark:text-white dark:group-hover:text-emerald-300">
                        Kelola Keuangan
                    </p>
                    <p class="mt-2 text-sm font-medium leading-6 text-slate-400">
                        Buat tagihan dan pantau pembayaran SPP.
                    </p>
                </a>
            </div>
        </div>

        <aside class="rounded-[28px] border border-slate-100 bg-white p-6 shadow-[0_14px_45px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524] md:p-8">
            <div class="flex flex-col items-center text-center">
                <img
                    src="{{ auth()->user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name=Admin&background=2563eb&color=fff&bold=true' }}"
                    alt="Admin"
                    class="h-24 w-24 rounded-[28px] object-cover shadow-xl shadow-blue-500/10"
                >

                <h2 class="mt-5 text-xl font-extrabold text-slate-950 dark:text-white">
                    Selamat Bertugas!
                </h2>

                <p class="mt-3 text-sm font-medium leading-6 text-slate-400">
                    Gunakan panel ini untuk memastikan data akademik, absensi, dan administrasi sekolah tetap terkelola dengan baik.
                </p>

                <div class="mt-6 w-full rounded-3xl bg-slate-50 p-4 text-left dark:bg-[#121929]">
                    <p class="text-xs font-extrabold uppercase tracking-widest text-slate-400">
                        Role
                    </p>
                    <p class="mt-2 text-sm font-extrabold text-slate-800 dark:text-white">
                        {{ method_exists(auth()->user(), 'isSuperAdmin') && auth()->user()->isSuperAdmin() ? 'Super Administrator' : 'Administrator' }}
                    </p>
                </div>
            </div>
        </aside>
    </section>
</x-layouts.admin-percikais>