<?php

use App\Models\Ebook;
use App\Models\Order;
use App\Models\User;
use Livewire\Volt\Component;

new class extends Component {
    public $totalEbooks;
    public $totalSales;
    public $totalRevenue;
    public $recentTransactions;

    public function mount()
    {
        $this->totalEbooks = Ebook::count();
        $this->totalSales = Order::whereIn('status', ['completed', 'paid', 'success'])->count();
        $this->totalRevenue = Order::whereIn('status', ['completed', 'paid', 'success'])->sum('total_amount');
        $this->recentTransactions = Order::with(['user', 'ebook', 'transaction'])
            ->latest()
            ->take(5)
            ->get();
    }
}; ?>

<div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div
            class="reveal active bg-white dark:bg-slate-900 p-6 md:p-8 rounded-[35px] shadow-sm border border-slate-100 dark:border-white/5 hover:shadow-md transition-all">
            <div class="flex items-center space-x-4 mb-4">
                <div
                    class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
                <p class="text-xs font-black uppercase tracking-widest text-slate-400">Total Pendapatan</p>
            </div>
            <h3 class="text-4xl font-black text-slate-900 dark:text-white">Rp
                {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
        </div>

        <div class="reveal active bg-white dark:bg-slate-900 p-6 md:p-8 rounded-[35px] shadow-sm border border-slate-100 dark:border-white/5 hover:shadow-md transition-all"
            style="transition-delay: 100ms">
            <div class="flex items-center space-x-4 mb-4">
                <div
                    class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 118 0m-9.172 6.172L12 18.343l-1.828-1.828m4.542-4.542L12 11.234 9.286 13.948m11.234-2.714l-2.714-2.714">
                        </path>
                    </svg>
                </div>
                <p class="text-xs font-black uppercase tracking-widest text-slate-400">Total Penjualan</p>
            </div>
            <h3 class="text-4xl font-black text-slate-900 dark:text-white">{{ $totalSales }}</h3>
        </div>

        <div class="reveal active bg-white dark:bg-slate-900 p-6 md:p-8 rounded-[35px] shadow-sm border border-slate-100 dark:border-white/5 hover:shadow-md transition-all"
            style="transition-delay: 200ms">
            <div class="flex items-center space-x-4 mb-4">
                <div
                    class="w-12 h-12 rounded-2xl bg-orange-50 dark:bg-orange-500/10 flex items-center justify-center text-orange-600 dark:text-orange-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
                <p class="text-xs font-black uppercase tracking-widest text-slate-400">E-Book Aktif</p>
            </div>
            <h3 class="text-4xl font-black text-slate-900 dark:text-white">{{ $totalEbooks }}</h3>
        </div>
    </div>

    <div id="transaksi"
        class="reveal active bg-white dark:bg-slate-900 rounded-[40px] p-6 md:p-10 shadow-sm border border-slate-100 dark:border-white/5 overflow-hidden">
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h4 class="text-2xl font-black text-slate-900 dark:text-white">Riwayat Transaksi</h4>
                <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">5 Transaksi Terakhir di Platform</p>
            </div>
            <a href="{{ route('admin.transactions') }}" class="px-5 py-2.5 rounded-xl bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 text-xs font-black uppercase tracking-widest hover:bg-indigo-100 dark:hover:bg-indigo-500/20 transition-colors">
                Lihat Semua
            </a>
        </div>

        @if ($recentTransactions->isEmpty())
            <div class="text-center py-20 bg-slate-50 dark:bg-slate-800/50 rounded-3xl border border-dashed border-slate-200 dark:border-white/5">
                <p class="text-slate-400 font-bold">Belum ada transaksi terekam.</p>
            </div>
        @else
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse min-w-[700px]">
                    <thead>
                        <tr class="border-b border-slate-100 dark:border-white/5">
                            <th class="py-4 px-4 text-xs font-black uppercase tracking-widest text-slate-400">Pengguna</th>
                            <th class="py-4 px-4 text-xs font-black uppercase tracking-widest text-slate-400">E-Book</th>
                            <th class="py-4 px-4 text-xs font-black uppercase tracking-widest text-slate-400">Tanggal</th>
                            <th class="py-4 px-4 text-xs font-black uppercase tracking-widest text-slate-400">Nominal</th>
                            <th class="py-4 px-4 text-xs font-black uppercase tracking-widest text-slate-400 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                        @foreach ($recentTransactions as $tx)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors group">
                                <td class="py-4 px-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center font-black text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-800">
                                            {{ substr($tx->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-sm text-slate-900 dark:text-white">{{ $tx->user->name }}</p>
                                            <p class="text-[10px] text-slate-500">{{ $tx->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <p class="font-bold text-sm text-slate-900 dark:text-slate-300 max-w-[200px] truncate">{{ $tx->ebook->title }}</p>
                                    <p class="text-[10px] text-slate-500 font-mono mt-1">#{{ $tx->invoice_number }}</p>
                                </td>
                                <td class="py-4 px-4">
                                    <p class="font-bold text-sm text-slate-900 dark:text-white uppercase">{{ $tx->transaction ? str_replace('_', ' ', $tx->transaction->payment_method) : '-' }}</p>
                                    <p class="text-[10px] text-slate-500">{{ $tx->created_at->format('d M Y, H:i') }}</p>
                                </td>
                                <td class="py-4 px-4">
                                    <p class="font-black text-sm text-slate-900 dark:text-white">Rp {{ number_format($tx->total_amount, 0, ',', '.') }}</p>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    @if(in_array($tx->status, ['completed', 'paid', 'success']))
                                        <span class="px-3 py-1.5 rounded-full bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-[10px] font-black uppercase tracking-widest border border-emerald-200 dark:border-emerald-800">Berhasil</span>
                                    @elseif(in_array($tx->status, ['failed', 'cancel', 'deny', 'expire']))
                                        <span class="px-3 py-1.5 rounded-full bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400 text-[10px] font-black uppercase tracking-widest border border-rose-200 dark:border-rose-800">Gagal</span>
                                    @else
                                        <span class="px-3 py-1.5 rounded-full bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 text-[10px] font-black uppercase tracking-widest border border-amber-200 dark:border-amber-800">Pending</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
