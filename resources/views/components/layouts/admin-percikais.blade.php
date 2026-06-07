@props(['title' => 'Admin Panel'])

@php
    $user = auth()->user();
    $userName = $user?->name ?? 'Administrator';
    $userEmail = $user?->email ?? 'admin@percikais.local';
    $avatarName = urlencode($userName);

    $profilePhotoUrl = $user?->profile_photo_url
        ?: 'https://ui-avatars.com/api/?name=' . $avatarName . '&background=2563eb&color=fff&bold=true&size=64';

    $navSections = [
        [
            'title' => 'Utama',
            'items' => [
                ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard', 'icon' => 'dashboard'],
            ],
        ],
        [
            'title' => 'Data Sekolah',
            'items' => [
                ['label' => 'Data Murid', 'route' => 'admin.students', 'active' => 'admin.students', 'icon' => 'students'],
                ['label' => 'Data Guru', 'route' => 'admin.teachers', 'active' => 'admin.teachers', 'icon' => 'teachers'],
                ['label' => 'Mata Pelajaran', 'route' => 'admin.subjects', 'active' => 'admin.subjects', 'icon' => 'subjects'],
            ],
        ],
        [
            'title' => 'Operasional',
            'items' => [
                ['label' => 'Absensi Harian', 'route' => 'admin.attendance', 'active' => 'admin.attendance', 'icon' => 'attendance'],
                ['label' => 'Keuangan SPP', 'route' => 'admin.finance', 'active' => 'admin.finance', 'icon' => 'finance'],
            ],
        ],
        [
            'title' => 'Sistem',
            'items' => [
                ['label' => 'Pengaturan', 'route' => 'admin.settings', 'active' => 'admin.settings', 'icon' => 'settings'],
            ],
        ],
    ];

    $currentPage = $title ?? 'Dashboard';
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin Panel' }} — PerCikAIS</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        * { font-family: 'Inter', sans-serif; }

        :root {
            --accent: #A78BFA; --accent-text: #7C3AED; --accent-tint: #F0EBFF;
            --accent-border: rgba(139, 92, 246, 0.20); --accent-ring: rgba(139, 92, 246, 0.12);
        }
        .dark {
            --accent-tint: rgba(139, 92, 246, 0.12);
            --accent-border: rgba(167, 139, 250, 0.24);
        }
        .accent-bg { background: var(--accent) !important; color: #fff !important; }
        .accent-text { color: var(--accent-text) !important; }
        .accent-tint { background: var(--accent-tint) !important; color: var(--accent-text) !important; }

        .nav-active {
            background: var(--accent-tint); color: var(--accent-text); font-weight: 600; position: relative;
        }
        .nav-active::before {
            content: ''; position: absolute; left: 0; top: 50%; transform: translateY(-50%);
            width: 3px; height: 60%; border-radius: 0 4px 4px 0; background: var(--accent-text);
        }
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: #E2E8F0; border-radius: 4px; }
        .dark .sidebar-scroll::-webkit-scrollbar-thumb { background: #334155; }
    </style>

    <script>
        (function () {
            if (localStorage.getItem('color-theme') === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            }
        })();
    </script>

    @stack('styles')
</head>

<body class="antialiased bg-[#FAFBFC] text-slate-800 dark:bg-[#0B0F19] dark:text-slate-200">

    @if ($isMobile ?? false)
        @include('components.layouts.partials.mobile-nav-admin')
    @else
    <div
        x-data="{ profileOpen: false }"
        class="flex min-h-screen"
    >
        {{-- LEFT SIDEBAR --}}
        <aside class="fixed left-0 top-0 bottom-0 z-50 w-[260px] bg-white dark:bg-[#0F1524] border-r border-slate-200/70 dark:border-slate-800/50 flex flex-col">
            <div class="h-16 flex items-center gap-3 px-6 border-b border-slate-100 dark:border-slate-800/50">
                <div class="w-8 h-8 shrink-0 flex items-center justify-center">
                    <img src="{{ asset('logo.png') }}" alt="Logo" class="w-8 h-8 object-contain dark:mix-blend-screen" />
                </div>
                <div>
                    <span class="text-[15px] font-bold text-slate-900 dark:text-white tracking-tight">PerCikAIS</span>
                    <span class="block text-[10px] text-slate-400 -mt-0.5">Admin</span>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto sidebar-scroll px-4 py-5 space-y-6">
                @foreach ($navSections as $section)
                    <div>
                        <p class="px-3 mb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">{{ $section['title'] }}</p>
                        <div class="space-y-0.5">
                            @foreach ($section['items'] as $item)
                                @php $isActive = request()->routeIs($item['active']); @endphp
                                <a href="{{ route($item['route']) }}"
                                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] transition-all duration-150
                                   {{ $isActive ? 'nav-active' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50' }}">
                                    <span class="flex h-5 w-5 items-center justify-center shrink-0 {{ $isActive ? 'text-violet-600 dark:text-violet-400' : 'text-slate-400' }}">
                                        @switch($item['icon'])
                                            @case('dashboard')
                                                <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 5.5A1.5 1.5 0 0 1 5.5 4h3A1.5 1.5 0 0 1 10 5.5v3A1.5 1.5 0 0 1 8.5 10h-3A1.5 1.5 0 0 1 4 8.5v-3ZM14 5.5A1.5 1.5 0 0 1 15.5 4h3A1.5 1.5 0 0 1 20 5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 14 8.5v-3ZM4 15.5A1.5 1.5 0 0 1 5.5 14h3a1.5 1.5 0 0 1 1.5 1.5v3A1.5 1.5 0 0 1 8.5 20h-3A1.5 1.5 0 0 1 4 18.5v-3ZM14 15.5a1.5 1.5 0 0 1 1.5-1.5h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a1.5 1.5 0 0 1-1.5-1.5v-3Z" /></svg>
                                                @break
                                            @case('students')
                                                <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20v-1.5A4.5 4.5 0 0 0 12.5 14h-5A4.5 4.5 0 0 0 3 18.5V20" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10 10a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM21 20v-1.5a3.5 3.5 0 0 0-2.5-3.37M16 3.13a3.5 3.5 0 0 1 0 6.74" /></svg>
                                                @break
                                            @case('teachers')
                                                <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 20a8 8 0 0 1 16 0" /></svg>
                                                @break
                                            @case('subjects')
                                                <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 5.5A2.5 2.5 0 0 1 7.5 3H19v15.5A2.5 2.5 0 0 1 16.5 21H7.5A2.5 2.5 0 0 1 5 18.5v-13Z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7h8M8 11h8M8 15h5" /></svg>
                                                @break
                                            @case('attendance')
                                                <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 4h8M9 4v3h6V4M7 7h10a2 2 0 0 1 2 2v9.5a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2Z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m8.5 14 2 2 5-5" /></svg>
                                                @break
                                            @case('finance')
                                                <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.75 7.75A2.75 2.75 0 0 1 6.5 5h11A2.75 2.75 0 0 1 20.25 7.75v8.5A2.75 2.75 0 0 1 17.5 19h-11a2.75 2.75 0 0 1-2.75-2.75v-8.5Z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 10h16M8 15h1.5M12 15h2.5" /></svg>
                                                @break
                                            @case('settings')
                                                <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z" /></svg>
                                                @break
                                        @endswitch
                                    </span>
                                    <span>{{ $item['label'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </nav>

            <div class="border-t border-slate-100 dark:border-slate-800/50 p-4">
                <div class="flex items-center gap-3">
                    <img src="{{ $profilePhotoUrl }}" alt="{{ $userName }}" class="h-9 w-9 rounded-full object-cover">
                    <div class="min-w-0 flex-1">
                        <p class="text-[13px] font-semibold text-slate-800 dark:text-white truncate">{{ $userName }}</p>
                        <p class="text-[11px] text-slate-400 truncate">Admin</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">@csrf
                        <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 transition" title="Keluar">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0-4-4m4 4H8M13 20H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h7" /></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- MAIN AREA --}}
        <div class="flex-1 ml-[260px]">
            <header class="sticky top-0 z-30 h-16 bg-white/80 dark:bg-[#0F1524]/80 backdrop-blur-md border-b border-slate-200/60 dark:border-slate-800/50 flex items-center gap-4 px-6">
                <div class="flex items-center gap-2 text-[13px]">
                    <span class="text-slate-400">Admin</span>
                    <svg class="h-3.5 w-3.5 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7" /></svg>
                    <span class="font-medium text-slate-700 dark:text-slate-200">{{ $currentPage }}</span>
                </div>

                <div class="flex-1 max-w-md mx-auto hidden md:block">
                    <div class="relative">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" /></svg>
                        <input type="text" placeholder="Cari..." class="w-full h-10 rounded-xl bg-slate-100/80 dark:bg-slate-800/60 border-0 pl-10 pr-4 text-[13px] text-slate-700 dark:text-slate-200 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-violet-500/30 transition">
                    </div>
                </div>

                <div class="flex items-center gap-2 ml-auto">
                    <button id="theme-toggle" type="button" class="flex h-9 w-9 items-center justify-center rounded-xl text-slate-500 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800 transition">
                        <svg id="theme-toggle-dark-icon" class="hidden h-[18px] w-[18px]" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" /></svg>
                        <svg id="theme-toggle-light-icon" class="hidden h-[18px] w-[18px]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a1 1 0 0 1 1 1v1a1 1 0 1 1-2 0V3a1 1 0 0 1 1-1Zm4 8a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" /></svg>
                    </button>

                    <div class="relative" x-on:click.outside="profileOpen = false">
                        <button x-on:click="profileOpen = !profileOpen" class="flex items-center gap-2.5 h-10 rounded-xl bg-slate-50 dark:bg-slate-800/60 pl-1.5 pr-3 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                            <img src="{{ $profilePhotoUrl }}" alt="{{ $userName }}" class="h-7 w-7 rounded-lg object-cover">
                            <span class="hidden sm:block text-[13px] font-medium text-slate-700 dark:text-slate-200 truncate max-w-[120px]">{{ $userName }}</span>
                        </button>
                        <div x-show="profileOpen" x-cloak x-transition.origin.top.right class="absolute right-0 mt-2 w-56 rounded-xl border border-slate-200/70 bg-white dark:border-slate-800 dark:bg-[#0F1524] shadow-lg p-1.5">
                            <div class="px-3 py-2.5">
                                <p class="text-[13px] font-semibold text-slate-800 dark:text-white truncate">{{ $userName }}</p>
                                <p class="text-[11px] text-slate-400 truncate mt-0.5">{{ $userEmail }}</p>
                            </div>
                            <div class="h-px bg-slate-100 dark:bg-slate-800 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">@csrf
                                <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 transition">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 16l4-4m0 0-4-4m4 4H8M13 20H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h7" /></svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="p-6 lg:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>
    @endif

    <script>
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
        function syncThemeIcon() {
            if (!themeToggleDarkIcon || !themeToggleLightIcon) return;
            if (localStorage.getItem('color-theme') === 'dark') { themeToggleLightIcon.classList.remove('hidden'); themeToggleDarkIcon.classList.add('hidden'); }
            else { themeToggleDarkIcon.classList.remove('hidden'); themeToggleLightIcon.classList.add('hidden'); }
        }
        syncThemeIcon();
        if (themeToggleBtn) {
            themeToggleBtn.addEventListener('click', function () {
                if (localStorage.getItem('color-theme') === 'light') { document.documentElement.classList.add('dark'); localStorage.setItem('color-theme', 'dark'); }
                else { document.documentElement.classList.remove('dark'); localStorage.setItem('color-theme', 'light'); }
                syncThemeIcon();
            });
        }
    </script>
    @stack('scripts')
</body>
</html>