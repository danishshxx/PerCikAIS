<x-layouts.teacher-percikais>
    <x-slot name="title">Enroll Murid</x-slot>

    <section
        x-data="{
            studentSearch: '',
            enrollmentSearch: '',
            courseFilter: '',
            matchesStudent(value) {
                return this.studentSearch.trim() === '' || value.toLowerCase().includes(this.studentSearch.toLowerCase())
            },
            matchesEnrollment(value, courseId) {
                const searchOk = this.enrollmentSearch.trim() === '' || value.toLowerCase().includes(this.enrollmentSearch.toLowerCase())
                const courseOk = this.courseFilter === '' || this.courseFilter === courseId
                return searchOk && courseOk
            }
        }"
        class="space-y-7"
    >
        <div class="overflow-hidden rounded-[28px] bg-[#111B2E] p-7 shadow-[0_22px_70px_rgba(15,23,42,0.18)] dark:bg-[#101827] md:p-8">
            <div class="relative">
                <div class="absolute -right-16 -top-20 h-56 w-56 rounded-full bg-blue-500/20 blur-3xl"></div>

                <div class="relative z-10 flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                    <div>
                        <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-semibold text-blue-100">
                            Student Enrollment
                        </div>

                        <h1 class="text-2xl font-extrabold tracking-tight text-white md:text-3xl">
                            Enroll Murid ke Mata Pelajaran
                        </h1>

                        <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-300">
                            Cari murid, pilih mata pelajaran, lalu enroll ke kelas yang kamu ampu. Data enrollment tersimpan ke LMS.
                        </p>
                    </div>

                    <div class="rounded-3xl border border-white/10 bg-white/5 p-4">
                        <p class="text-xs font-bold uppercase tracking-widest text-slate-400">Total Enrollment</p>
                        <p class="mt-2 text-2xl font-extrabold text-white">
                            {{ $enrollments->count() }}
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
                <p class="mb-2 font-extrabold">Enrollment belum bisa disimpan.</p>
                <div class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        @endif

        @if (($unsyncedStudents ?? 0) > 0)
            <div class="rounded-2xl border border-amber-100 bg-amber-50 px-5 py-4 text-sm font-semibold text-amber-700 dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-300">
                Ada {{ $unsyncedStudents }} murid yang belum tersinkron ke LMS. Jalankan
                <span class="font-extrabold">php artisan lms:sync-users --role=student</span>
                agar semua murid bisa dienroll.
            </div>
        @endif

        @if ($courses->isEmpty())
            <div class="rounded-2xl border border-amber-100 bg-amber-50 px-5 py-4 text-sm font-semibold text-amber-700 dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-300">
                Belum ada mata pelajaran yang terhubung ke akun guru ini. Pastikan <span class="font-extrabold">Course.teacherId</span> sama dengan <span class="font-extrabold">rust_user_id</span> guru.
            </div>
        @endif

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-[1.15fr_0.85fr]">
            <div class="rounded-[28px] border border-slate-100 bg-white p-6 shadow-[0_14px_45px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524] md:p-8">
                <div class="flex flex-col gap-4 border-b border-slate-100 pb-6 dark:border-slate-800 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-xl font-extrabold tracking-tight text-slate-950 dark:text-white">
                            Daftar Murid
                        </h2>
                        <p class="mt-2 text-sm font-medium text-slate-400">
                            Cari murid, lalu pilih mapel untuk enrollment.
                        </p>
                    </div>

                    <div class="rounded-2xl bg-slate-50 px-4 py-3 dark:bg-[#121929]">
                        <p class="text-xs font-extrabold uppercase tracking-widest text-slate-400">Total Murid</p>
                        <p class="mt-1 text-lg font-extrabold text-slate-950 dark:text-white">{{ $students->count() }}</p>
                    </div>
                </div>

                <div class="mt-6">
                    <div class="relative">
                        <svg class="pointer-events-none absolute left-5 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" />
                        </svg>

                        <input
                            type="text"
                            x-model="studentSearch"
                            placeholder="Cari nama, email, atau NIS murid..."
                            class="h-14 w-full rounded-[22px] border border-slate-100 bg-slate-50 pl-14 pr-5 text-sm font-semibold text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-200 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-800 dark:bg-[#121929] dark:text-slate-100"
                        >
                    </div>
                </div>

                <div class="mt-6 max-h-[720px] space-y-4 overflow-y-auto pr-1">
                    @forelse ($students as $student)
                        @php
                            $studentRustId = $student->rust_user_id;
                            $studentSearchValue = strtolower(
                                ($student->name ?? '') . ' ' .
                                ($student->email ?? '') . ' ' .
                                ($student->nis ?? '')
                            );

                            $enrolledCourseIds = $studentRustId
                                ? $enrollments->where('userId', $studentRustId)->pluck('courseId')->values()
                                : collect();

                            $allCoursesAlreadyEnrolled = $courses->count() > 0 && $enrolledCourseIds->count() >= $courses->count();
                        @endphp

                        <div
                            x-show="matchesStudent('{{ e($studentSearchValue) }}')"
                            x-cloak
                            class="rounded-3xl border border-slate-100 bg-slate-50 p-5 transition hover:border-blue-100 hover:bg-white dark:border-slate-800 dark:bg-[#121929] dark:hover:border-blue-500/20 dark:hover:bg-[#0F1524]"
                        >
                            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                                <div class="flex min-w-0 items-center gap-4">
                                    <img
                                        src="{{ $student->profile_photo_url }}"
                                        alt="{{ $student->name }}"
                                        class="h-12 w-12 rounded-2xl object-cover shadow-sm"
                                    >

                                    <div class="min-w-0">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <p class="truncate text-base font-extrabold text-slate-950 dark:text-white">
                                                {{ $student->name }}
                                            </p>

                                            @if ($studentRustId)
                                                <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-extrabold text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-300">
                                                    Sync LMS
                                                </span>
                                            @else
                                                <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-extrabold text-amber-600 dark:bg-amber-500/10 dark:text-amber-300">
                                                    Belum Sync
                                                </span>
                                            @endif

                                            @if ($allCoursesAlreadyEnrolled)
                                                <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-extrabold text-blue-600 dark:bg-blue-500/10 dark:text-blue-300">
                                                    Semua Mapel
                                                </span>
                                            @endif
                                        </div>

                                        <p class="mt-1 truncate text-sm font-medium text-slate-400">
                                            {{ $student->email }}
                                        </p>

                                        <p class="mt-2 text-xs font-bold text-slate-400">
                                            NIS: {{ $student->nis ?? '-' }}
                                        </p>
                                    </div>
                                </div>

                                <form method="POST" action="{{ route('teacher.enrollments.store') }}" class="w-full lg:w-[360px]">
                                    @csrf

                                    <input type="hidden" name="student_id" value="{{ $student->id }}">

                                    <div class="flex flex-col gap-3 sm:flex-row">
                                        <select
                                            name="course_id"
                                            required
                                            @disabled(! $studentRustId || $courses->isEmpty() || $allCoursesAlreadyEnrolled)
                                            class="h-12 min-w-0 flex-1 rounded-2xl border border-slate-200 bg-white px-4 text-sm font-bold text-slate-700 outline-none transition focus:border-blue-300 focus:ring-4 focus:ring-blue-500/10 disabled:cursor-not-allowed disabled:bg-slate-100 disabled:text-slate-400 dark:border-slate-800 dark:bg-[#0F1524] dark:text-white dark:disabled:bg-slate-800"
                                        >
                                            <option value="">Pilih mapel</option>
                                            @foreach ($courses as $course)
                                                @php
                                                    $alreadyEnrolled = $enrolledCourseIds->contains($course->id);
                                                @endphp

                                                <option value="{{ $course->id }}" @disabled($alreadyEnrolled)>
                                                    {{ $course->title }}{{ $alreadyEnrolled ? ' - sudah enrolled' : '' }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <button
                                            type="submit"
                                            @disabled(! $studentRustId || $courses->isEmpty() || $allCoursesAlreadyEnrolled)
                                            class="rounded-2xl bg-blue-600 px-5 py-3 text-sm font-extrabold text-white shadow-lg shadow-blue-500/20 transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50"
                                        >
                                            Enroll
                                        </button>
                                    </div>

                                    @if (! $studentRustId)
                                        <p class="mt-2 text-xs font-semibold text-amber-600 dark:text-amber-300">
                                            Murid ini belum bisa dienroll karena belum sync ke LMS.
                                        </p>
                                    @endif
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-3xl border border-dashed border-slate-200 bg-slate-50 p-10 text-center dark:border-slate-800 dark:bg-[#121929]">
                            <p class="text-sm font-bold text-slate-500 dark:text-slate-400">
                                Belum ada data murid.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="rounded-[28px] border border-slate-100 bg-white p-6 shadow-[0_14px_45px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524] md:p-8">
                <div class="border-b border-slate-100 pb-6 dark:border-slate-800">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <div>
                            <h2 class="text-xl font-extrabold tracking-tight text-slate-950 dark:text-white">
                                Murid Sudah Enrolled
                            </h2>
                            <p class="mt-2 text-sm font-medium text-slate-400">
                                Cek siswa yang sudah masuk ke mapel.
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 px-4 py-3 dark:bg-[#121929]">
                            <p class="text-xs font-extrabold uppercase tracking-widest text-slate-400">Total</p>
                            <p class="mt-1 text-lg font-extrabold text-slate-950 dark:text-white">{{ $enrollments->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 space-y-3">
                    <input
                        type="text"
                        x-model="enrollmentSearch"
                        placeholder="Cari murid atau mapel..."
                        class="h-12 w-full rounded-2xl border border-slate-100 bg-slate-50 px-4 text-sm font-semibold text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-200 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-800 dark:bg-[#121929] dark:text-slate-100"
                    >

                    <select
                        x-model="courseFilter"
                        class="h-12 w-full rounded-2xl border border-slate-100 bg-slate-50 px-4 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-200 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-800 dark:bg-[#121929] dark:text-slate-100"
                    >
                        <option value="">Semua mata pelajaran</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-6 max-h-[720px] space-y-4 overflow-y-auto pr-1">
                    @forelse ($enrollments as $row)
                        @php
                            $enrollmentSearchValue = strtolower(
                                ($row->student_name ?? '') . ' ' .
                                ($row->student_email ?? '') . ' ' .
                                ($row->course_title ?? '')
                            );
                        @endphp

                        <div
                            x-show="matchesEnrollment('{{ e($enrollmentSearchValue) }}', '{{ $row->courseId }}')"
                            x-cloak
                            class="rounded-3xl border border-slate-100 bg-slate-50 p-5 dark:border-slate-800 dark:bg-[#121929]"
                        >
                            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                                <div class="min-w-0">
                                    <p class="truncate text-base font-extrabold text-slate-950 dark:text-white">
                                        {{ $row->student_name }}
                                    </p>

                                    <p class="mt-1 truncate text-sm font-medium text-slate-400">
                                        {{ $row->student_email }}
                                    </p>

                                    <div class="mt-3 inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-extrabold text-blue-600 dark:bg-blue-500/10 dark:text-blue-300">
                                        {{ $row->course_title }}
                                    </div>
                                </div>

                                <form
                                    method="POST"
                                    action="{{ route('teacher.enrollments.delete', [$row->courseId, $row->userId]) }}"
                                    onsubmit="return confirm('Hapus enrollment murid ini?')"
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
                    @empty
                        <div class="rounded-3xl border border-dashed border-slate-200 bg-slate-50 p-10 text-center dark:border-slate-800 dark:bg-[#121929]">
                            <p class="text-sm font-bold text-slate-500 dark:text-slate-400">
                                Belum ada murid yang ter-enroll.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
</x-layouts.teacher-percikais>