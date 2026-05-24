<x-layouts.teacher-percikais>
    <x-slot name="title">Dashboard Guru</x-slot>

    <section class="space-y-7">
        <div class="overflow-hidden rounded-[28px] bg-[#111B2E] p-7 shadow-[0_22px_70px_rgba(15,23,42,0.18)] dark:bg-[#101827] md:p-8">
            <div class="relative">
                <div class="absolute -right-16 -top-20 h-56 w-56 rounded-full bg-blue-500/20 blur-3xl"></div>

                <div class="relative z-10 flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                    <div>
                        <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-semibold text-blue-100">
                            Teacher Console
                        </div>

                        <h1 class="text-2xl font-extrabold tracking-tight text-white md:text-3xl">
                            Dashboard Guru PerCikAIS
                        </h1>

                        <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-300">
                            Kelola absensi, verifikasi izin/sakit siswa, dan enroll murid ke mata pelajaran yang kamu ampu.
                        </p>
                    </div>

                    <div class="rounded-3xl border border-white/10 bg-white/5 p-4">
                        <p class="text-xs font-bold uppercase tracking-widest text-slate-400">Hari ini</p>
                        <p class="mt-2 text-sm font-extrabold text-white">
                            {{ now()->translatedFormat('l, d F Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-[24px] border border-slate-100 bg-white p-6 shadow-[0_14px_45px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524]">
                <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">Mata Pelajaran</p>
                <h3 class="mt-2 text-3xl font-extrabold text-slate-950 dark:text-white">{{ $totalCourses ?? 0 }}</h3>
                <p class="mt-3 text-sm font-medium text-slate-400">Mapel yang diampu</p>
            </div>

            <div class="rounded-[24px] border border-slate-100 bg-white p-6 shadow-[0_14px_45px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524]">
                <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">Murid Ter-enroll</p>
                <h3 class="mt-2 text-3xl font-extrabold text-blue-600 dark:text-blue-300">{{ $totalEnrolledStudents ?? 0 }}</h3>
                <p class="mt-3 text-sm font-medium text-slate-400">Siswa dalam mapel</p>
            </div>

            <div class="rounded-[24px] border border-slate-100 bg-white p-6 shadow-[0_14px_45px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524]">
                <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">Absensi Hari Ini</p>
                <h3 class="mt-2 text-3xl font-extrabold text-emerald-600 dark:text-emerald-300">{{ $totalTodayAttendances ?? 0 }}</h3>
                <p class="mt-3 text-sm font-medium text-slate-400">Data tercatat</p>
            </div>

            <div class="rounded-[24px] border border-slate-100 bg-white p-6 shadow-[0_14px_45px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524]">
                <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">Menunggu Verifikasi</p>
                <h3 class="mt-2 text-3xl font-extrabold text-amber-600 dark:text-amber-300">{{ $totalPendingRequests ?? 0 }}</h3>
                <p class="mt-3 text-sm font-medium text-slate-400">Sakit / izin siswa</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <div class="rounded-[28px] border border-slate-100 bg-white p-6 shadow-[0_14px_45px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524] md:p-8 xl:col-span-2">
                <h2 class="text-xl font-extrabold text-slate-950 dark:text-white">Akses Cepat Guru</h2>
                <p class="mt-2 text-sm font-medium text-slate-400">Pilih fitur utama untuk mengelola kelas.</p>

                <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                    <a href="{{ route('teacher.attendance') }}" class="rounded-3xl border border-slate-100 bg-slate-50 p-5 transition hover:-translate-y-0.5 hover:bg-blue-50 dark:border-slate-800 dark:bg-[#121929] dark:hover:bg-blue-500/10">
                        <p class="text-base font-extrabold text-slate-950 dark:text-white">Absensi Siswa</p>
                        <p class="mt-2 text-sm font-medium text-slate-400">Catat hadir, sakit, izin, dan alpa.</p>
                    </a>

                    <a href="{{ route('teacher.enrollments') }}" class="rounded-3xl border border-slate-100 bg-slate-50 p-5 transition hover:-translate-y-0.5 hover:bg-emerald-50 dark:border-slate-800 dark:bg-[#121929] dark:hover:bg-emerald-500/10">
                        <p class="text-base font-extrabold text-slate-950 dark:text-white">Enroll Murid</p>
                        <p class="mt-2 text-sm font-medium text-slate-400">Daftarkan murid ke mata pelajaran.</p>
                    </a>
                </div>
            </div>

            <div class="rounded-[28px] border border-slate-100 bg-white p-6 text-center shadow-[0_14px_45px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524] md:p-8">
                <img src="{{ auth()->user()->profile_photo_url }}" class="mx-auto h-24 w-24 rounded-[28px] object-cover shadow-xl shadow-blue-500/10">
                <h2 class="mt-5 text-xl font-extrabold text-slate-950 dark:text-white">Selamat Mengajar!</h2>
                <p class="mt-3 text-sm font-medium leading-6 text-slate-400">
                    Gunakan panel ini untuk memastikan data kelas dan absensi tetap rapi.
                </p>
            </div>
        </div>
    </section>
</x-layouts.teacher-percikais>