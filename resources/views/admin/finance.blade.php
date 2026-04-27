<x-layouts.admin-percikais>
    <x-slot name="title">Kelola SPP - PerCikAIS</x-slot>

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Manajemen Keuangan Murid</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Terbitkan tagihan SPP bulanan atau administrasi lainnya secara massal.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 text-green-700 dark:bg-green-500/10 dark:text-green-400 dark:border-green-500/20 rounded-xl border border-green-200 font-medium text-sm transition-colors">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1 bg-white dark:bg-[#0A0F1C] p-6 rounded-3xl border border-gray-200 dark:border-gray-800 shadow-sm h-fit transition-colors overflow-hidden">
            <h2 class="font-bold text-gray-900 dark:text-white mb-6 border-b dark:border-gray-800 pb-3 tracking-wide">Terbitkan Tagihan Baru</h2>
            
            <form action="{{ route('admin.finance.store') }}" method="POST" class="space-y-5 transition-colors">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pilih Murid</label>
                    <select name="user_id" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-[#050B14] dark:text-white focus:border-blue-500 focus:ring-blue-500 text-sm shadow-sm transition-colors">
                        <option value="">-- Pilih Nama Murid --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Keterangan Pembayaran</label>
                    <input type="text" name="description" required placeholder="Cth: SPP Bulan Juli 2026" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-[#050B14] dark:text-white focus:border-blue-500 focus:ring-blue-500 text-sm shadow-sm transition-colors">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nominal (Rp)</label>
                    <input type="number" name="amount" required placeholder="Cth: 750000" min="1000" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-[#050B14] dark:text-white focus:border-blue-500 focus:ring-blue-500 text-sm shadow-sm transition-colors">
                </div>

                <button type="submit" class="w-full mt-4 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-blue-600/20 transition-all tracking-wide">
                    Kirim Tagihan Ke Murid
                </button>
            </form>
        </div>

        <div class="lg:col-span-2 bg-white dark:bg-[#0A0F1C] p-6 rounded-3xl border border-gray-200 dark:border-gray-800 shadow-sm transition-colors overflow-hidden">
            <h2 class="font-bold text-gray-900 dark:text-white mb-6 border-b dark:border-gray-800 pb-3 tracking-wide">Riwayat Seluruh Transaksi</h2>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-xs uppercase text-gray-400 dark:text-gray-500 border-b dark:border-gray-800 tracking-wider">
                            <th class="pb-3 font-semibold">Nama Murid</th>
                            <th class="pb-3 font-semibold hidden sm:table-cell">Keterangan</th>
                            <th class="pb-3 font-semibold">Nominal</th>
                            <th class="pb-3 font-semibold text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800 transition-colors overflow-hidden">
                        @forelse($invoices as $invoice)
                        <tr class="hover:bg-gray-50 dark:hover:bg-[#121A2F]/50 transition-colors overflow-hidden rounded-xl">
                            <td class="py-4 font-semibold text-gray-900 dark:text-white flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($invoice->user ? $invoice->user->name : 'M') }}&background=2563eb&color=fff&rounded=true" alt="Avatar" class="w-8 h-8 rounded-full shadow-inner">
                                <div class="flex flex-col">
                                    <span>{{ $invoice->user ? $invoice->user->name : 'Data Murid Dihapus' }}</span>
                                    <span class="text-[10px] text-gray-500 sm:hidden">{{ $invoice->description }}</span>
                                </div>
                            </td>
                            <td class="py-4 text-gray-500 dark:text-gray-400 hidden sm:table-cell">{{ $invoice->description }}</td>
                            <td class="py-4 font-bold text-gray-900 dark:text-white transition-colors">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</td>
                            <td class="py-4 text-center transition-colors">
                                @if($invoice->status == 'paid')
                                    <span class="text-[10px] sm:text-xs font-bold px-2 py-1 sm:px-3 sm:py-1.5 bg-green-100 text-green-700 dark:bg-green-500/10 dark:text-green-400 rounded-md uppercase tracking-wider transition-colors">Lunas</span>
                                @else
                                    <span class="text-[10px] sm:text-xs font-bold px-2 py-1 sm:px-3 sm:py-1.5 bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400 rounded-md uppercase tracking-wider transition-colors">Menunggu</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-gray-500 dark:text-gray-400 transition-colors">Belum ada data tagihan yang diterbitkan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.admin-percikais>
