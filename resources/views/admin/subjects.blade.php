<x-layouts.admin-percikais>
    <x-slot name="title">Mata Pelajaran</x-slot>

    <section class="space-y-7">
        <div class="overflow-hidden rounded-[28px] bg-[#111B2E] p-7 shadow-[0_22px_70px_rgba(15,23,42,0.18)] dark:bg-[#101827] md:p-8">
            <div class="relative">
                <div class="absolute -right-16 -top-20 h-56 w-56 rounded-full bg-blue-500/20 blur-3xl"></div>
                <div class="absolute bottom-0 right-28 h-24 w-24 rounded-full bg-cyan-400/10 blur-2xl"></div>

                <div class="relative z-10 flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                    <div>
                        <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-semibold text-blue-100">
                            Academic Course Management
                        </div>

                        <h1 class="text-2xl font-extrabold tracking-tight text-white md:text-3xl">
                            Kelola Mata Pelajaran
                        </h1>

                        <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-300">
                            Tambah, ubah, dan hapus mata pelajaran dari data LMS. Data ini terhubung ke tabel Course yang dipakai backend Rust.
                        </p>
                    </div>

                    <div class="rounded-3xl border border-white/10 bg-white/5 p-4">
                        <p class="text-xs font-bold uppercase tracking-widest text-slate-400">
                            Total Mapel
                        </p>
                        <p class="mt-2 text-2xl font-extrabold text-white">
                            {{ $courses->count() }}
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

        @if (! $lmsConnected)
            <div class="rounded-2xl border border-amber-100 bg-amber-50 px-5 py-4 text-sm font-semibold text-amber-700 dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-300">
                Koneksi ke database LMS/Rust belum berhasil. Cek konfigurasi <span class="font-extrabold">mysql_lms</span>. Detail: {{ $lmsError }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-2xl border border-red-100 bg-red-50 px-5 py-4 text-sm font-semibold text-red-700 dark:border-red-500/20 dark:bg-red-500/10 dark:text-red-300">
                <p class="mb-2 font-extrabold">Data belum bisa disimpan.</p>
                <div class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <div class="rounded-[28px] border border-slate-100 bg-white p-6 shadow-[0_14px_45px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524] md:p-8">
                <div class="border-b border-slate-100 pb-6 dark:border-slate-800">
                    <h2 class="text-xl font-extrabold tracking-tight text-slate-950 dark:text-white">
                        Tambah Mapel
                    </h2>
                    <p class="mt-2 text-sm font-medium leading-6 text-slate-400">
                        Buat mata pelajaran baru dan pilih guru pengampu.
                    </p>
                </div>

                <form method="POST" action="{{ route('admin.subjects.store') }}" class="mt-6 space-y-5">
                    @csrf

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">
                            Nama Mata Pelajaran
                        </label>
                        <input
                            type="text"
                            name="title"
                            value="{{ old('title') }}"
                            placeholder="Contoh: Matematika"
                            required
                            class="h-14 w-full rounded-2xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-300 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-800 dark:bg-[#121929] dark:text-white"
                        >
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">
                            Guru Pengampu
                        </label>
                        <select
                            name="teacherId"
                            required
                            class="h-14 w-full rounded-2xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-800 outline-none transition focus:border-blue-300 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-800 dark:bg-[#121929] dark:text-white"
                        >
                            <option value="">Pilih guru</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->rust_user_id }}" @selected(old('teacherId') == $teacher->rust_user_id)>
                                    {{ $teacher->name }} — {{ $teacher->email }}
                                </option>
                            @endforeach
                        </select>

                        @if (($unsyncedTeachers ?? 0) > 0)
                            <p class="mt-2 text-xs font-semibold text-amber-600 dark:text-amber-300">
                                Ada {{ $unsyncedTeachers }} guru yang belum tersinkron ke LMS. Jalankan php artisan lms:sync-users --role=teacher.
                            </p>
                        @endif

                        @if ($teachers->isEmpty())
                            <p class="mt-2 text-xs font-semibold text-amber-600 dark:text-amber-300">
                                Belum ada guru di tabel LMS User. Tambahkan guru dulu di sistem LMS/Rust.
                            </p>
                        @endif
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">
                            Thumbnail URL
                        </label>
                        <input
                            type="url"
                            name="thumbnail"
                            value="{{ old('thumbnail') }}"
                            placeholder="https://..."
                            class="h-14 w-full rounded-2xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-300 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-800 dark:bg-[#121929] dark:text-white"
                        >
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">
                            Deskripsi
                        </label>
                        <textarea
                            name="description"
                            rows="5"
                            placeholder="Deskripsi singkat mata pelajaran"
                            class="w-full resize-none rounded-2xl border border-slate-200 bg-white px-4 py-4 text-sm font-semibold text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-300 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-800 dark:bg-[#121929] dark:text-white"
                        >{{ old('description') }}</textarea>
                    </div>

                    <button
                        type="submit"
                        @disabled($teachers->isEmpty() || ! $lmsConnected)
                        class="w-full rounded-2xl bg-blue-600 px-5 py-3.5 text-sm font-extrabold text-white shadow-lg shadow-blue-500/20 transition hover:-translate-y-0.5 hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        Simpan Mata Pelajaran
                    </button>
                </form>
            </div>

            <div class="rounded-[28px] border border-slate-100 bg-white p-6 shadow-[0_14px_45px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524] md:p-8 xl:col-span-2">
                <div class="mb-6 flex flex-col gap-3 border-b border-slate-100 pb-6 dark:border-slate-800 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-xl font-extrabold tracking-tight text-slate-950 dark:text-white">
                            Daftar Mata Pelajaran
                        </h2>
                        <p class="mt-2 text-sm font-medium leading-6 text-slate-400">
                            Data mapel yang tersimpan di tabel Course.
                        </p>
                    </div>
                </div>

                <div class="space-y-4">
                    @forelse ($courses as $course)
                        <div
                            x-data="{ editOpen: false }"
                            class="rounded-3xl border border-slate-100 bg-slate-50 p-5 dark:border-slate-800 dark:bg-[#121929]"
                        >
                            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <h3 class="text-base font-extrabold text-slate-950 dark:text-white">
                                            {{ $course->title }}
                                        </h3>

                                        <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-extrabold text-blue-600 dark:bg-blue-500/10 dark:text-blue-300">
                                            Course
                                        </span>
                                    </div>

                                    <p class="mt-2 text-sm font-medium leading-6 text-slate-400">
                                        {{ $course->description ?: 'Belum ada deskripsi.' }}
                                    </p>

                                    <div class="mt-4 grid grid-cols-1 gap-3 text-sm md:grid-cols-2">
                                        <div class="rounded-2xl bg-white px-4 py-3 dark:bg-[#0F1524]">
                                            <p class="text-xs font-extrabold uppercase tracking-widest text-slate-400">Guru</p>
                                            <p class="mt-1 truncate font-bold text-slate-700 dark:text-slate-200">
                                                {{ optional($course->teacher)->name ?? 'Guru tidak ditemukan' }}
                                            </p>
                                        </div>

                                        <div class="rounded-2xl bg-white px-4 py-3 dark:bg-[#0F1524]">
                                            <p class="text-xs font-extrabold uppercase tracking-widest text-slate-400">Dibuat</p>
                                            <p class="mt-1 font-bold text-slate-700 dark:text-slate-200">
                                                {{ $course->createdAt ? \Carbon\Carbon::parse($course->createdAt)->translatedFormat('d M Y') : '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex shrink-0 gap-2">
                                    <button
                                        type="button"
                                        x-on:click="editOpen = !editOpen"
                                        class="rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-extrabold text-slate-600 transition hover:bg-slate-100 dark:border-slate-800 dark:bg-[#0F1524] dark:text-slate-300 dark:hover:bg-slate-800"
                                    >
                                        Edit
                                    </button>

                                    <form
                                        method="POST"
                                        action="{{ route('admin.subjects.delete', $course->id) }}"
                                        onsubmit="return confirm('Yakin mau hapus mata pelajaran ini? Data LMS lain yang terhubung bisa terdampak.')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-2xl bg-red-50 px-4 py-2.5 text-sm font-extrabold text-red-600 transition hover:bg-red-100 dark:bg-red-500/10 dark:text-red-300 dark:hover:bg-red-500/20"
                                        >
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <form
                                x-show="editOpen"
                                x-cloak
                                x-transition
                                method="POST"
                                action="{{ route('admin.subjects.update', $course->id) }}"
                                class="mt-5 grid grid-cols-1 gap-4 border-t border-slate-200 pt-5 dark:border-slate-800"
                            >
                                @csrf
                                @method('PATCH')

                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">
                                            Nama Mata Pelajaran
                                        </label>
                                        <input
                                            type="text"
                                            name="title"
                                            value="{{ old('title', $course->title) }}"
                                            required
                                            class="h-14 w-full rounded-2xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-800 outline-none transition focus:border-blue-300 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-800 dark:bg-[#0F1524] dark:text-white"
                                        >
                                    </div>

                                    <div>
                                        <label class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">
                                            Guru Pengampu
                                        </label>
                                        <select
                                            name="teacherId"
                                            required
                                            class="h-14 w-full rounded-2xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-800 outline-none transition focus:border-blue-300 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-800 dark:bg-[#0F1524] dark:text-white"
                                        >
                                            @foreach ($teachers as $teacher)
                                                <option value="{{ $teacher->id }}" @selected($course->teacherId == $teacher->id)>
                                                    {{ $teacher->name }} — {{ $teacher->email }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">
                                        Thumbnail URL
                                    </label>
                                    <input
                                        type="url"
                                        name="thumbnail"
                                        value="{{ old('thumbnail', $course->thumbnail) }}"
                                        placeholder="https://..."
                                        class="h-14 w-full rounded-2xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-300 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-800 dark:bg-[#0F1524] dark:text-white"
                                    >
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">
                                        Deskripsi
                                    </label>
                                    <textarea
                                        name="description"
                                        rows="4"
                                        class="w-full resize-none rounded-2xl border border-slate-200 bg-white px-4 py-4 text-sm font-semibold text-slate-800 outline-none transition focus:border-blue-300 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-800 dark:bg-[#0F1524] dark:text-white"
                                    >{{ old('description', $course->description) }}</textarea>
                                </div>

                                <div class="flex justify-end gap-2">
                                    <button
                                        type="button"
                                        x-on:click="editOpen = false"
                                        class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-extrabold text-slate-600 transition hover:bg-slate-100 dark:border-slate-800 dark:bg-[#0F1524] dark:text-slate-300 dark:hover:bg-slate-800"
                                    >
                                        Batal
                                    </button>

                                    <button
                                        type="submit"
                                        class="rounded-2xl bg-blue-600 px-5 py-3 text-sm font-extrabold text-white shadow-lg shadow-blue-500/20 transition hover:-translate-y-0.5 hover:bg-blue-700"
                                    >
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    @empty
                        <div class="rounded-3xl border border-dashed border-slate-200 bg-slate-50 p-10 text-center dark:border-slate-800 dark:bg-[#121929]">
                            <p class="text-sm font-bold text-slate-500 dark:text-slate-400">
                                Belum ada mata pelajaran.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
</x-layouts.admin-percikais>