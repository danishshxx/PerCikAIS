@php
    $user = auth()->user();

    $profileLayout = 'layouts.app-percikais';

    if (method_exists($user, 'isAdmin') && $user->isAdmin()) {
        $profileLayout = 'layouts.admin-percikais';
    } elseif (method_exists($user, 'isTeacher') && $user->isTeacher()) {
        $profileLayout = 'layouts.teacher-percikais';
    }
@endphp

<x-dynamic-component :component="$profileLayout">
    <x-slot name="title">Profil Saya</x-slot>

    <section class="mb-7 overflow-hidden rounded-[28px] bg-[#111B2E] p-7 shadow-[0_22px_70px_rgba(15,23,42,0.18)] dark:bg-[#101827] md:p-8">
        <div class="relative">
            <div class="absolute -right-16 -top-20 h-56 w-56 rounded-full bg-blue-500/20 blur-3xl"></div>
            <div class="absolute bottom-0 right-28 h-24 w-24 rounded-full bg-cyan-400/10 blur-2xl"></div>

            <div class="relative z-10 flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                <div>
                    <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-semibold text-blue-100">
                        Akun Google Terhubung
                    </div>

                    <h1 class="text-2xl font-extrabold tracking-tight text-white md:text-3xl">
                        Profil Saya
                    </h1>

                    <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-300">
                        Kelola foto profil dan biodata akun PerCikAIS. Login akun menggunakan Google sekolah yang sudah terdaftar.
                    </p>
                </div>

                <div class="flex items-center gap-4 rounded-3xl border border-white/10 bg-white/5 p-4">
                    <img
                        src="{{ $user->profile_photo_url }}"
                        alt="{{ $user->name }}"
                        class="h-14 w-14 rounded-2xl object-cover shadow-lg"
                    >

                    <div class="min-w-0">
                        <p class="truncate text-sm font-bold text-white">{{ $user->name }}</p>
                        <p class="mt-1 truncate text-xs font-semibold text-slate-400">{{ $user->email }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (session('status') === 'profile-updated')
        <div class="mb-6 rounded-2xl border border-emerald-100 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-700 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300">
            Profil berhasil diperbarui.
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div class="xl:col-span-2">
            <div class="rounded-[28px] border border-slate-100 bg-white p-6 shadow-[0_14px_45px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524] md:p-8">
                <div class="mb-6 flex items-start justify-between gap-4 border-b border-slate-100 pb-6 dark:border-slate-800">
                    <div>
                        <h2 class="text-xl font-extrabold tracking-tight text-slate-950 dark:text-white">
                            Biodata Pengguna
                        </h2>
                        <p class="mt-2 text-sm font-medium leading-6 text-slate-400">
                            Perbarui data pribadi dan foto profil yang tampil di sistem.
                        </p>
                    </div>

                    <div class="hidden h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-300 sm:flex">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M4 20a8 8 0 0 1 16 0" />
                        </svg>
                    </div>
                </div>

                <div>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>

        <aside class="space-y-6">
            <div class="rounded-[28px] border border-slate-100 bg-white p-6 shadow-[0_14px_45px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524]">
                <div class="flex flex-col items-center text-center">
                    <img
                        src="{{ $user->profile_photo_url }}"
                        alt="{{ $user->name }}"
                        class="h-24 w-24 rounded-[28px] object-cover shadow-xl shadow-blue-500/10"
                    >

                    <h3 class="mt-5 text-lg font-extrabold text-slate-950 dark:text-white">
                        {{ $user->name }}
                    </h3>

                    <p class="mt-1 max-w-full truncate text-sm font-semibold text-slate-400">
                        {{ $user->email }}
                    </p>

                    <div class="mt-5 inline-flex rounded-2xl bg-blue-50 px-4 py-2 text-sm font-bold text-blue-600 dark:bg-blue-500/10 dark:text-blue-300">
                        Login Google
                    </div>
                </div>
            </div>

            <div class="rounded-[28px] border border-slate-100 bg-white p-6 shadow-[0_14px_45px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524]">
                <h3 class="text-lg font-extrabold text-slate-950 dark:text-white">
                    Ringkasan Akun
                </h3>

                <div class="mt-5 space-y-4">
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-[#121929]">
                        <span class="text-sm font-semibold text-slate-400">Role</span>
                        <span class="text-sm font-extrabold text-slate-700 dark:text-slate-200">
                            @if (method_exists($user, 'isAdmin') && $user->isAdmin())
                                Admin
                            @elseif (method_exists($user, 'isTeacher') && $user->isTeacher())
                                Guru
                            @else
                                Siswa
                            @endif
                        </span>
                    </div>

                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-[#121929]">
                        <span class="text-sm font-semibold text-slate-400">Akses</span>
                        <span class="text-sm font-extrabold text-slate-700 dark:text-slate-200">
                            Email Terdaftar
                        </span>
                    </div>

                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-[#121929]">
                        <span class="text-sm font-semibold text-slate-400">Bergabung</span>
                        <span class="text-sm font-extrabold text-slate-700 dark:text-slate-200">
                            {{ optional($user->created_at)->format('d M Y') ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</x-dynamic-component>