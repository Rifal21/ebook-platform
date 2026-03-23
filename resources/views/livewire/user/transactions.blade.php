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
                    <table class="w-full text-left border-separate border-spacing-y-4 min-w-[800px]">
                        <thead>
                            <tr class="text-[10px] font-black uppercase tracking-[2px] text-slate-400">
                                <th class="py-2 px-6">Informasi Pesanan</th>
                                <th class="py-2 px-6">E-Book</th>
                                <th class="py-2 px-6">Linimasa</th>
                                <th class="py-2 px-6">Pembayaran</th>
                                <th class="py-2 px-6 text-right">Moderasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->myTransactions as $tx)
                                <tr class="bg-white dark:bg-white/[0.02] rounded-3xl overflow-hidden hover:shadow-2xl hover:shadow-indigo-500/5 transition-all group">
                                    <td class="py-8 px-6 first:rounded-l-3xl">
                                        <div class="flex flex-col">
                                            <span class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1">Invoice ID</span>
                                            <span class="font-mono font-bold text-indigo-600 dark:text-indigo-400 text-sm">#{{ $tx->invoice_number }}</span>
                                        </div>
                                    </td>
                                    <td class="py-8 px-6">
                                        <div class="flex items-center space-x-5">
                                            <div class="w-10 h-14 rounded-xl bg-slate-100 dark:bg-white/5 overflow-hidden flex-shrink-0 border border-slate-100 dark:border-white/5 shadow-sm">
                                                @if($tx->ebook->cover_image)
                                                    <img src="{{ Storage::url($tx->ebook->cover_image) }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-[8px] text-slate-400 font-black">NB</div>
                                                @endif
                                            </div>
                                            <div class="max-w-[180px]">
                                                <p class="font-bold text-slate-900 dark:text-white leading-tight mb-1 truncate">{{ $tx->ebook->title }}</p>
                                                <p class="text-[10px] text-slate-400 font-medium">Digital Product</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-8 px-6">
                                        <div class="flex flex-col space-y-3">
                                            <div class="flex flex-col">
                                                <span class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-0.5">Pemesanan</span>
                                                <span class="text-xs font-bold text-slate-600 dark:text-slate-300">{{ $tx->created_at->format('d M Y, H:i') }}</span>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-0.5">Pembayaran</span>
                                                @if($tx->transaction)
                                                    <span class="text-xs font-bold text-emerald-500">{{ $tx->transaction->created_at->format('d M Y, H:i') }}</span>
                                                @else
                                                    <span class="text-xs font-bold text-slate-300 dark:text-slate-600">Terbuka</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-8 px-6">
                                        <div class="flex flex-col">
                                            <span class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1">Total Bayar</span>
                                            <p class="text-lg font-black text-slate-900 dark:text-white leading-none">Rp {{ number_format($tx->total_amount, 0, ',', '.') }}</p>
                                            <p class="text-[10px] font-bold text-slate-500 uppercase mt-2">
                                                {{ $tx->transaction ? str_replace('_', ' ', $tx->transaction->payment_method) : 'Menunggu' }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="py-8 px-6 last:rounded-r-3xl text-right">
                                        <div class="flex flex-col items-end space-y-4">
                                            @if(in_array($tx->status, ['completed', 'paid', 'success']))
                                                <div class="px-5 py-2.5 rounded-2xl bg-emerald-500 text-white text-[10px] font-black uppercase tracking-[1px] flex items-center shadow-lg shadow-emerald-500/20">
                                                    <i class="fa-solid fa-circle-check mr-2 scale-110"></i> Berhasil
                                                </div>
                                            @elseif(in_array($tx->status, ['failed', 'cancel', 'deny', 'expire']))
                                                <div class="px-5 py-2.5 rounded-2xl bg-rose-500 text-white text-[10px] font-black uppercase tracking-[1px] flex items-center shadow-lg shadow-rose-500/20">
                                                    <i class="fa-solid fa-circle-xmark mr-2 scale-110"></i> Gagal
                                                </div>
                                            @else
                                                <div class="flex flex-col items-end space-y-2">
                                                    <div class="px-5 py-2.5 rounded-2xl bg-amber-500 text-white text-[10px] font-black uppercase tracking-[1px] flex items-center shadow-lg shadow-amber-500/20">
                                                        <i class="fa-solid fa-clock mr-2 scale-110"></i> Pending
                                                    </div>
                                                    @if($tx->payment_url)
                                                        <a href="{{ $tx->payment_url }}" target="_blank"
                                                            class="px-5 py-2.5 bg-indigo-600 hover:bg-slate-900 text-white text-[10px] font-black uppercase tracking-[1px] rounded-2xl transition-all shadow-xl shadow-indigo-600/20 active:scale-95">
                                                            Lanjut Bayar
                                                        </a>
                                                    @endif
                                                </div>
                                            @endif

                                            <div class="pt-2 border-t border-slate-100 dark:border-white/5 w-full flex justify-end">
                                                <a href="{{ route('orders.invoice', $tx->id) }}" target="_blank"
                                                    class="px-5 py-2 bg-white dark:bg-white/5 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/10 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-slate-50 dark:hover:bg-white/10 transition-all flex items-center group/btn active:scale-95">
                                                    <i class="fa-solid fa-file-invoice mr-2 text-indigo-500 group-hover/btn:scale-110 transition-transform"></i>
                                                    Lihat Invoice
                                                </a>
                                            </div>
                                        </div>
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
