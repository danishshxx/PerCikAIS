{{-- ========================================
    MOBILE LAYOUT — TEACHER (PerCikAIS)
    Server-side detected mobile view
    Top bar + Floating Bottom Navigation
   ======================================== --}}

@php
    $user = auth()->user();
    $userName = $user?->name ?? 'Guru';
    $avatarName = urlencode($userName);
    $profilePhotoUrl = $user?->profile_photo_url
        ?: 'https://ui-avatars.com/api/?name=' . $avatarName . '&background=2563eb&color=fff&bold=true&size=64';

    try {
        $pendingMobile = \App\Models\Attendance::where('is_verified', false)
            ->whereIn('status', ['Sakit', 'Izin'])
            ->count();
    } catch (\Throwable $e) {
        $pendingMobile = 0;
    }

    $mobileNavItems = [
        [
            'label' => 'Dashboard',
            'route' => 'teacher.dashboard',
            'active' => 'teacher.dashboard',
            'icon' => 'home',
        ],
        [
            'label' => 'Absensi',
            'route' => 'teacher.attendance',
            'active' => 'teacher.attendance',
            'icon' => 'attendance',
        ],
        [
            'label' => 'Enroll',
            'route' => 'teacher.enrollments',
            'active' => 'teacher.enrollments',
            'icon' => 'enroll',
        ],
        [
            'label' => 'Setting',
            'route' => 'teacher.settings',
            'active' => 'teacher.settings',
            'icon' => 'settings',
        ],
    ];
@endphp

<div x-data="{ mobileProfileOpen: false }" class="min-h-screen bg-[#F7F9FC] dark:bg-[#090D16] text-slate-900 dark:text-slate-100 flex flex-col transition-colors duration-300 relative overflow-x-hidden">

    {{-- ═══════════ Mobile Top Bar ═══════════ --}}
    <header class="fixed top-0 left-0 right-0 h-16 bg-white/80 dark:bg-[#0b0f19]/80 backdrop-blur-md border-b border-slate-200/50 dark:border-slate-800/50 z-50 flex items-center justify-between px-5 transition-colors duration-300">
        <a href="{{ route('teacher.dashboard') }}" class="flex items-center gap-2.5">
            <div class="w-8 h-8 shrink-0 flex items-center justify-center">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="w-8 h-8 object-contain dark:mix-blend-screen" />
            </div>
            <div>
                <span class="font-extrabold text-xs tracking-wider text-slate-800 dark:text-slate-200 uppercase">PerCikAIS</span>
                <span class="block text-[9px] font-semibold text-slate-400 -mt-0.5">Teacher Space</span>
            </div>
        </a>

        <div class="flex items-center gap-3">
            {{-- Pending Badge --}}
            @if ($pendingMobile > 0)
                <div class="flex h-7 items-center gap-1 rounded-full bg-amber-50 px-2.5 text-[10px] font-bold text-amber-600 dark:bg-amber-500/10 dark:text-amber-300 border border-amber-200/50 dark:border-amber-500/20">
                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                    {{ $pendingMobile }}
                </div>
            @endif

            {{-- Theme Toggle --}}
            <button
                id="mobile-theme-toggle"
                type="button"
                class="flex h-9 w-9 items-center justify-center rounded-xl bg-slate-100/80 text-slate-500 transition hover:text-blue-600 hover:scale-105 dark:bg-slate-800/80 dark:text-slate-400 dark:hover:text-blue-300"
            >
                <svg id="mobile-theme-dark-icon" class="hidden h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                </svg>
                <svg id="mobile-theme-light-icon" class="hidden h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 2a1 1 0 0 1 1 1v1a1 1 0 1 1-2 0V3a1 1 0 0 1 1-1Zm4 8a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" />
                </svg>
            </button>

            {{-- User Avatar Button & Dropdown --}}
            <div class="relative" x-on:click.outside="mobileProfileOpen = false">
                <button
                    type="button"
                    x-on:click="mobileProfileOpen = !mobileProfileOpen"
                    class="w-8 h-8 rounded-full overflow-hidden bg-slate-100 dark:bg-slate-800 shadow-sm border border-slate-200/30 dark:border-slate-700/30 flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-blue-500/50"
                >
                    <img src="{{ $profilePhotoUrl }}" alt="{{ $userName }}" class="w-full h-full object-cover" />
                </button>

                {{-- Mobile Profile Dropdown --}}
                <div
                    x-show="mobileProfileOpen"
                    x-cloak
                    x-transition.origin.top.right
                    class="absolute right-0 mt-2 w-48 rounded-xl border border-slate-200/70 bg-white dark:border-slate-800 dark:bg-[#0F1524] shadow-lg shadow-slate-200/50 dark:shadow-black/20 p-1.5 z-[100]"
                >
                    <div class="px-3 py-2.5">
                        <p class="text-[12px] font-semibold text-slate-800 dark:text-white truncate leading-none">{{ $userName }}</p>
                        <p class="text-[10px] text-slate-400 truncate mt-1 leading-none">Guru</p>
                    </div>
                    <div class="h-px bg-slate-100 dark:bg-slate-800 my-1"></div>
                    <a href="{{ route('teacher.settings') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-[12px] text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                        <svg class="h-3.5 w-3.5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z" /></svg>
                        Pengaturan
                    </a>
                    <div class="h-px bg-slate-100 dark:bg-slate-800 my-1"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded-lg text-[12px] text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 transition text-left font-bold">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 16l4-4m0 0-4-4m4 4H8M13 20H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h7" /></svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    {{-- ═══════════ Mobile Content Area ═══════════ --}}
    <main class="flex-1 pt-20 pb-28 px-4 overflow-y-auto w-full max-w-lg mx-auto">
        {{ $slot }}
    </main>

    {{-- ═══════════ Floating Bottom Navigation ═══════════ --}}
    <nav class="fixed bottom-4 left-4 right-4 h-16 bg-white/90 dark:bg-[#0b0f19]/90 border border-slate-200/40 dark:border-slate-800/40 shadow-[0_8px_30px_rgba(0,0,0,0.06)] dark:shadow-[0_8px_30px_rgba(0,0,0,0.35)] rounded-2xl z-50 flex items-center justify-around px-2 backdrop-blur-md max-w-lg mx-auto transition-colors duration-300">
        @foreach ($mobileNavItems as $item)
            @php
                $isActive = request()->routeIs($item['active']);
            @endphp

            <a
                href="{{ route($item['route']) }}"
                class="flex flex-col items-center justify-center flex-1 py-1 px-1 rounded-xl transition-all duration-300 group
                {{ $isActive
                    ? 'text-blue-600 dark:text-blue-400 font-bold'
                    : 'text-slate-400 dark:text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'
                }}"
            >
                <span class="mb-1 transition-transform duration-300 group-hover:scale-110 {{ $isActive ? 'scale-110' : '' }}">
                    @switch($item['icon'])
                        @case('home')
                            <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M4 5.5A1.5 1.5 0 0 1 5.5 4h3A1.5 1.5 0 0 1 10 5.5v3A1.5 1.5 0 0 1 8.5 10h-3A1.5 1.5 0 0 1 4 8.5v-3ZM14 5.5A1.5 1.5 0 0 1 15.5 4h3A1.5 1.5 0 0 1 20 5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 14 8.5v-3ZM4 15.5A1.5 1.5 0 0 1 5.5 14h3a1.5 1.5 0 0 1 1.5 1.5v3A1.5 1.5 0 0 1 8.5 20h-3A1.5 1.5 0 0 1 4 18.5v-3ZM14 15.5a1.5 1.5 0 0 1 1.5-1.5h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a1.5 1.5 0 0 1-1.5-1.5v-3Z" />
                            </svg>
                            @break
                        @case('attendance')
                            <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M8 4h8M9 4v3h6V4M7 7h10a2 2 0 0 1 2 2v9.5a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="m8.5 14 2 2 5-5" />
                            </svg>
                            @break
                        @case('enroll')
                            <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M16 20v-1.5A4.5 4.5 0 0 0 11.5 14h-4A4.5 4.5 0 0 0 3 18.5V20" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M9.5 10.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7ZM21 8l-3 3-1.5-1.5" />
                            </svg>
                            @break
                        @case('settings')
                            <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M19.4 15a1.8 1.8 0 0 0 .36 1.98l.06.06a2.1 2.1 0 0 1-2.97 2.97l-.06-.06a1.8 1.8 0 0 0-1.98-.36 1.8 1.8 0 0 0-1.1 1.66v.17a2.1 2.1 0 0 1-4.2 0v-.09A1.8 1.8 0 0 0 8.4 19.6a1.8 1.8 0 0 0-1.98.36l-.06.06a2.1 2.1 0 0 1-2.97-2.97l.06-.06A1.8 1.8 0 0 0 3.8 15 1.8 1.8 0 0 0 2.2 13.9H2a2.1 2.1 0 0 1 0-4.2h.09A1.8 1.8 0 0 0 3.8 8.6a1.8 1.8 0 0 0-.36-1.98l-.06-.06a2.1 2.1 0 0 1 2.97-2.97l.06.06A1.8 1.8 0 0 0 8.4 4a1.8 1.8 0 0 0 1.1-1.66V2.2a2.1 2.1 0 0 1 4.2 0v.09A1.8 1.8 0 0 0 14.8 4a1.8 1.8 0 0 0 1.98-.36l.06-.06a2.1 2.1 0 0 1 2.97 2.97l-.06.06A1.8 1.8 0 0 0 19.4 8.6a1.8 1.8 0 0 0 1.66 1.1h.17a2.1 2.1 0 0 1 0 4.2h-.09A1.8 1.8 0 0 0 19.4 15Z" />
                            </svg>
                            @break
                    @endswitch
                </span>
                <span class="text-[9px] font-semibold tracking-tight leading-none truncate max-w-[60px]">
                    {{ $item['label'] }}
                </span>
            </a>
        @endforeach
    </nav>
</div>

<script>
    (function() {
        const btn = document.getElementById('mobile-theme-toggle');
        const darkIcon = document.getElementById('mobile-theme-dark-icon');
        const lightIcon = document.getElementById('mobile-theme-light-icon');

        function syncIcon() {
            if (!darkIcon || !lightIcon) return;
            if (localStorage.getItem('color-theme') === 'dark') {
                lightIcon.classList.remove('hidden');
                darkIcon.classList.add('hidden');
            } else {
                darkIcon.classList.remove('hidden');
                lightIcon.classList.add('hidden');
            }
        }

        syncIcon();

        if (btn) {
            btn.addEventListener('click', function() {
                if (localStorage.getItem('color-theme') === 'light' || !localStorage.getItem('color-theme')) {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }
                syncIcon();
            });
        }
    })();
</script>
