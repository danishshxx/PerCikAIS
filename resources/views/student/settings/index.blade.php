<x-layouts.app-percikais>
    <x-slot name="title">Pengaturan Akun</x-slot>

    <style>
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
    </style>

    <section
        x-data="{
            activeTab: 'appearance',
            selectedTheme: localStorage.getItem('color-theme') || 'light',
            accentColor: localStorage.getItem('accent-color') || 'blue',

            accents: {
                blue: {
                    accent: '#3B82F6',
                    text: '#2563EB',
                    tint: '#EFF6FF',
                    darkTint: 'rgba(59, 130, 246, 0.12)',
                    border: 'rgba(59, 130, 246, 0.26)',
                    ring: 'rgba(59, 130, 246, 0.16)'
                },
                violet: {
                    accent: '#8B5CF6',
                    text: '#7C3AED',
                    tint: '#F5F3FF',
                    darkTint: 'rgba(139, 92, 246, 0.12)',
                    border: 'rgba(139, 92, 246, 0.26)',
                    ring: 'rgba(139, 92, 246, 0.16)'
                },
                indigo: {
                    accent: '#6366F1',
                    text: '#4F46E5',
                    tint: '#EEF2FF',
                    darkTint: 'rgba(99, 102, 241, 0.12)',
                    border: 'rgba(99, 102, 241, 0.26)',
                    ring: 'rgba(99, 102, 241, 0.16)'
                },
                cyan: {
                    accent: '#06B6D4',
                    text: '#0891B2',
                    tint: '#ECFEFF',
                    darkTint: 'rgba(6, 182, 212, 0.12)',
                    border: 'rgba(6, 182, 212, 0.26)',
                    ring: 'rgba(6, 182, 212, 0.16)'
                },
                emerald: {
                    accent: '#10B981',
                    text: '#059669',
                    tint: '#ECFDF5',
                    darkTint: 'rgba(16, 185, 129, 0.12)',
                    border: 'rgba(16, 185, 129, 0.26)',
                    ring: 'rgba(16, 185, 129, 0.16)'
                },
                teal: {
                    accent: '#14B8A6',
                    text: '#0D9488',
                    tint: '#F0FDFA',
                    darkTint: 'rgba(20, 184, 166, 0.12)',
                    border: 'rgba(20, 184, 166, 0.26)',
                    ring: 'rgba(20, 184, 166, 0.16)'
                },
                amber: {
                    accent: '#F59E0B',
                    text: '#D97706',
                    tint: '#FFFBEB',
                    darkTint: 'rgba(245, 158, 11, 0.12)',
                    border: 'rgba(245, 158, 11, 0.26)',
                    ring: 'rgba(245, 158, 11, 0.16)'
                },
                rose: {
                    accent: '#F43F5E',
                    text: '#E11D48',
                    tint: '#FFF1F2',
                    darkTint: 'rgba(244, 63, 94, 0.12)',
                    border: 'rgba(244, 63, 94, 0.26)',
                    ring: 'rgba(244, 63, 94, 0.16)'
                },
                slate: {
                    accent: '#64748B',
                    text: '#475569',
                    tint: '#F1F5F9',
                    darkTint: 'rgba(100, 116, 139, 0.16)',
                    border: 'rgba(100, 116, 139, 0.26)',
                    ring: 'rgba(100, 116, 139, 0.16)'
                }
            },

            notifications: {
                schedule: localStorage.getItem('notif-schedule') !== 'false',
                finance: localStorage.getItem('notif-finance') !== 'false',
                profile: localStorage.getItem('notif-profile') !== 'false',
                push: localStorage.getItem('notif-push') !== 'false'
            },

            isDarkMode() {
                return document.documentElement.classList.contains('dark');
            },

            applyAccent(color) {
                const selected = this.accents[color] || this.accents.blue;
                const root = document.documentElement;
                const useDarkTint = this.isDarkMode();

                root.style.setProperty('--accent', selected.accent);
                root.style.setProperty('--accent-text', useDarkTint ? selected.accent : selected.text);
                root.style.setProperty('--accent-tint', useDarkTint ? selected.darkTint : selected.tint);
                root.style.setProperty('--accent-border', selected.border);
                root.style.setProperty('--accent-ring', selected.ring);
                root.dataset.accent = color;
            },

            setAccent(color) {
                this.accentColor = color;
                localStorage.setItem('accent-color', color);
                this.applyAccent(color);
            },

            setTheme(theme) {
                this.selectedTheme = theme;

                if (theme === 'dark') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else if (theme === 'light') {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                    if (prefersDark) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }

                    localStorage.setItem('color-theme', 'system');
                }

                this.applyAccent(this.accentColor);
            },

            toggleNotification(key) {
                this.notifications[key] = !this.notifications[key];
                localStorage.setItem('notif-' + key, this.notifications[key] ? 'true' : 'false');
            }
        }"
        x-init="applyAccent(accentColor)"
        class="space-y-7"
    >
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="flex items-center gap-4">
                <div class="accent-tint flex h-14 w-14 items-center justify-center rounded-2xl shadow-sm">
                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M19.4 15a1.8 1.8 0 0 0 .36 1.98l.06.06a2.1 2.1 0 0 1-2.97 2.97l-.06-.06a1.8 1.8 0 0 0-1.98-.36 1.8 1.8 0 0 0-1.1 1.66v.17a2.1 2.1 0 0 1-4.2 0v-.09A1.8 1.8 0 0 0 8.4 19.6a1.8 1.8 0 0 0-1.98.36l-.06.06a2.1 2.1 0 0 1-2.97-2.97l.06-.06A1.8 1.8 0 0 0 3.8 15 1.8 1.8 0 0 0 2.2 13.9H2a2.1 2.1 0 0 1 0-4.2h.09A1.8 1.8 0 0 0 3.8 8.6a1.8 1.8 0 0 0-.36-1.98l-.06-.06a2.1 2.1 0 0 1 2.97-2.97l.06.06A1.8 1.8 0 0 0 8.4 4a1.8 1.8 0 0 0 1.1-1.66V2.2a2.1 2.1 0 0 1 4.2 0v.09A1.8 1.8 0 0 0 14.8 4a1.8 1.8 0 0 0 1.98-.36l.06-.06a2.1 2.1 0 0 1 2.97 2.97l-.06.06A1.8 1.8 0 0 0 19.4 8.6a1.8 1.8 0 0 0 1.66 1.1h.17a2.1 2.1 0 0 1 0 4.2h-.09A1.8 1.8 0 0 0 19.4 15Z" />
                    </svg>
                </div>

                <div>
                    <h1 class="text-2xl font-extrabold tracking-tight text-slate-950 dark:text-white">
                        Pengaturan Akun
                    </h1>
                    <p class="mt-1 text-sm font-medium text-slate-400">
                        Kelola preferensi tampilan dan notifikasi akun siswa.
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-[240px_1fr]">
            <aside class="rounded-[28px] border border-slate-100 bg-white p-3 shadow-[0_14px_45px_rgba(15,23,42,0.05)] dark:border-slate-800 dark:bg-[#0F1524] xl:self-start">
                <button
                    type="button"
                    x-on:click="activeTab = 'appearance'"
                    class="flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-sm font-bold transition"
                    :class="activeTab === 'appearance'
                        ? 'accent-tint'
                        : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-white'"
                >
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M12 3v3M12 18v3M4.22 4.22l2.12 2.12M17.66 17.66l2.12 2.12M3 12h3M18 12h3M4.22 19.78l2.12-2.12M17.66 6.34l2.12-2.12" />
                    </svg>
                    Tampilan
                </button>

                <button
                    type="button"
                    x-on:click="activeTab = 'notifications'"
                    class="mt-1 flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-sm font-bold transition"
                    :class="activeTab === 'notifications'
                        ? 'accent-tint'
                        : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-white'"
                >
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.17V11a6 6 0 1 0-12 0v3.17a2 2 0 0 1-.6 1.43L4 17h5" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M10 20a2 2 0 0 0 4 0" />
                    </svg>
                    Notifikasi
                </button>
            </aside>

            <div>
                <div
                    x-show="activeTab === 'appearance'"
                    x-cloak
                    class="rounded-[28px] border border-slate-100 bg-white p-6 shadow-[0_18px_60px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524] md:p-8"
                >
                    <div class="border-b border-slate-100 pb-6 dark:border-slate-800">
                        <h2 class="text-xl font-extrabold tracking-tight text-slate-950 dark:text-white">
                            Tampilan
                        </h2>
                        <p class="mt-2 text-sm font-medium leading-6 text-slate-400">
                            Atur tema dan warna aksen yang nyaman untuk kamu.
                        </p>
                    </div>

                    <div class="mt-7 space-y-8">
                        <div>
                            <h3 class="text-base font-extrabold text-slate-800 dark:text-white">
                                Tema Tampilan
                            </h3>
                            <p class="mt-1 text-sm font-medium text-slate-400">
                                Pilih tema yang nyaman untuk digunakan.
                            </p>

                            <div class="mt-5 grid grid-cols-1 gap-4 md:grid-cols-3">
                                <button
                                    type="button"
                                    x-on:click="setTheme('light')"
                                    class="rounded-2xl border p-5 text-center transition"
                                    :class="selectedTheme === 'light'
                                        ? 'accent-border accent-tint'
                                        : 'border-slate-200 bg-white text-slate-500 hover:border-slate-300 dark:border-slate-800 dark:bg-[#121929] dark:text-slate-300'"
                                >
                                    <svg class="mx-auto h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M12 4V2M12 22v-2M4 12H2M22 12h-2M5.64 5.64 4.22 4.22M19.78 19.78l-1.42-1.42M18.36 5.64l1.42-1.42M4.22 19.78l1.42-1.42M12 16a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" />
                                    </svg>
                                    <span class="mt-3 block text-sm font-extrabold">Terang</span>
                                </button>

                                <button
                                    type="button"
                                    x-on:click="setTheme('dark')"
                                    class="rounded-2xl border p-5 text-center transition"
                                    :class="selectedTheme === 'dark'
                                        ? 'accent-border accent-tint'
                                        : 'border-slate-200 bg-white text-slate-500 hover:border-slate-300 dark:border-slate-800 dark:bg-[#121929] dark:text-slate-300'"
                                >
                                    <svg class="mx-auto h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M21 14.2A8.5 8.5 0 0 1 9.8 3 7 7 0 1 0 21 14.2Z" />
                                    </svg>
                                    <span class="mt-3 block text-sm font-extrabold">Gelap</span>
                                </button>

                                <button
                                    type="button"
                                    x-on:click="setTheme('system')"
                                    class="rounded-2xl border p-5 text-center transition"
                                    :class="selectedTheme === 'system'
                                        ? 'accent-border accent-tint'
                                        : 'border-slate-200 bg-white text-slate-500 hover:border-slate-300 dark:border-slate-800 dark:bg-[#121929] dark:text-slate-300'"
                                >
                                    <svg class="mx-auto h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M4 5.5A2.5 2.5 0 0 1 6.5 3h11A2.5 2.5 0 0 1 20 5.5v8A2.5 2.5 0 0 1 17.5 16h-11A2.5 2.5 0 0 1 4 13.5v-8Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M8 21h8M12 16v5" />
                                    </svg>
                                    <span class="mt-3 block text-sm font-extrabold">Sistem</span>
                                </button>
                            </div>
                        </div>

                        <div class="border-t border-slate-100 pt-7 dark:border-slate-800">
                            <h3 class="text-base font-extrabold text-slate-800 dark:text-white">
                                Warna Aksen
                            </h3>
                            <p class="mt-1 text-sm font-medium text-slate-400">
                                Pilih warna utama untuk tombol, link, dan elemen aktif.
                            </p>

                            <div class="mt-5 rounded-3xl border border-slate-100 bg-slate-50 p-5 dark:border-slate-800 dark:bg-[#121929]">
                                <p class="mb-4 text-xs font-extrabold uppercase tracking-widest text-slate-400">
                                    Preview
                                </p>

                                <div class="flex flex-wrap items-center gap-3">
                                    <button type="button" class="accent-bg rounded-2xl px-5 py-3 text-sm font-extrabold shadow-lg transition hover:opacity-90">
                                        Tombol Utama
                                    </button>

                                    <span class="accent-text text-sm font-bold">
                                        Link Aktif
                                    </span>

                                    <span class="accent-tint rounded-xl px-3 py-1.5 text-xs font-extrabold">
                                        Badge Kelas
                                    </span>

                                    <span class="h-4 w-4 rounded-full" style="background: var(--accent)"></span>
                                </div>
                            </div>

                            <div class="mt-5 grid grid-cols-3 gap-4 sm:grid-cols-5 lg:grid-cols-8">
                                @php
                                    $colors = [
                                        ['key' => 'blue', 'label' => 'Biru', 'class' => 'bg-blue-500'],
                                        ['key' => 'violet', 'label' => 'Ungu', 'class' => 'bg-violet-500'],
                                        ['key' => 'indigo', 'label' => 'Indigo', 'class' => 'bg-indigo-500'],
                                        ['key' => 'cyan', 'label' => 'Cyan', 'class' => 'bg-cyan-500'],
                                        ['key' => 'emerald', 'label' => 'Hijau', 'class' => 'bg-emerald-500'],
                                        ['key' => 'teal', 'label' => 'Toska', 'class' => 'bg-teal-500'],
                                        ['key' => 'amber', 'label' => 'Kuning', 'class' => 'bg-amber-500'],
                                        ['key' => 'rose', 'label' => 'Merah', 'class' => 'bg-rose-500'],
                                        ['key' => 'slate', 'label' => 'Slate', 'class' => 'bg-slate-500'],
                                    ];
                                @endphp

                                @foreach ($colors as $color)
                                    <button
                                        type="button"
                                        x-on:click="setAccent('{{ $color['key'] }}')"
                                        class="rounded-2xl border p-3 text-center transition"
                                        :class="accentColor === '{{ $color['key'] }}'
                                            ? 'accent-border accent-tint'
                                            : 'border-transparent hover:bg-slate-50 dark:hover:bg-slate-800'"
                                    >
                                        <span class="mx-auto flex h-9 w-9 items-center justify-center rounded-full {{ $color['class'] }}">
                                            <svg
                                                x-show="accentColor === '{{ $color['key'] }}'"
                                                x-cloak
                                                class="h-5 w-5 text-white"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                            >
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="m5 12 4 4L19 6" />
                                            </svg>
                                        </span>

                                        <span class="mt-2 block text-xs font-bold text-slate-500 dark:text-slate-400">
                                            {{ $color['label'] }}
                                        </span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    x-show="activeTab === 'notifications'"
                    x-cloak
                    class="rounded-[28px] border border-slate-100 bg-white p-6 shadow-[0_18px_60px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524] md:p-8"
                >
                    <div class="border-b border-slate-100 pb-6 dark:border-slate-800">
                        <h2 class="text-xl font-extrabold tracking-tight text-slate-950 dark:text-white">
                            Notifikasi
                        </h2>
                        <p class="mt-2 text-sm font-medium leading-6 text-slate-400">
                            Atur informasi apa saja yang ingin kamu tampilkan di aplikasi.
                        </p>
                    </div>

                    <div class="mt-7 space-y-4">
                        <div class="flex items-center justify-between gap-5 rounded-3xl border border-slate-100 bg-slate-50 p-5 dark:border-slate-800 dark:bg-[#121929]">
                            <div>
                                <h3 class="text-sm font-extrabold text-slate-800 dark:text-white">Jadwal Belajar</h3>
                                <p class="mt-1 text-xs font-semibold text-slate-400">Notifikasi jadwal dan presensi harian.</p>
                            </div>

                            <button
                                type="button"
                                x-on:click="toggleNotification('schedule')"
                                class="relative h-7 w-12 rounded-full transition"
                                :style="notifications.schedule ? 'background: var(--accent)' : ''"
                                :class="notifications.schedule ? '' : 'bg-slate-300 dark:bg-slate-700'"
                            >
                                <span
                                    class="absolute top-1 h-5 w-5 rounded-full bg-white shadow transition"
                                    :class="notifications.schedule ? 'left-6' : 'left-1'"
                                ></span>
                            </button>
                        </div>

                        <div class="flex items-center justify-between gap-5 rounded-3xl border border-slate-100 bg-slate-50 p-5 dark:border-slate-800 dark:bg-[#121929]">
                            <div>
                                <h3 class="text-sm font-extrabold text-slate-800 dark:text-white">Administrasi SPP</h3>
                                <p class="mt-1 text-xs font-semibold text-slate-400">Informasi tagihan dan pembayaran.</p>
                            </div>

                            <button
                                type="button"
                                x-on:click="toggleNotification('finance')"
                                class="relative h-7 w-12 rounded-full transition"
                                :style="notifications.finance ? 'background: var(--accent)' : ''"
                                :class="notifications.finance ? '' : 'bg-slate-300 dark:bg-slate-700'"
                            >
                                <span
                                    class="absolute top-1 h-5 w-5 rounded-full bg-white shadow transition"
                                    :class="notifications.finance ? 'left-6' : 'left-1'"
                                ></span>
                            </button>
                        </div>

                        <div class="flex items-center justify-between gap-5 rounded-3xl border border-slate-100 bg-slate-50 p-5 dark:border-slate-800 dark:bg-[#121929]">
                            <div>
                                <h3 class="text-sm font-extrabold text-slate-800 dark:text-white">Biodata Profil</h3>
                                <p class="mt-1 text-xs font-semibold text-slate-400">Pengingat untuk melengkapi data profil.</p>
                            </div>

                            <button
                                type="button"
                                x-on:click="toggleNotification('profile')"
                                class="relative h-7 w-12 rounded-full transition"
                                :style="notifications.profile ? 'background: var(--accent)' : ''"
                                :class="notifications.profile ? '' : 'bg-slate-300 dark:bg-slate-700'"
                            >
                                <span
                                    class="absolute top-1 h-5 w-5 rounded-full bg-white shadow transition"
                                    :class="notifications.profile ? 'left-6' : 'left-1'"
                                ></span>
                            </button>
                        </div>

                        <div class="flex items-center justify-between gap-5 rounded-3xl border border-slate-100 bg-slate-50 p-5 dark:border-slate-800 dark:bg-[#121929]">
                            <div>
                                <h3 class="text-sm font-extrabold text-slate-800 dark:text-white">Notifikasi Aplikasi</h3>
                                <p class="mt-1 text-xs font-semibold text-slate-400">Tampilkan notifikasi di dalam PerCikAIS.</p>
                            </div>

                            <button
                                type="button"
                                x-on:click="toggleNotification('push')"
                                class="relative h-7 w-12 rounded-full transition"
                                :style="notifications.push ? 'background: var(--accent)' : ''"
                                :class="notifications.push ? '' : 'bg-slate-300 dark:bg-slate-700'"
                            >
                                <span
                                    class="absolute top-1 h-5 w-5 rounded-full bg-white shadow transition"
                                    :class="notifications.push ? 'left-6' : 'left-1'"
                                ></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app-percikais>