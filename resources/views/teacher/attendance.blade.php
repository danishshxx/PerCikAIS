<x-layouts.teacher-percikais>
    <x-slot name="title">Absensi Siswa</x-slot>

    <section class="space-y-7">
        <div class="overflow-hidden rounded-[28px] bg-[#111B2E] p-7 shadow-[0_22px_70px_rgba(15,23,42,0.18)] dark:bg-[#101827] md:p-8">
            <h1 class="text-2xl font-extrabold tracking-tight text-white md:text-3xl">
                Absensi Siswa
            </h1>
            <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-300">
                Guru mencatat presensi resmi dan memverifikasi pengajuan sakit/izin siswa.
            </p>
        </div>

        @if (session('success'))
            <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-700 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-2xl border border-red-100 bg-red-50 px-5 py-4 text-sm font-semibold text-red-700 dark:border-red-500/20 dark:bg-red-500/10 dark:text-red-300">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <div class="rounded-[28px] border border-slate-100 bg-white p-6 shadow-[0_14px_45px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524] md:p-8">
                <h2 class="text-xl font-extrabold text-slate-950 dark:text-white">Input Absensi</h2>
                <p class="mt-2 text-sm font-medium text-slate-400">Catat kehadiran siswa.</p>

                <form method="POST" action="{{ route('teacher.attendance.store') }}" class="mt-6 space-y-5">
                    @csrf

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Mata Pelajaran</label>
                        <select name="course_id" required class="h-14 w-full rounded-2xl border border-slate-200 bg-white px-4 text-sm font-semibold dark:border-slate-800 dark:bg-[#121929] dark:text-white">
                            <option value="">Pilih mata pelajaran</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Murid</label>
                        <select name="user_id" required class="h-14 w-full rounded-2xl border border-slate-200 bg-white px-4 text-sm font-semibold dark:border-slate-800 dark:bg-[#121929] dark:text-white">
                            <option value="">Pilih murid</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }} — {{ $student->email }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Tanggal</label>
                        <input type="date" name="attendance_date" value="{{ now()->format('Y-m-d') }}" required class="h-14 w-full rounded-2xl border border-slate-200 bg-white px-4 text-sm font-semibold dark:border-slate-800 dark:bg-[#121929] dark:text-white">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">Status</label>
                        <select name="status" required class="h-14 w-full rounded-2xl border border-slate-200 bg-white px-4 text-sm font-semibold dark:border-slate-800 dark:bg-[#121929] dark:text-white">
                            <option value="">Pilih status</option>
                            <option value="Hadir">Hadir</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Izin">Izin</option>
                            <option value="Alpa">Alpa</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full rounded-2xl bg-blue-600 px-5 py-3.5 text-sm font-extrabold text-white shadow-lg shadow-blue-500/20 transition hover:bg-blue-700">
                        Simpan Absensi
                    </button>
                </form>
            </div>

            <div class="space-y-6 xl:col-span-2">
                <div class="rounded-[28px] border border-slate-100 bg-white p-6 shadow-[0_14px_45px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524] md:p-8">
                    <h2 class="text-xl font-extrabold text-slate-950 dark:text-white">Pengajuan Sakit/Izin</h2>
                    <p class="mt-2 text-sm font-medium text-slate-400">Verifikasi surat berhalangan dari siswa.</p>

                    <div class="mt-6 space-y-4">
                        @forelse ($pendingRequests as $item)
                            <div class="rounded-3xl border border-slate-100 bg-slate-50 p-5 dark:border-slate-800 dark:bg-[#121929]">
                                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                                    <div>
                                        <p class="font-extrabold text-slate-950 dark:text-white">
                                            {{ $item->user->name ?? '-' }}
                                        </p>
                                        <p class="mt-1 text-sm font-medium text-slate-400">
                                            {{ $item->subject_name }} — {{ \Carbon\Carbon::parse($item->attendance_date)->translatedFormat('d M Y') }}
                                        </p>
                                        <p class="mt-2 text-sm font-bold text-amber-600 dark:text-amber-300">
                                            {{ $item->status }}
                                        </p>
                                    </div>

                                    <div class="flex gap-2">
                                        @if ($item->absence_letter_path)
                                            <a href="{{ asset('storage/' . $item->absence_letter_path) }}" target="_blank" class="rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-extrabold text-slate-600 dark:border-slate-800 dark:bg-[#0F1524] dark:text-slate-300">
                                                Lihat Surat
                                            </a>
                                        @endif

                                        <form method="POST" action="{{ route('teacher.attendance.verify', $item->id) }}">
                                            @csrf
                                            <button class="rounded-2xl bg-emerald-600 px-4 py-2.5 text-sm font-extrabold text-white">
                                                Verifikasi
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-3xl border border-dashed border-slate-200 bg-slate-50 p-10 text-center dark:border-slate-800 dark:bg-[#121929]">
                                <p class="text-sm font-bold text-slate-500 dark:text-slate-400">
                                    Tidak ada pengajuan menunggu verifikasi.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-[28px] border border-slate-100 bg-white p-6 shadow-[0_14px_45px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524] md:p-8">
                    <h2 class="text-xl font-extrabold text-slate-950 dark:text-white">Absensi Hari Ini</h2>

                    <div class="mt-6 overflow-hidden rounded-3xl border border-slate-100 dark:border-slate-800">
                        <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-800">
                            <thead class="bg-slate-50 dark:bg-[#121929]">
                                <tr>
                                    <th class="px-5 py-4 text-left text-xs font-extrabold uppercase tracking-widest text-slate-400">Murid</th>
                                    <th class="px-5 py-4 text-left text-xs font-extrabold uppercase tracking-widest text-slate-400">Mapel</th>
                                    <th class="px-5 py-4 text-left text-xs font-extrabold uppercase tracking-widest text-slate-400">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 bg-white dark:divide-slate-800 dark:bg-[#0F1524]">
                                @forelse ($todayAttendances as $item)
                                    <tr>
                                        <td class="px-5 py-4 text-sm font-bold text-slate-700 dark:text-slate-200">{{ $item->user->name ?? '-' }}</td>
                                        <td class="px-5 py-4 text-sm font-semibold text-slate-500 dark:text-slate-400">{{ $item->subject_name }}</td>
                                        <td class="px-5 py-4 text-sm font-extrabold text-blue-600 dark:text-blue-300">{{ $item->status }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-5 py-10 text-center text-sm font-bold text-slate-500 dark:text-slate-400">
                                            Belum ada absensi hari ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.teacher-percikais>