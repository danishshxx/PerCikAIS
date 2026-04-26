<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Keuangan - PerCikAIS Admin</title>
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

    <aside class="w-64 bg-white dark:bg-[#0A0F1C] border-r border-gray-200 dark:border-gray-800 flex flex-col justify-between overflow-y-auto transition-colors">
        <div class="p-6">
            <div class="flex items-center justify-between mb-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center font-bold text-xl text-white shadow-lg shadow-blue-600/20">A</div>
                    <span class="text-lg font-bold tracking-wider text-gray-900 dark:text-white">Admin</span>
                </div>
                <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg text-sm p-2.5 transition-colors">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path></svg>
                </button>
            </div>
            
            <nav class="space-y-2 text-sm font-medium">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-[#121A2F] transition-colors">Dasbor Utama</a>
                <a href="{{ route('admin.students') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-[#121A2F] transition-colors">Kelola Siswa</a>
                <a href="{{ route('admin.attendance') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-[#121A2F] transition-colors">Input Absensi & Jadwal</a>
                <a href="{{ route('admin.finance') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-500 border border-blue-200 dark:border-blue-500/20 transition-colors">Kelola Tagihan (Keuangan)</a>
            </nav>
        </div>
        <div class="p-6 border-t border-gray-200 dark:border-gray-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 py-3 rounded-xl transition-all shadow-md shadow-blue-600/20">Keluar Sistem</button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-8 overflow-y-auto transition-colors">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Kelola Tagihan Siswa</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Buat tagihan baru dan pantau riwayat pembayaran administrasi.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 text-green-700 dark:bg-green-500/10 dark:text-green-400 dark:border-green-500/20 rounded-xl border border-green-200 font-medium text-sm transition-colors">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1 bg-white dark:bg-[#0A0F1C] p-6 rounded-3xl border border-gray-200 dark:border-gray-800 shadow-sm h-fit transition-colors overflow-hidden">
                <h2 class="font-bold text-gray-900 dark:text-white mb-6 border-b dark:border-gray-800 pb-3 tracking-wide">Buat Tagihan Baru</h2>
                
                <form action="{{ route('admin.finance.store') }}" method="POST" class="space-y-5 transition-colors">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kirim Ke (Siswa)</label>
                        <select name="user_id" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-[#050B14] dark:text-white focus:border-blue-500 focus:ring-blue-500 text-sm shadow-sm transition-colors">
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi Tagihan</label>
                        <input type="text" name="description" required placeholder="Cth: SPP Bulan Juni 2026" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-[#050B14] dark:text-white focus:border-blue-500 focus:ring-blue-500 text-sm shadow-sm transition-colors">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nominal (Rp)</label>
                        <input type="number" name="amount" required placeholder="Cth: 1500000" min="1000" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-[#050B14] dark:text-white focus:border-blue-500 focus:ring-blue-500 text-sm shadow-sm transition-colors">
                    </div>

                    <button type="submit" class="w-full mt-4 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-blue-600/20 transition-all tracking-wide">
                        Kirim Tagihan
                    </button>
                </form>
            </div>

            <div class="lg:col-span-2 bg-white dark:bg-[#0A0F1C] p-6 rounded-3xl border border-gray-200 dark:border-gray-800 shadow-sm transition-colors overflow-hidden">
                <h2 class="font-bold text-gray-900 dark:text-white mb-6 border-b dark:border-gray-800 pb-3 tracking-wide">Riwayat Seluruh Tagihan</h2>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-xs uppercase text-gray-400 dark:text-gray-500 border-b dark:border-gray-800 tracking-wider">
                                <th class="pb-3 font-semibold">Siswa</th>
                                <th class="pb-3 font-semibold">Deskripsi</th>
                                <th class="pb-3 font-semibold">Nominal</th>
                                <th class="pb-3 font-semibold text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800 transition-colors overflow-hidden">
                            @forelse($invoices as $invoice)
                            <tr class="hover:bg-gray-50 dark:hover:bg-[#121A2F]/50 transition-colors overflow-hidden rounded-xl">
                                <td class="py-4 font-semibold text-gray-900 dark:text-white flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($invoice->user ? $invoice->user->name : 'S') }}&background=2563eb&color=fff&rounded=true" alt="Avatar" class="w-8 h-8 rounded-full shadow-inner">
                                    {{ $invoice->user ? $invoice->user->name : 'Siswa Dihapus' }}
                                </td>
                                <td class="py-4 text-gray-500 dark:text-gray-400">{{ $invoice->description }}</td>
                                <td class="py-4 font-bold text-gray-900 dark:text-white transition-colors">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</td>
                                <td class="py-4 text-center transition-colors">
                                    @if($invoice->status == 'paid')
                                        <span class="text-xs font-bold px-3 py-1.5 bg-green-100 text-green-700 dark:bg-green-500/10 dark:text-green-400 rounded-md uppercase tracking-wider transition-colors">Lunas</span>
                                    @else
                                        <span class="text-xs font-bold px-3 py-1.5 bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400 rounded-md uppercase tracking-wider transition-colors">Pending</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-500 dark:text-gray-400 transition-colors">Belum ada data tagihan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <script>
        var themeToggleBtn = document.getElementById('theme-toggle');
        var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) { themeToggleLightIcon.classList.remove('hidden'); } else { themeToggleDarkIcon.classList.remove('hidden'); }
        themeToggleBtn.addEventListener('click', function() { themeToggleDarkIcon.classList.toggle('hidden'); themeToggleLightIcon.classList.toggle('hidden'); if (localStorage.getItem('color-theme')) { if (localStorage.getItem('color-theme') === 'light') { document.documentElement.classList.add('dark'); localStorage.setItem('color-theme', 'dark'); } else { document.documentElement.classList.remove('dark'); localStorage.setItem('color-theme', 'light'); } } else { if (document.documentElement.classList.contains('dark')) { document.documentElement.classList.remove('dark'); localStorage.setItem('color-theme', 'light'); } else { document.documentElement.classList.add('dark'); localStorage.setItem('color-theme', 'dark'); } } });
    </script>
</body>
</html>