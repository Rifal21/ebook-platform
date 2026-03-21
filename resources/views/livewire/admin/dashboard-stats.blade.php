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
        $this->totalSales = Order::where('status', 'completed')->count();
        $this->totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        $this->recentTransactions = Order::with(['user', 'ebook'])
            ->latest()
            ->take(5)
            ->get();
    }
}; ?>

<div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div
            class="reveal active bg-white dark:bg-slate-900 p-8 rounded-[35px] shadow-sm border border-slate-100 dark:border-white/5 hover:shadow-md transition-all">
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

        <div class="reveal active bg-white dark:bg-slate-900 p-8 rounded-[35px] shadow-sm border border-slate-100 dark:border-white/5 hover:shadow-md transition-all"
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

        <div class="reveal active bg-white dark:bg-slate-900 p-8 rounded-[35px] shadow-sm border border-slate-100 dark:border-white/5 hover:shadow-md transition-all"
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

    <div
        class="reveal active bg-white dark:bg-slate-900 rounded-[40px] p-10 shadow-sm border border-slate-100 dark:border-white/5 overflow-hidden">
        <h4 class="text-2xl font-black text-slate-900 dark:text-white mb-10">Transaksi Terbaru</h4>
        @if ($recentTransactions->isEmpty())
            <div
                class="text-center py-20 bg-slate-50 dark:bg-slate-800/50 rounded-3xl border border-dashed border-slate-200 dark:border-white/5">
                <p class="text-slate-400 font-bold">Belum ada transaksi terekam.</p>
            </div>
        @else
            <div class="space-y-6">
                @foreach ($recentTransactions as $tx)
                    <div
                        class="flex justify-between items-center p-6 rounded-3xl bg-slate-50 dark:bg-slate-800/50 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all border border-transparent hover:border-slate-200 dark:hover:border-white/10 group">
                        <div class="flex items-center space-x-6">
                            <div
                                class="w-14 h-14 rounded-2xl bg-white dark:bg-slate-900 flex items-center justify-center font-black dark:text-white border border-slate-200 dark:border-white/5">
                                {{ substr($tx->user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-black text-lg text-slate-900 dark:text-white">{{ $tx->user->name }}</p>
                                <p class="text-slate-500 text-sm">{{ $tx->ebook->title }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-black text-xl text-slate-900 dark:text-white">Rp
                                {{ number_format($tx->total_amount, 0, ',', '.') }}</p>
                            <p class="text-[10px] uppercase font-black tracking-widest text-emerald-500">
                                {{ $tx->status }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
