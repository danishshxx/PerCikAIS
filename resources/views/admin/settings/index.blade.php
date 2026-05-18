<x-layouts.admin-percikais>
    <x-slot name="title">Pengaturan Admin</x-slot>

    <section
        x-data="{
            activeTab: 'notifications',
            notifications: {
                students: localStorage.getItem('admin-notif-students') !== 'false',
                teachers: localStorage.getItem('admin-notif-teachers') !== 'false',
                attendance: localStorage.getItem('admin-notif-attendance') !== 'false',
                subjects: localStorage.getItem('admin-notif-subjects') !== 'false',
                finance: localStorage.getItem('admin-notif-finance') !== 'false',
                system: localStorage.getItem('admin-notif-system') !== 'false'
            },
            toggleNotification(key) {
                this.notifications[key] = !this.notifications[key];
                localStorage.setItem('admin-notif-' + key, this.notifications[key] ? 'true' : 'false');
            }
        }"
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
                        Pengaturan Admin
                    </h1>
                    <p class="mt-1 text-sm font-medium text-slate-400">
                        Kelola preferensi notifikasi operasional untuk panel administrator.
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-[240px_1fr]">
            <aside class="rounded-[28px] border border-slate-100 bg-white p-3 shadow-[0_14px_45px_rgba(15,23,42,0.05)] dark:border-slate-800 dark:bg-[#0F1524] xl:self-start">
                <button
                    type="button"
                    x-on:click="activeTab = 'notifications'"
                    class="accent-tint flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-sm font-bold transition"
                >
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.17V11a6 6 0 1 0-12 0v3.17a2 2 0 0 1-.6 1.43L4 17h5" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M10 20a2 2 0 0 0 4 0" />
                    </svg>
                    Notifikasi
                </button>
            </aside>

            <div
                x-show="activeTab === 'notifications'"
                x-cloak
                class="rounded-[28px] border border-slate-100 bg-white p-6 shadow-[0_18px_60px_rgba(15,23,42,0.06)] dark:border-slate-800 dark:bg-[#0F1524] md:p-8"
            >
                <div class="border-b border-slate-100 pb-6 dark:border-slate-800">
                    <h2 class="text-xl font-extrabold tracking-tight text-slate-950 dark:text-white">
                        Notifikasi Operasional Admin
                    </h2>
                    <p class="mt-2 text-sm font-medium leading-6 text-slate-400">
                        Pilih informasi admin yang ingin ditampilkan di dropdown notifikasi panel admin.
                    </p>
                </div>

                <div class="mt-7 space-y-4">
                    <div class="flex items-center justify-between gap-5 rounded-3xl border border-slate-100 bg-slate-50 p-5 dark:border-slate-800 dark:bg-[#121929]">
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-800 dark:text-white">Data Murid</h3>
                            <p class="mt-1 text-xs font-semibold text-slate-400">Info siswa baru, perubahan data, dan email siswa yang perlu dicek.</p>
                        </div>

                        <button type="button" x-on:click="toggleNotification('students')" class="relative h-7 w-12 rounded-full transition" :style="notifications.students ? 'background: var(--accent)' : ''" :class="notifications.students ? '' : 'bg-slate-300 dark:bg-slate-700'">
                            <span class="absolute top-1 h-5 w-5 rounded-full bg-white shadow transition" :class="notifications.students ? 'left-6' : 'left-1'"></span>
                        </button>
                    </div>

                    <div class="flex items-center justify-between gap-5 rounded-3xl border border-slate-100 bg-slate-50 p-5 dark:border-slate-800 dark:bg-[#121929]">
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-800 dark:text-white">Data Guru</h3>
                            <p class="mt-1 text-xs font-semibold text-slate-400">Notifikasi terkait akun guru, email guru, dan data pengajar.</p>
                        </div>

                        <button type="button" x-on:click="toggleNotification('teachers')" class="relative h-7 w-12 rounded-full transition" :style="notifications.teachers ? 'background: var(--accent)' : ''" :class="notifications.teachers ? '' : 'bg-slate-300 dark:bg-slate-700'">
                            <span class="absolute top-1 h-5 w-5 rounded-full bg-white shadow transition" :class="notifications.teachers ? 'left-6' : 'left-1'"></span>
                        </button>
                    </div>

                    <div class="flex items-center justify-between gap-5 rounded-3xl border border-slate-100 bg-slate-50 p-5 dark:border-slate-800 dark:bg-[#121929]">
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-800 dark:text-white">Absensi</h3>
                            <p class="mt-1 text-xs font-semibold text-slate-400">Ringkasan presensi harian, izin siswa, dan absensi yang perlu verifikasi.</p>
                        </div>

                        <button type="button" x-on:click="toggleNotification('attendance')" class="relative h-7 w-12 rounded-full transition" :style="notifications.attendance ? 'background: var(--accent)' : ''" :class="notifications.attendance ? '' : 'bg-slate-300 dark:bg-slate-700'">
                            <span class="absolute top-1 h-5 w-5 rounded-full bg-white shadow transition" :class="notifications.attendance ? 'left-6' : 'left-1'"></span>
                        </button>
                    </div>

                    <div class="flex items-center justify-between gap-5 rounded-3xl border border-slate-100 bg-slate-50 p-5 dark:border-slate-800 dark:bg-[#121929]">
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-800 dark:text-white">Mata Pelajaran</h3>
                            <p class="mt-1 text-xs font-semibold text-slate-400">Perubahan mapel/course dari sistem LMS atau backend akademik.</p>
                        </div>

                        <button type="button" x-on:click="toggleNotification('subjects')" class="relative h-7 w-12 rounded-full transition" :style="notifications.subjects ? 'background: var(--accent)' : ''" :class="notifications.subjects ? '' : 'bg-slate-300 dark:bg-slate-700'">
                            <span class="absolute top-1 h-5 w-5 rounded-full bg-white shadow transition" :class="notifications.subjects ? 'left-6' : 'left-1'"></span>
                        </button>
                    </div>

                    <div class="flex items-center justify-between gap-5 rounded-3xl border border-slate-100 bg-slate-50 p-5 dark:border-slate-800 dark:bg-[#121929]">
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-800 dark:text-white">Tagihan & Keuangan</h3>
                            <p class="mt-1 text-xs font-semibold text-slate-400">Pembayaran masuk, tunggakan, invoice baru, dan status Midtrans.</p>
                        </div>

                        <button type="button" x-on:click="toggleNotification('finance')" class="relative h-7 w-12 rounded-full transition" :style="notifications.finance ? 'background: var(--accent)' : ''" :class="notifications.finance ? '' : 'bg-slate-300 dark:bg-slate-700'">
                            <span class="absolute top-1 h-5 w-5 rounded-full bg-white shadow transition" :class="notifications.finance ? 'left-6' : 'left-1'"></span>
                        </button>
                    </div>

                    <div class="flex items-center justify-between gap-5 rounded-3xl border border-slate-100 bg-slate-50 p-5 dark:border-slate-800 dark:bg-[#121929]">
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-800 dark:text-white">Sistem</h3>
                            <p class="mt-1 text-xs font-semibold text-slate-400">Status integrasi LMS, Google login, dan koneksi backend Rust.</p>
                        </div>

                        <button type="button" x-on:click="toggleNotification('system')" class="relative h-7 w-12 rounded-full transition" :style="notifications.system ? 'background: var(--accent)' : ''" :class="notifications.system ? '' : 'bg-slate-300 dark:bg-slate-700'">
                            <span class="absolute top-1 h-5 w-5 rounded-full bg-white shadow transition" :class="notifications.system ? 'left-6' : 'left-1'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.admin-percikais>