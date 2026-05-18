<x-layouts.app-percikais>
    <x-slot name="title">Jadwal Belajar & Perizinan</x-slot>

    <section class="space-y-7">
        <div class="overflow-hidden rounded-[28px] bg-[#111B2E] p-7 shadow-[0_22px_70px_rgba(15,23,42,0.18)] dark:bg-[#101827] md:p-8">
            <div class="relative">
                <div class="absolute -right-16 -top-20 h-56 w-56 rounded-full bg-blue-500/20 blur-3xl"></div>
                <div class="absolute bottom-0 right-28 h-24 w-24 rounded-full bg-cyan-400/10 blur-2xl"></div>

                <div class="relative z-10 flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                    <div>
                        <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-semibold text-blue-100">
                            Student Attendance
                        </div>

                        <h1 class="text-2xl font-extrabold tracking-tight text-white md:text-3xl">
                            Jadwal Belajar & Perizinan
                        </h1>

                        <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-300">
                            Siswa tidak dapat melakukan presensi hadir secara mandiri. Jika berhalangan hadir, kirim pengajuan Sakit atau Izin dengan surat pendukung.
                        </p>
                    </div>

                    <div class="rounded-3xl border border-white/10 bg-white/5 p-4">
                        <p class="text-xs font-bold uppercase tracking-widest text-slate-400">
                            Presensi Resmi
                        </p>
                        <p class="mt-2 text-sm font-extrabold text-white">
                            Dilakukan oleh Guru
                        </p>
                    </div>
                </div>
            </div>
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

        @if ($errors->any())
            <div class="rounded-2xl border border-red-100 bg-red-50 px-5 py-4 text-sm font-semibold text-red-700 dark:border-red-500/20 dark:bg-red-500/10 dark:text-red-300">
                <p class="mb-2 font-extrabold">Pengajuan belum bisa dikirim.</p>
                <div class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-[24px] border border-slate-100 bg-white p-6 shadow-[0_14px_45px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524]">
                <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">Total Pertemuan</p>
                <h3 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-950 dark:text-white">
                    {{ $totalPertemuan }}
                </h3>
                <p class="mt-3 text-sm font-medium text-slate-400">Data sudah diverifikasi</p>
            </div>

            <div class="rounded-[24px] border border-slate-100 bg-white p-6 shadow-[0_14px_45px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524]">
                <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">Kehadiran</p>
                <h3 class="mt-2 text-3xl font-extrabold tracking-tight text-emerald-600 dark:text-emerald-300">
                    {{ $persentase }}%
                </h3>
                <p class="mt-3 text-sm font-medium text-slate-400">{{ $totalHadir }} kali hadir</p>
            </div>

            <div class="rounded-[24px] border border-slate-100 bg-white p-6 shadow-[0_14px_45px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524]">
                <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">Sakit / Izin</p>
                <h3 class="mt-2 text-3xl font-extrabold tracking-tight text-amber-600 dark:text-amber-300">
                    {{ $totalSakitIzin }}
                </h3>
                <p class="mt-3 text-sm font-medium text-slate-400">Sudah diverifikasi</p>
            </div>

            <div class="rounded-[24px] border border-slate-100 bg-white p-6 shadow-[0_14px_45px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524]">
                <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">Menunggu Verifikasi</p>
                <h3 class="mt-2 text-3xl font-extrabold tracking-tight text-blue-600 dark:text-blue-300">
                    {{ $pendingRequests }}
                </h3>
                <p class="mt-3 text-sm font-medium text-slate-400">Pengajuan berhalangan</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <div class="rounded-[28px] border border-slate-100 bg-white p-6 shadow-[0_14px_45px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524] md:p-8 xl:col-span-1">
                <div class="border-b border-slate-100 pb-6 dark:border-slate-800">
                    <h2 class="text-xl font-extrabold tracking-tight text-slate-950 dark:text-white">
                        Ajukan Berhalangan
                    </h2>
                    <p class="mt-2 text-sm font-medium leading-6 text-slate-400">
                        Pilih Sakit atau Izin dan upload surat pendukung. Pengajuan akan diperiksa oleh guru.
                    </p>
                </div>

                <form method="POST" action="{{ route('attendance.store') }}" enctype="multipart/form-data" class="mt-6 space-y-5">
                    @csrf

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">
                            Mata Pelajaran
                        </label>

                        @if ($lmsCourses->count() > 0)
                            <select
                                name="course_id"
                                required
                                class="h-14 w-full rounded-2xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-800 outline-none transition focus:border-blue-300 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-800 dark:bg-[#121929] dark:text-white"
                            >
                                <option value="">Pilih mata pelajaran</option>
                                @foreach ($lmsCourses as $course)
                                    <option value="{{ $course->id }}" @selected(old('course_id') == $course->id)>
                                        {{ $course->title ?? $course->name ?? 'Mata Pelajaran' }}
                                    </option>
                                @endforeach
                            </select>
                        @else
                            <input
                                type="text"
                                name="subject_name"
                                value="{{ old('subject_name') }}"
                                required
                                placeholder="Contoh: Matematika"
                                class="h-14 w-full rounded-2xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-300 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-800 dark:bg-[#121929] dark:text-white"
                            >
                        @endif
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">
                            Tanggal Berhalangan
                        </label>

                        <input
                            type="date"
                            name="attendance_date"
                            value="{{ old('attendance_date', now()->format('Y-m-d')) }}"
                            max="{{ now()->format('Y-m-d') }}"
                            required
                            class="h-14 w-full rounded-2xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-800 outline-none transition focus:border-blue-300 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-800 dark:bg-[#121929] dark:text-white"
                        >
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">
                            Jenis Berhalangan
                        </label>

                        <select
                            name="status"
                            required
                            class="h-14 w-full rounded-2xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-800 outline-none transition focus:border-blue-300 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-800 dark:bg-[#121929] dark:text-white"
                        >
                            <option value="">Pilih status</option>
                            <option value="Sakit" @selected(old('status') === 'Sakit')>Sakit</option>
                            <option value="Izin" @selected(old('status') === 'Izin')>Izin</option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">
                            Surat / Bukti Pendukung
                        </label>

                        <input
                            type="file"
                            name="absence_letter"
                            accept=".pdf,.jpg,.jpeg,.png,.webp"
                            required
                            class="block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 file:mr-4 file:rounded-xl file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-bold file:text-blue-600 hover:file:bg-blue-100 dark:border-slate-800 dark:bg-[#121929] dark:text-slate-200 dark:file:bg-blue-500/10 dark:file:text-blue-300"
                        >

                        <p class="mt-2 text-xs font-semibold text-slate-400">
                            Format PDF, JPG, PNG, atau WEBP. Maksimal 2MB.
                        </p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">
                            Keterangan Tambahan
                        </label>

                        <textarea
                            name="absence_reason"
                            rows="4"
                            placeholder="Tulis keterangan singkat jika diperlukan"
                            class="w-full resize-none rounded-2xl border border-slate-200 bg-white px-4 py-4 text-sm font-semibold text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-300 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-800 dark:bg-[#121929] dark:text-white"
                        >{{ old('absence_reason') }}</textarea>
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-2xl bg-blue-600 px-5 py-3.5 text-sm font-extrabold text-white shadow-lg shadow-blue-500/20 transition hover:-translate-y-0.5 hover:bg-blue-700"
                    >
                        Kirim Pengajuan
                    </button>
                </form>
            </div>

            <div class="rounded-[28px] border border-slate-100 bg-white p-6 shadow-[0_14px_45px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524] md:p-8 xl:col-span-2">
                <div class="mb-6 flex flex-col gap-3 border-b border-slate-100 pb-6 dark:border-slate-800 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-xl font-extrabold tracking-tight text-slate-950 dark:text-white">
                            Riwayat Presensi & Pengajuan
                        </h2>
                        <p class="mt-2 text-sm font-medium leading-6 text-slate-400">
                            Data hadir resmi dicatat oleh guru. Pengajuan Sakit/Izin akan tampil sebagai menunggu verifikasi.
                        </p>
                    </div>
                </div>

                <div class="overflow-hidden rounded-3xl border border-slate-100 dark:border-slate-800">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-800">
                            <thead class="bg-slate-50 dark:bg-[#121929]">
                                <tr>
                                    <th class="px-5 py-4 text-left text-xs font-extrabold uppercase tracking-widest text-slate-400">Tanggal</th>
                                    <th class="px-5 py-4 text-left text-xs font-extrabold uppercase tracking-widest text-slate-400">Mapel</th>
                                    <th class="px-5 py-4 text-left text-xs font-extrabold uppercase tracking-widest text-slate-400">Status</th>
                                    <th class="px-5 py-4 text-left text-xs font-extrabold uppercase tracking-widest text-slate-400">Verifikasi</th>
                                    <th class="px-5 py-4 text-left text-xs font-extrabold uppercase tracking-widest text-slate-400">Surat</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100 bg-white dark:divide-slate-800 dark:bg-[#0F1524]">
                                @forelse ($history as $item)
                                    <tr>
                                        <td class="whitespace-nowrap px-5 py-4 text-sm font-bold text-slate-700 dark:text-slate-200">
                                            {{ \Carbon\Carbon::parse($item->attendance_date)->translatedFormat('d M Y') }}
                                        </td>

                                        <td class="px-5 py-4 text-sm font-semibold text-slate-500 dark:text-slate-400">
                                            {{ $item->subject_name }}
                                        </td>

                                        <td class="whitespace-nowrap px-5 py-4">
                                            @php
                                                $statusClass = match ($item->status) {
                                                    'Hadir' => 'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-300',
                                                    'Sakit' => 'bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-300',
                                                    'Izin' => 'bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-300',
                                                    'Alpa' => 'bg-red-50 text-red-600 dark:bg-red-500/10 dark:text-red-300',
                                                    default => 'bg-slate-50 text-slate-600 dark:bg-slate-800 dark:text-slate-300',
                                                };
                                            @endphp

                                            <span class="{{ $statusClass }} inline-flex rounded-full px-3 py-1 text-xs font-extrabold">
                                                {{ $item->status }}
                                            </span>
                                        </td>

                                        <td class="whitespace-nowrap px-5 py-4">
                                            @if ($item->is_verified)
                                                <span class="inline-flex rounded-full bg-emerald-50 px-3 py-1 text-xs font-extrabold text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-300">
                                                    Diverifikasi
                                                </span>
                                            @else
                                                <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-extrabold text-slate-500 dark:bg-slate-800 dark:text-slate-300">
                                                    Menunggu Guru
                                                </span>
                                            @endif
                                        </td>

                                        <td class="whitespace-nowrap px-5 py-4">
                                            @if (! empty($item->absence_letter_path))
                                                <a
                                                    href="{{ asset('storage/' . $item->absence_letter_path) }}"
                                                    target="_blank"
                                                    class="text-sm font-extrabold text-blue-600 hover:underline dark:text-blue-300"
                                                >
                                                    Lihat Surat
                                                </a>
                                            @else
                                                <span class="text-sm font-semibold text-slate-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-10 text-center">
                                            <p class="text-sm font-bold text-slate-500 dark:text-slate-400">
                                                Belum ada data presensi atau pengajuan berhalangan.
                                            </p>
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
</x-layouts.app-percikais>