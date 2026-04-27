<x-layouts.admin-percikais>
    <x-slot name="title">Manajemen Guru - PerCikAIS</x-slot>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-xl border border-green-200 dark:bg-green-500/10 dark:text-green-400 dark:border-green-500/20 font-medium text-sm transition-colors">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-xl border border-red-200 dark:bg-red-500/10 dark:text-red-400 dark:border-red-500/20 font-medium text-sm transition-colors">
            ❌ Gagal! Email mungkin sudah digunakan.
        </div>
    @endif

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-8 transition-colors gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Data Tenaga Pengajar</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kelola akun akses khusus untuk Guru/Staf Pengajar.</p>
        </div>
        <button onclick="openModal()" class="w-full sm:w-auto px-4 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl shadow-md shadow-blue-600/20 hover:bg-blue-700 transition">
            + Tambah Guru Baru
        </button>
    </div>

    <div class="bg-white dark:bg-[#0A0F1C] rounded-3xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden transition-colors">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 dark:bg-[#121A2F] border-b border-gray-200 dark:border-gray-800 text-xs uppercase text-gray-500 dark:text-gray-400 tracking-wider transition-colors">
                        <th class="p-4 font-semibold">No</th>
                        <th class="p-4 font-semibold">Nama Guru</th>
                        <th class="p-4 font-semibold hidden md:table-cell">Email Akun</th>
                        <th class="p-4 font-semibold hidden sm:table-cell">Status</th>
                    </tr>
                </thead> 
                <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($teachers as $index => $teacher)
                    <tr class="hover:bg-gray-50 dark:hover:bg-[#121A2F]/50 transition-colors">
                        <td class="p-4 text-gray-500 dark:text-gray-400">{{ $index + 1 }}</td>
                        <td class="p-4 font-semibold text-gray-900 dark:text-white">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($teacher->name) }}&background=059669&color=fff&rounded=true" alt="Avatar" class="w-8 h-8 shadow-inner rounded-full">
                                <div class="flex flex-col">
                                    <span>{{ $teacher->name }}</span>
                                    <span class="text-[10px] text-gray-500 md:hidden">{{ $teacher->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 text-gray-600 dark:text-gray-300 hidden md:table-cell">{{ $teacher->email }}</td>
                        <td class="p-4 hidden sm:table-cell">
                            <span class="text-[10px] font-bold px-2 py-1 bg-green-100 text-green-700 dark:bg-green-500/10 dark:text-green-400 rounded-md uppercase">Tenaga Pengajar</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-gray-500 dark:text-gray-400">Belum ada data guru yang terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah Guru -->
    <div id="addTeacherModal" class="fixed inset-0 z-[60] bg-gray-900/60 dark:bg-[#050B14]/80 backdrop-blur-sm hidden items-center justify-center transition-all duration-300 opacity-0">
        <div class="bg-white dark:bg-[#0A0F1C] border border-gray-200 dark:border-gray-800 rounded-3xl shadow-2xl w-full max-w-md mx-4 overflow-hidden transform scale-95 transition-all duration-300" id="modalContent">
            <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center bg-gray-50 dark:bg-[#121A2F] transition-colors">
                <h3 class="font-bold text-lg text-gray-900 dark:text-white">Pendaftaran Guru Baru</h3>
                <button onclick="closeModal()" class="text-gray-400 dark:text-gray-500 hover:text-red-500 dark:hover:text-red-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form action="{{ route('admin.teachers.store') }}" method="POST" class="p-6 space-y-5 transition-colors">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap & Gelar</label>
                    <input type="text" name="name" required placeholder="Cth: Budi Santoso, S.Kom." class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-[#050B14] dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Resmi (Google)</label>
                    <input type="email" name="email" required placeholder="Cth: budi@percik.sch.id" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-[#050B14] dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>

                <div class="pt-2 flex flex-col sm:flex-row gap-3">
                    <button type="button" onclick="closeModal()" class="flex-1 px-4 py-3 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-semibold rounded-xl hover:bg-gray-200 dark:hover:bg-gray-700 transition">Batal</button>
                    <button type="submit" class="flex-1 px-4 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 shadow-md shadow-blue-600/20 transition">Daftarkan Akun</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        const modal = document.getElementById('addTeacherModal');
        const modalContent = document.getElementById('modalContent');
        function openModal() { modal.classList.remove('hidden'); modal.classList.add('flex'); setTimeout(() => { modal.classList.remove('opacity-0'); modalContent.classList.remove('scale-95'); }, 10); }
        function closeModal() { modal.classList.add('opacity-0'); modalContent.classList.add('scale-95'); setTimeout(() => { modal.classList.remove('flex'); modal.classList.add('hidden'); }, 300); }
    </script>
    @endpush
</x-layouts.admin-percikais>
