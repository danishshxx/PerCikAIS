@props(['title' => 'Admin Panel'])

@php
    $user = auth()->user();
    $userName = $user?->name ?? 'Administrator';
    $userEmail = $user?->email ?? 'admin@percikais.local';
    $avatarName = urlencode($userName);

    $profilePhotoUrl = $user?->profile_photo_url
        ?: 'https://ui-avatars.com/api/?name=' . $avatarName . '&background=2563eb&color=fff&bold=true';

    $isSuperAdmin = method_exists($user, 'isSuperAdmin') && $user->isSuperAdmin();

    $navItems = [
        [
            'label' => 'Dashboard',
            'route' => 'admin.dashboard',
            'active' => 'admin.dashboard',
            'icon' => 'dashboard',
        ],
        [
            'label' => 'Data Murid',
            'route' => 'admin.students',
            'active' => 'admin.students',
            'icon' => 'students',
        ],
        [
            'label' => 'Data Guru',
            'route' => 'admin.teachers',
            'active' => 'admin.teachers',
            'icon' => 'teachers',
        ],
        [
            'label' => 'Absensi & Mapel',
            'route' => 'admin.attendance',
            'active' => 'admin.attendance',
            'icon' => 'attendance',
        ],
        [
            'label' => 'Kelola Keuangan',
            'route' => 'admin.finance',
            'active' => 'admin.finance',
            'icon' => 'finance',
        ],

        [
            'label' => 'Mata Pelajaran',
            'route' => 'admin.subjects',
            'active' => 'admin.subjects',
            'icon' => 'subjects',
        ],
    ];

    if ($isSuperAdmin && Route::has('admin.admins')) {
        $navItems[] = [
            'label' => 'Kelola Admin',
            'route' => 'admin.admins',
            'active' => 'admin.admins',
            'icon' => 'admin',
        ];
    }

    $notifications = [
        [
            'title' => 'Pantau data murid',
            'description' => 'Kelola data siswa aktif dan pastikan email sekolah sudah terdaftar.',
            'time' => 'Data akademik',
            'route' => 'admin.students',
            'color' => 'blue',
            'icon' => 'students',
        ],
        [
            'title' => 'Cek absensi harian',
            'description' => 'Lihat presensi siswa dan status verifikasi absensi.',
            'time' => 'Operasional',
            'route' => 'admin.attendance',
            'color' => 'violet',
            'icon' => 'attendance',
        ],
        [
            'title' => 'Monitoring administrasi',
            'description' => 'Pantau tagihan, pembayaran, dan tunggakan SPP.',
            'time' => 'Keuangan',
            'route' => 'admin.finance',
            'color' => 'emerald',
            'icon' => 'finance',
        ],
    ];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin Panel' }} - PerCikAIS</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        :root {
            --accent: #3B82F6;
            --accent-text: #2563EB;
            --accent-tint: #EFF6FF;
            --accent-border: rgba(59, 130, 246, 0.26);
            --accent-ring: rgba(59, 130, 246, 0.16);
        }

        .accent-bg {
            background: var(--accent) !important;
            color: #ffffff !important;
        }

        .accent-text {
            color: var(--accent-text) !important;
        }

        .accent-tint {
            background: var(--accent-tint) !important;
            color: var(--accent-text) !important;
        }

        .accent-border {
            border-color: var(--accent-border) !important;
        }

        .accent-ring:focus {
            border-color: var(--accent-border) !important;
            box-shadow: 0 0 0 4px var(--accent-ring) !important;
        }

        .hover-accent:hover {
            color: var(--accent-text) !important;
        }
    </style>

    <script>
        (function () {
            const accents = {
                blue: { accent: '#3B82F6', text: '#2563EB', tint: '#EFF6FF', darkTint: 'rgba(59,130,246,0.12)', border: 'rgba(59,130,246,0.26)', ring: 'rgba(59,130,246,0.16)' },
                violet: { accent: '#8B5CF6', text: '#7C3AED', tint: '#F5F3FF', darkTint: 'rgba(139,92,246,0.12)', border: 'rgba(139,92,246,0.26)', ring: 'rgba(139,92,246,0.16)' },
                indigo: { accent: '#6366F1', text: '#4F46E5', tint: '#EEF2FF', darkTint: 'rgba(99,102,241,0.12)', border: 'rgba(99,102,241,0.26)', ring: 'rgba(99,102,241,0.16)' },
                cyan: { accent: '#06B6D4', text: '#0891B2', tint: '#ECFEFF', darkTint: 'rgba(6,182,212,0.12)', border: 'rgba(6,182,212,0.26)', ring: 'rgba(6,182,212,0.16)' },
                emerald: { accent: '#10B981', text: '#059669', tint: '#ECFDF5', darkTint: 'rgba(16,185,129,0.12)', border: 'rgba(16,185,129,0.26)', ring: 'rgba(16,185,129,0.16)' },
                teal: { accent: '#14B8A6', text: '#0D9488', tint: '#F0FDFA', darkTint: 'rgba(20,184,166,0.12)', border: 'rgba(20,184,166,0.26)', ring: 'rgba(20,184,166,0.16)' },
                amber: { accent: '#F59E0B', text: '#D97706', tint: '#FFFBEB', darkTint: 'rgba(245,158,11,0.12)', border: 'rgba(245,158,11,0.26)', ring: 'rgba(245,158,11,0.16)' },
                rose: { accent: '#F43F5E', text: '#E11D48', tint: '#FFF1F2', darkTint: 'rgba(244,63,94,0.12)', border: 'rgba(244,63,94,0.26)', ring: 'rgba(244,63,94,0.16)' },
                slate: { accent: '#64748B', text: '#475569', tint: '#F1F5F9', darkTint: 'rgba(100,116,139,0.16)', border: 'rgba(100,116,139,0.26)', ring: 'rgba(100,116,139,0.16)' },
            };

            const root = document.documentElement;
            const theme = localStorage.getItem('color-theme') || 'light';

            if (theme === 'dark') {
                root.classList.add('dark');
            } else if (theme === 'system') {
                if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    root.classList.add('dark');
                } else {
                    root.classList.remove('dark');
                }
            } else {
                root.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            }

            const selectedAccent = localStorage.getItem('accent-color') || 'blue';
            const color = accents[selectedAccent] || accents.blue;
            const useDarkTint = root.classList.contains('dark');

            root.style.setProperty('--accent', color.accent);
            root.style.setProperty('--accent-text', useDarkTint ? color.accent : color.text);
            root.style.setProperty('--accent-tint', useDarkTint ? color.darkTint : color.tint);
            root.style.setProperty('--accent-border', color.border);
            root.style.setProperty('--accent-ring', color.ring);
            root.dataset.accent = selectedAccent;
        })();
    </script>

    @stack('styles')
</head>

<body class="antialiased bg-[#F7F9FC] text-slate-900 dark:bg-[#090D16] dark:text-slate-100">
    <div
        x-data="{
            sidebarOpen: window.innerWidth >= 1024,
            profileOpen: false,
            notificationOpen: false
        }"
        x-init="
            window.addEventListener('resize', () => {
                sidebarOpen = window.innerWidth >= 1024
            })
        "
        class="min-h-screen"
    >
        <div
            x-show="sidebarOpen"
            x-cloak
            x-transition.opacity
            x-on:click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-slate-950/40 backdrop-blur-sm lg:hidden"
        ></div>

        <aside
            x-cloak
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-[120%]'"
            class="fixed left-4 top-4 bottom-4 z-50 w-[280px] rounded-[28px] border border-white/80 bg-white shadow-[0_18px_60px_rgba(15,23,42,0.08)] transition-transform duration-300 ease-out dark:border-slate-800/70 dark:bg-[#0F1524] lg:translate-x-0"
        >
            <div class="flex h-full flex-col overflow-hidden rounded-[28px]">
                <div class="px-6 pt-6">
                    <div class="mb-8 flex items-center justify-between">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                            <div class="accent-tint flex h-11 w-11 items-center justify-center rounded-2xl border accent-border shadow-sm">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3.75 4.5 7.25v5.5c0 4.25 3.05 6.9 7.5 7.5 4.45-.6 7.5-3.25 7.5-7.5v-5.5L12 3.75Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.5 12.3 11.2 14l3.5-4" />
                                </svg>
                            </div>

                            <div>
                                <div class="text-lg font-extrabold tracking-tight text-slate-950 dark:text-white">
                                    PerCikAIS
                                </div>
                                <div class="text-xs font-semibold text-slate-400">
                                    Admin Space
                                </div>
                            </div>
                        </a>

                        <button
                            type="button"
                            x-on:click="sidebarOpen = false"
                            class="rounded-xl p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700 dark:hover:bg-slate-800 lg:hidden"
                        >
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <nav class="space-y-2">
                        @foreach ($navItems as $item)
                            @php
                                $isActive = request()->routeIs($item['active']);
                            @endphp

                            <a
                                href="{{ route($item['route']) }}"
                                class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold transition
                                {{ $isActive
                                    ? 'accent-tint shadow-sm'
                                    : 'text-slate-500 hover:bg-slate-50 hover-accent dark:text-slate-400 dark:hover:bg-slate-800/70'
                                }}"
                            >
                                <span class="flex h-5 w-5 items-center justify-center">
                                    @switch($item['icon'])
                                        @case('dashboard')
                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M4 5.5A1.5 1.5 0 0 1 5.5 4h3A1.5 1.5 0 0 1 10 5.5v3A1.5 1.5 0 0 1 8.5 10h-3A1.5 1.5 0 0 1 4 8.5v-3ZM14 5.5A1.5 1.5 0 0 1 15.5 4h3A1.5 1.5 0 0 1 20 5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 14 8.5v-3ZM4 15.5A1.5 1.5 0 0 1 5.5 14h3a1.5 1.5 0 0 1 1.5 1.5v3A1.5 1.5 0 0 1 8.5 20h-3A1.5 1.5 0 0 1 4 18.5v-3ZM14 15.5a1.5 1.5 0 0 1 1.5-1.5h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a1.5 1.5 0 0 1-1.5-1.5v-3Z" />
                                            </svg>
                                            @break

                                        @case('students')
                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M16 20v-1.5A4.5 4.5 0 0 0 11.5 14h-4A4.5 4.5 0 0 0 3 18.5V20" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M9.5 10.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7ZM21 20v-1a4 4 0 0 0-3-3.87M15.5 3.63a3.5 3.5 0 0 1 0 6.74" />
                                            </svg>
                                            @break

                                        @case('teachers')
                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M12 14a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M4 20a8 8 0 0 1 16 0" />
                                            </svg>
                                            @break

                                        @case('attendance')
                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M8 4h8M9 4v3h6V4M7 7h10a2 2 0 0 1 2 2v9.5a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="m8.5 14 2 2 5-5" />
                                            </svg>
                                            @break

                                        @case('finance')
                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M15 9.5A2.6 2.6 0 0 0 12.5 8h-1A2.1 2.1 0 0 0 9.4 10.1c0 1 .72 1.75 1.76 2l1.86.38A2.1 2.1 0 0 1 14.6 14.5 2.5 2.5 0 0 1 12 17h-.8A3 3 0 0 1 8.5 15.5M12 6.5V8M12 17v1.5" />
                                            </svg>
                                            @break

                                        @case('admin')
                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M12 3.5 5 6.5v5.7c0 4 2.8 6.7 7 7.8 4.2-1.1 7-3.8 7-7.8V6.5l-7-3Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M9.5 12.2 11.2 14l3.6-4.2" />
                                            </svg>
                                            @break
                                        @case('subjects')
                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M4.5 6.5A2.5 2.5 0 0 1 7 4h10a2.5 2.5 0 0 1 2.5 2.5v13A1.5 1.5 0 0 1 18 21H7a2.5 2.5 0 0 1-2.5-2.5v-12Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M8 8h8M8 12h8M8 16h5" />
                                            </svg>
                                            @break
                                    @endswitch
                                </span>

                                <span>{{ $item['label'] }}</span>
                            </a>
                        @endforeach
                    </nav>
                </div>
            </div>
        </aside>

        <div class="min-h-screen transition-all duration-300 lg:pl-[312px]">
            <header class="sticky top-0 z-30 bg-[#F7F9FC]/90 px-4 py-4 backdrop-blur-xl dark:bg-[#090D16]/90 sm:px-6 lg:px-8">
                <div class="flex items-center gap-4">
                    <button
                        type="button"
                        x-on:click="sidebarOpen = !sidebarOpen"
                        class="flex h-12 w-12 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-500 shadow-sm transition hover-accent dark:border-slate-800 dark:bg-[#0F1524] dark:text-slate-400 lg:hidden"
                    >
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="hidden flex-1 md:block">
                        <div class="relative max-w-2xl">
                            <svg class="pointer-events-none absolute left-5 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" />
                            </svg>

                            <input
                                type="text"
                                placeholder="Cari murid, guru, absensi, tagihan... (Enter)"
                                class="accent-ring h-14 w-full rounded-[22px] border border-slate-100 bg-white pl-14 pr-5 text-sm font-medium text-slate-700 shadow-sm outline-none transition placeholder:text-slate-400 dark:border-slate-800 dark:bg-[#0F1524] dark:text-slate-100 dark:placeholder:text-slate-500"
                            >
                        </div>
                    </div>

                    <div class="ml-auto flex items-center gap-3">
                        <button
                            id="theme-toggle"
                            type="button"
                            class="flex h-12 w-12 items-center justify-center rounded-2xl border border-slate-100 bg-white text-slate-500 shadow-sm transition hover-accent dark:border-slate-800 dark:bg-[#0F1524] dark:text-slate-400"
                        >
                            <svg id="theme-toggle-dark-icon" class="hidden h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                            </svg>

                            <svg id="theme-toggle-light-icon" class="hidden h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2a1 1 0 0 1 1 1v1a1 1 0 1 1-2 0V3a1 1 0 0 1 1-1Zm4 8a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div class="relative" x-on:click.outside="notificationOpen = false">
                            <button
                                type="button"
                                x-on:click="notificationOpen = !notificationOpen; profileOpen = false"
                                class="relative flex h-12 w-12 items-center justify-center rounded-2xl border border-slate-100 bg-white text-slate-500 shadow-sm transition hover-accent dark:border-slate-800 dark:bg-[#0F1524] dark:text-slate-400"
                            >
                                <span class="accent-bg absolute right-3 top-3 h-2.5 w-2.5 rounded-full ring-4 ring-blue-100 dark:ring-white/10"></span>

                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.17V11a6 6 0 1 0-12 0v3.17a2 2 0 0 1-.6 1.43L4 17h5" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M10 20a2 2 0 0 0 4 0" />
                                </svg>
                            </button>

                            <div
                                x-show="notificationOpen"
                                x-cloak
                                x-transition.origin.top.right
                                class="absolute right-0 mt-3 w-[340px] max-w-[calc(100vw-2rem)] overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-[0_22px_70px_rgba(15,23,42,0.14)] dark:border-slate-800 dark:bg-[#0F1524]"
                            >
                                <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4 dark:border-slate-800">
                                    <div>
                                        <h3 class="text-sm font-extrabold text-slate-950 dark:text-white">
                                            Notifikasi Admin
                                        </h3>
                                        <p class="mt-1 text-xs font-semibold text-slate-400">
                                            Ringkasan operasional sekolah
                                        </p>
                                    </div>

                                    <span class="accent-tint rounded-full px-3 py-1 text-xs font-extrabold">
                                        {{ count($notifications) }} Baru
                                    </span>
                                </div>

                                <div class="max-h-[360px] overflow-y-auto p-2">
                                    @foreach ($notifications as $notification)
                                        <a
                                            href="{{ route($notification['route']) }}"
                                            class="group flex gap-3 rounded-2xl p-3 transition hover:bg-slate-50 dark:hover:bg-slate-800/70"
                                        >
                                            <div
                                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl
                                                @if ($notification['color'] === 'blue')
                                                    bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-300
                                                @elseif ($notification['color'] === 'emerald')
                                                    bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-300
                                                @else
                                                    bg-violet-50 text-violet-600 dark:bg-violet-500/10 dark:text-violet-300
                                                @endif"
                                            >
                                                @if ($notification['icon'] === 'students')
                                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M16 20v-1.5A4.5 4.5 0 0 0 11.5 14h-4A4.5 4.5 0 0 0 3 18.5V20M9.5 10.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z" />
                                                    </svg>
                                                @elseif ($notification['icon'] === 'attendance')
                                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M8 4h8M9 4v3h6V4M7 7h10a2 2 0 0 1 2 2v9.5a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2Z" />
                                                    </svg>
                                                @else
                                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M15 9.5A2.6 2.6 0 0 0 12.5 8h-1A2.1 2.1 0 0 0 9.4 10.1c0 1 .72 1.75 1.76 2l1.86.38A2.1 2.1 0 0 1 14.6 14.5 2.5 2.5 0 0 1 12 17h-.8A3 3 0 0 1 8.5 15.5M12 6.5V8M12 17v1.5" />
                                                    </svg>
                                                @endif
                                            </div>

                                            <div class="min-w-0 flex-1">
                                                <div class="flex items-start justify-between gap-3">
                                                    <p class="text-sm font-extrabold text-slate-800 group-hover:text-blue-600 dark:text-slate-100 dark:group-hover:text-blue-300">
                                                        {{ $notification['title'] }}
                                                    </p>

                                                    <span class="mt-1 h-2 w-2 shrink-0 rounded-full" style="background: var(--accent)"></span>
                                                </div>

                                                <p class="mt-1 text-xs font-medium leading-5 text-slate-400">
                                                    {{ $notification['description'] }}
                                                </p>

                                                <p class="mt-2 text-[11px] font-bold text-slate-300">
                                                    {{ $notification['time'] }}
                                                </p>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>

                                <div class="border-t border-slate-100 p-3 dark:border-slate-800">
                                    <button
                                        type="button"
                                        x-on:click="notificationOpen = false"
                                        class="w-full rounded-2xl bg-slate-50 px-4 py-3 text-sm font-extrabold text-slate-600 transition hover:bg-slate-100 dark:bg-[#121929] dark:text-slate-300 dark:hover:bg-slate-800"
                                    >
                                        Tutup Notifikasi
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="relative" x-on:click.outside="profileOpen = false">
                            <button
                                type="button"
                                x-on:click="profileOpen = !profileOpen; notificationOpen = false"
                                class="flex h-14 items-center gap-3 rounded-[22px] border border-slate-100 bg-white py-2 pl-2 pr-4 shadow-sm transition hover:border-blue-100 dark:border-slate-800 dark:bg-[#0F1524] dark:hover:border-blue-500/20"
                            >
                                <img
                                    src="{{ $profilePhotoUrl }}"
                                    alt="{{ $userName }}"
                                    class="h-10 w-10 rounded-2xl object-cover"
                                >

                                <div class="hidden min-w-0 text-left sm:block">
                                    <div class="max-w-[150px] truncate text-sm font-bold text-slate-900 dark:text-white">
                                        {{ $userName }}
                                    </div>
                                    <div class="text-xs font-medium text-slate-400">
                                        {{ $isSuperAdmin ? 'Super Administrator' : 'Administrator' }}
                                    </div>
                                </div>

                                <svg class="hidden h-4 w-4 text-slate-400 sm:block" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6" />
                                </svg>
                            </button>

                            <div
                                x-show="profileOpen"
                                x-cloak
                                x-transition.origin.top.right
                                class="absolute right-0 mt-3 w-64 overflow-hidden rounded-3xl border border-slate-100 bg-white p-2 shadow-[0_22px_70px_rgba(15,23,42,0.14)] dark:border-slate-800 dark:bg-[#0F1524]"
                            >
                                <div class="flex items-center gap-3 px-4 py-3">
                                    <img
                                        src="{{ $profilePhotoUrl }}"
                                        alt="{{ $userName }}"
                                        class="h-11 w-11 rounded-2xl object-cover shadow-sm"
                                    >

                                    <div class="min-w-0">
                                        <div class="truncate text-sm font-bold text-slate-900 dark:text-white">
                                            {{ $userName }}
                                        </div>
                                        <div class="truncate text-xs font-medium text-slate-400">
                                            {{ $userEmail }}
                                        </div>
                                    </div>
                                </div>

                                <div class="my-1 h-px bg-slate-100 dark:bg-slate-800"></div>

                                <a
                                    href="{{ route('settings.index') }}"
                                    class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50 hover-accent dark:text-slate-300 dark:hover:bg-slate-800"
                                >
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M19.4 15a1.8 1.8 0 0 0 .36 1.98l.06.06a2.1 2.1 0 0 1-2.97 2.97l-.06-.06a1.8 1.8 0 0 0-1.98-.36 1.8 1.8 0 0 0-1.1 1.66v.17a2.1 2.1 0 0 1-4.2 0v-.09A1.8 1.8 0 0 0 8.4 19.6a1.8 1.8 0 0 0-1.98.36l-.06.06a2.1 2.1 0 0 1-2.97-2.97l.06-.06A1.8 1.8 0 0 0 3.8 15 1.8 1.8 0 0 0 2.2 13.9H2a2.1 2.1 0 0 1 0-4.2h.09A1.8 1.8 0 0 0 3.8 8.6a1.8 1.8 0 0 0-.36-1.98l-.06-.06a2.1 2.1 0 0 1 2.97-2.97l.06.06A1.8 1.8 0 0 0 8.4 4a1.8 1.8 0 0 0 1.1-1.66V2.2a2.1 2.1 0 0 1 4.2 0v.09A1.8 1.8 0 0 0 14.8 4a1.8 1.8 0 0 0 1.98-.36l.06-.06a2.1 2.1 0 0 1 2.97 2.97l-.06.06A1.8 1.8 0 0 0 19.4 8.6a1.8 1.8 0 0 0 1.66 1.1h.17a2.1 2.1 0 0 1 0 4.2h-.09A1.8 1.8 0 0 0 19.4 15Z" />
                                    </svg>

                                    Pengaturan
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <button
                                        type="submit"
                                        class="flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-sm font-bold text-red-600 transition hover:bg-red-50 dark:text-red-300 dark:hover:bg-red-500/10"
                                    >
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="px-4 pb-8 pt-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script>
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        function syncThemeIcon() {
            if (!themeToggleDarkIcon || !themeToggleLightIcon) return;

            if (document.documentElement.classList.contains('dark')) {
                themeToggleLightIcon.classList.remove('hidden');
                themeToggleDarkIcon.classList.add('hidden');
            } else {
                themeToggleDarkIcon.classList.remove('hidden');
                themeToggleLightIcon.classList.add('hidden');
            }
        }

        syncThemeIcon();

        if (themeToggleBtn) {
            themeToggleBtn.addEventListener('click', function () {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }

                syncThemeIcon();
            });
        }
    </script>

    @stack('scripts')
</body>
</html>