<?php

use App\Models\Order;
use Livewire\Volt\Component;

new class extends Component {
    public function getMyTransactionsProperty()
    {
        return auth()->user()->orders()->with('transaction', 'ebook')->latest()->get();
    }
}; ?>

<div class="px-6 lg:px-12">
    <div class="max-w-7xl mx-auto">
        <div class="mb-10">
            <h2 class="text-3xl font-black text-slate-900 dark:text-white">Semua <span class="text-indigo-600">Pesanan</span></h2>
            <p class="text-slate-500 dark:text-slate-400 mt-2">Daftar lengkap riwayat pembelian E-Book Anda.</p>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-[30px] p-8 shadow-sm border border-slate-100 dark:border-white/5 overflow-hidden">
            @if ($this->myTransactions->isEmpty())
                <div class="text-center py-16">
                    <p class="text-slate-400 font-bold">Belum ada transaksi pembelian E-Book.</p>
                </div>
            @else
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-left border-collapse min-w-[600px]">
                        <thead>
                            <tr class="border-b border-slate-100 dark:border-white/5">
                                <th class="py-4 px-6 text-xs font-black uppercase tracking-widest text-slate-400">No. Invoice</th>
                                <th class="py-4 px-6 text-xs font-black uppercase tracking-widest text-slate-400">E-Book</th>
                                <th class="py-4 px-6 text-xs font-black uppercase tracking-widest text-slate-400">Tanggal</th>
                                <th class="py-4 px-6 text-xs font-black uppercase tracking-widest text-slate-400">Metode</th>
                                <th class="py-4 px-6 text-xs font-black uppercase tracking-widest text-slate-400">Total</th>
                                <th class="py-4 px-6 text-xs font-black uppercase tracking-widest text-slate-400 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                            @foreach ($this->myTransactions as $tx)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                    <td class="py-4 px-6 text-sm font-bold text-slate-900 dark:text-slate-300 font-mono">
                                        <span class="bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 px-3 py-1.5 rounded-lg border border-indigo-100 dark:border-indigo-500/20">#{{ $tx->invoice_number }}</span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <p class="font-bold text-slate-900 dark:text-white">{{ $tx->ebook->title }}</p>
                                    </td>
                                    <td class="py-4 px-6 text-sm text-slate-500">
                                        {{ $tx->created_at->format('d M Y, H:i') }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <p class="font-bold text-xs text-slate-900 dark:text-white uppercase">{{ $tx->transaction ? str_replace('_', ' ', $tx->transaction->payment_method) : '-' }}</p>
                                    </td>
                                    <td class="py-4 px-6">
                                        <p class="font-black text-slate-900 dark:text-white">Rp {{ number_format($tx->total_amount, 0, ',', '.') }}</p>
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        @if(in_array($tx->status, ['completed', 'paid', 'success']))
                                            <span class="px-3 py-1 rounded-full bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-[10px] font-black uppercase tracking-widest">Berhasil</span>
                                        @elseif(in_array($tx->status, ['failed', 'cancel', 'deny', 'expire']))
                                            <span class="px-3 py-1 rounded-full bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400 text-[10px] font-black uppercase tracking-widest">Gagal</span>
                                        @else
                                            <span class="px-3 py-1 rounded-full bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 text-[10px] font-black uppercase tracking-widest">Pending</span>
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
</div>
