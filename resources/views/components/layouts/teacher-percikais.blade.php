@props(['title' => 'Teacher Panel'])

@php
    $user = auth()->user();
    $userName = $user?->name ?? 'Guru';
    $userEmail = $user?->email ?? 'teacher@percikais.local';
    $avatarName = urlencode($userName);
    $profilePhotoUrl = $user?->profile_photo_url
        ?: 'https://ui-avatars.com/api/?name=' . $avatarName . '&background=2563eb&color=fff&bold=true';

    $navItems = [
        [
            'label' => 'Dashboard',
            'route' => 'teacher.dashboard',
            'active' => 'teacher.dashboard',
            'icon' => 'dashboard',
        ],
        [
            'label' => 'Absensi Siswa',
            'route' => 'teacher.attendance',
            'active' => 'teacher.attendance',
            'icon' => 'attendance',
        ],
        [
            'label' => 'Enroll Murid',
            'route' => 'teacher.enrollments',
            'active' => 'teacher.enrollments',
            'icon' => 'enroll',
        ],
    ];

    try {
        $pendingTeacherRequests = \App\Models\Attendance::where('is_verified', false)
            ->whereIn('status', ['Sakit', 'Izin'])
            ->count();
    } catch (\Throwable $e) {
        $pendingTeacherRequests = 0;
    }
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Teacher Panel' }} - PerCikAIS</title>

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
        .accent-bg { background: var(--accent) !important; color: #fff !important; }
        .accent-text { color: var(--accent-text) !important; }
        .accent-tint { background: var(--accent-tint) !important; color: var(--accent-text) !important; }
        .accent-border { border-color: var(--accent-border) !important; }
        .hover-accent:hover { color: var(--accent-text) !important; }
    </style>

    <script>
        (function () {
            const root = document.documentElement;
            const theme = localStorage.getItem('color-theme') || 'light';

            if (theme === 'dark') {
                root.classList.add('dark');
            } else {
                root.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            }

            const accents = {
                blue: { accent: '#3B82F6', text: '#2563EB', tint: '#EFF6FF', darkTint: 'rgba(59,130,246,0.12)', border: 'rgba(59,130,246,0.26)', ring: 'rgba(59,130,246,0.16)' },
                violet: { accent: '#8B5CF6', text: '#7C3AED', tint: '#F5F3FF', darkTint: 'rgba(139,92,246,0.12)', border: 'rgba(139,92,246,0.26)', ring: 'rgba(139,92,246,0.16)' },
                emerald: { accent: '#10B981', text: '#059669', tint: '#ECFDF5', darkTint: 'rgba(16,185,129,0.12)', border: 'rgba(16,185,129,0.26)', ring: 'rgba(16,185,129,0.16)' },
                rose: { accent: '#F43F5E', text: '#E11D48', tint: '#FFF1F2', darkTint: 'rgba(244,63,94,0.12)', border: 'rgba(244,63,94,0.26)', ring: 'rgba(244,63,94,0.16)' },
            };

            const selectedAccent = localStorage.getItem('accent-color') || 'blue';
            const color = accents[selectedAccent] || accents.blue;
            const useDarkTint = root.classList.contains('dark');

            root.style.setProperty('--accent', color.accent);
            root.style.setProperty('--accent-text', useDarkTint ? color.accent : color.text);
            root.style.setProperty('--accent-tint', useDarkTint ? color.darkTint : color.tint);
            root.style.setProperty('--accent-border', color.border);
            root.style.setProperty('--accent-ring', color.ring);
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
                        <a href="{{ route('teacher.dashboard') }}" class="flex items-center gap-3">
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
                                    Teacher Space
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
                                @if ($item['icon'] === 'dashboard')
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M4 5.5A1.5 1.5 0 0 1 5.5 4h3A1.5 1.5 0 0 1 10 5.5v3A1.5 1.5 0 0 1 8.5 10h-3A1.5 1.5 0 0 1 4 8.5v-3ZM14 5.5A1.5 1.5 0 0 1 15.5 4h3A1.5 1.5 0 0 1 20 5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 14 8.5v-3ZM4 15.5A1.5 1.5 0 0 1 5.5 14h3a1.5 1.5 0 0 1 1.5 1.5v3A1.5 1.5 0 0 1 8.5 20h-3A1.5 1.5 0 0 1 4 18.5v-3ZM14 15.5a1.5 1.5 0 0 1 1.5-1.5h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a1.5 1.5 0 0 1-1.5-1.5v-3Z" />
                                    </svg>
                                @elseif ($item['icon'] === 'attendance')
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M8 4h8M9 4v3h6V4M7 7h10a2 2 0 0 1 2 2v9.5a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="m8.5 14 2 2 5-5" />
                                    </svg>
                                @else
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M16 20v-1.5A4.5 4.5 0 0 0 11.5 14h-4A4.5 4.5 0 0 0 3 18.5V20" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M9.5 10.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7ZM21 8l-3 3-1.5-1.5" />
                                    </svg>
                                @endif

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
                                placeholder="Cari murid, absensi, mata pelajaran... (Enter)"
                                class="h-14 w-full rounded-[22px] border border-slate-100 bg-white pl-14 pr-5 text-sm font-medium text-slate-700 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-blue-200 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-800 dark:bg-[#0F1524] dark:text-slate-100 dark:placeholder:text-slate-500"
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
                                @if ($pendingTeacherRequests > 0)
                                    <span class="accent-bg absolute right-3 top-3 h-2.5 w-2.5 rounded-full ring-4 ring-blue-100 dark:ring-white/10"></span>
                                @endif

                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.17V11a6 6 0 1 0-12 0v3.17a2 2 0 0 1-.6 1.43L4 17h5" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M10 20a2 2 0 0 0 4 0" />
                                </svg>
                            </button>

                            <div
                                x-show="notificationOpen"
                                x-cloak
                                x-transition.origin.top.right
                                class="absolute right-0 mt-3 w-[330px] overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-[0_22px_70px_rgba(15,23,42,0.14)] dark:border-slate-800 dark:bg-[#0F1524]"
                            >
                                <div class="border-b border-slate-100 px-5 py-4 dark:border-slate-800">
                                    <h3 class="text-sm font-extrabold text-slate-950 dark:text-white">
                                        Notifikasi Guru
                                    </h3>
                                    <p class="mt-1 text-xs font-semibold text-slate-400">
                                        {{ $pendingTeacherRequests }} pengajuan menunggu verifikasi
                                    </p>
                                </div>

                                <div class="p-2">
                                    <a href="{{ route('teacher.attendance') }}" class="block rounded-2xl p-4 transition hover:bg-slate-50 dark:hover:bg-slate-800">
                                        <p class="text-sm font-extrabold text-slate-800 dark:text-white">
                                            Cek Pengajuan Sakit/Izin
                                        </p>
                                        <p class="mt-1 text-xs font-medium text-slate-400">
                                            Verifikasi surat dan status berhalangan siswa.
                                        </p>
                                    </a>
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
                                        Guru
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
                                    <img src="{{ $profilePhotoUrl }}" alt="{{ $userName }}" class="h-11 w-11 rounded-2xl object-cover shadow-sm">
                                    <div class="min-w-0">
                                        <div class="truncate text-sm font-bold text-slate-900 dark:text-white">{{ $userName }}</div>
                                        <div class="truncate text-xs font-medium text-slate-400">{{ $userEmail }}</div>
                                    </div>
                                </div>

                                <div class="my-1 h-px bg-slate-100 dark:bg-slate-800"></div>

                                <a
                                    href="{{ route('teacher.settings') }}"
                                    class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50 hover-accent dark:text-slate-300 dark:hover:bg-slate-800"
                                >
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