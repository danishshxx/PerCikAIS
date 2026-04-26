<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Siswa - PerCikAIS Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-[#050B14] text-gray-900 dark:text-white flex h-screen overflow-hidden transition-colors duration-300">

    <aside class="w-64 bg-white dark:bg-[#0A0F1C] border-r border-gray-200 dark:border-gray-800 flex flex-col justify-between overflow-y-auto">
        <div class="p-6">
            <div class="flex items-center justify-between mb-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center font-bold text-xl text-white shadow-lg shadow-blue-600/20">A</div>
                    <span class="text-lg font-bold tracking-wider text-gray-900 dark:text-white">Admin</span>
                </div>
                <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none rounded-lg text-sm p-2.5 transition-colors">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path></svg>
                </button>
            </div>
            
            <nav class="space-y-2 text-sm font-medium">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-[#121A2F] transition-colors">
                    Dasbor Utama
                </a>
                <a href="{{ route('admin.students') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-500 border border-blue-200 dark:border-blue-500/20 transition-colors">
                    Kelola Siswa
                </a>
                <a href="{{ route('admin.attendance') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-[#121A2F] transition-colors">
                    Input Absensi & Jadwal
                </a>
                <a href="{{ route('admin.finance') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-[#121A2F] transition-colors">
                    Kelola Tagihan (Keuangan)
                </a>
            </nav>
        </div>
        <div class="dark:bg-[#121A2F]p-6 border-t border-gray-200 dark:border-gray-800">
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-4 font-medium">Sistem Administrator</p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 py-3 rounded-xl transition-all shadow-md shadow-blue-600/20">Keluar Sistem</button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-8 overflow-y-auto">
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-xl border border-green-200 dark:bg-green-500/10 dark:text-green-400 dark:border-green-500/20 font-medium text-sm transition-colors">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-xl border border-red-200 dark:bg-red-500/10 dark:text-red-400 dark:border-red-500/20 font-medium text-sm transition-colors">
                ❌ Email sudah terdaftar atau format salah!
            </div>
        @endif

        <div class="flex justify-between items-end mb-8 transition-colors">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Data Siswa Terdaftar</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Kelola data murid yang menggunakan sistem PerCikAIS.</p>
            </div>
            <button onclick="openModal()" class="px-4 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl shadow-md shadow-blue-600/20 hover:bg-blue-700 transition">
                + Tambah Siswa
            </button>
        </div>

        <div class="bg-white dark:bg-[#0A0F1C] rounded-3xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden transition-colors">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-[#121A2F] border-b border-gray-200 dark:border-gray-800 text-xs uppercase text-gray-500 dark:text-gray-400 tracking-wider transition-colors">
                            <th class="p-4 font-semibold">No</th>
                            <th class="p-4 font-semibold">Nama Lengkap</th>
                            <th class="p-4 font-semibold">Email</th>
                            <th class="p-4 font-semibold">Bergabung</th>
                        </tr>
                    </thead> 
                    <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($students as $index => $student)
                        <tr class="hover:bg-gray-50 dark:hover:bg-[#121A2F]/50 transition-colors">
                            <td class="p-4 text-gray-500 dark:text-gray-400">{{ $index + 1 }}</td>
                            <td class="p-4 font-semibold text-gray-900 dark:text-white flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&background=2563eb&color=fff&rounded=true" alt="Avatar" class="w-8 h-8 shadow-inner rounded-full">
                                {{ $student->name }}
                            </td>
                            <td class="p-4 text-gray-600 dark:text-gray-300">{{ $student->email }}</td>
                            <td class="p-4 text-gray-500 dark:text-gray-400">{{ $student->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-gray-500 dark:text-gray-400">Belum ada data siswa.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div id="addStudentModal" class="fixed inset-0 z-50 bg-gray-900/60 dark:bg-[#050B14]/80 backdrop-blur-sm hidden items-center justify-center transition-all duration-300 opacity-0">
        <div class="bg-white dark:bg-[#0A0F1C] border border-gray-200 dark:border-gray-800 rounded-3xl shadow-2xl w-full max-w-md mx-4 overflow-hidden transform scale-95 transition-all duration-300" id="modalContent">
            <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center bg-gray-50 dark:bg-[#121A2F] transition-colors"">
                <h3 class="font-bold text-lg text-gray-900 dark:text-white">Daftarkan Siswa Baru</h3>
                <button onclick="closeModal()" class="text-gray-400 dark:text-gray-500 hover:text-red-500 dark:hover:text-red-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form action="{{ route('admin.students.store') }}" method="POST" class="p-6 space-y-5 transition-colors">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap Siswa</label>
                    <input type="text" name="name" required placeholder="Cth: Budi Santoso" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-[#050B14] dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Google Workspace</label>
                    <input type="email" name="email" required placeholder="Cth: budi@percik.sch.id" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-[#050B14] dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>

                <div class="pt-2 flex gap-3">
                    <button type="button" onclick="closeModal()" class="flex-1 px-4 py-3 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-semibold rounded-xl hover:bg-gray-200 dark:hover:bg-gray-700 transition">Batal</button>
                    <button type="submit" class="flex-1 px-4 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 shadow-md shadow-blue-600/20 transition">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Modal Logic
        const modal = document.getElementById('addStudentModal');
        const modalContent = document.getElementById('modalContent');
        function openModal() { modal.classList.remove('hidden'); modal.classList.add('flex'); setTimeout(() => { modal.classList.remove('opacity-0'); modalContent.classList.remove('scale-95'); }, 10); }
        function closeModal() { modal.classList.add('opacity-0'); modalContent.classList.add('scale-95'); setTimeout(() => { modal.classList.remove('flex'); modal.classList.add('hidden'); }, 300); }

        // Dark Mode Logic
        var themeToggleBtn = document.getElementById('theme-toggle');
        var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) { themeToggleLightIcon.classList.remove('hidden'); } else { themeToggleDarkIcon.classList.remove('hidden'); }
        themeToggleBtn.addEventListener('click', function() { themeToggleDarkIcon.classList.toggle('hidden'); themeToggleLightIcon.classList.toggle('hidden'); if (localStorage.getItem('color-theme')) { if (localStorage.getItem('color-theme') === 'light') { document.documentElement.classList.add('dark'); localStorage.setItem('color-theme', 'dark'); } else { document.documentElement.classList.remove('dark'); localStorage.setItem('color-theme', 'light'); } } else { if (document.documentElement.classList.contains('dark')) { document.documentElement.classList.remove('dark'); localStorage.setItem('color-theme', 'light'); } else { document.documentElement.classList.add('dark'); localStorage.setItem('color-theme', 'dark'); } } });
    </script>
</body>
</html>