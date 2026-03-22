<?php

use App\Models\Order;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $search = '';
    public $status = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function with(): array
    {
        $query = Order::with(['user', 'ebook', 'transaction'])->latest();

        if ($this->search) {
            $query->where(function($q) {
                $q->whereHas('user', function ($sub) {
                    $sub->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                })->orWhereHas('ebook', function ($sub) {
                    $sub->where('title', 'like', '%' . $this->search . '%');
                })->orWhere('id', 'like', '%' . $this->search . '%')
                  ->orWhere('invoice_number', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        return [
            'transactions' => $query->paginate(20),
        ];
    }
}; ?>

<div>
    <!-- Filters -->
    <div class="mb-10 bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/10 rounded-2xl shadow-sm overflow-hidden p-6 md:p-8 flex flex-col md:flex-row gap-6 justify-between items-center">
        <div class="w-full md:w-1/2 relative">
            <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama, email, judul e-book, atau ID Pesanan..."
                class="w-full bg-slate-50 dark:bg-slate-950/50 border-2 border-slate-100 dark:border-white/5 rounded-2xl pl-12 pr-6 py-4 text-slate-900 dark:text-white font-medium outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
        </div>
        
        <div class="w-full md:w-auto flex items-center space-x-4">
            <span class="text-xs font-black uppercase tracking-widest text-slate-400 hidden lg:block">Filter Status:</span>
            <select wire:model.live="status" class="w-full md:w-48 bg-slate-50 dark:bg-slate-950/50 border-2 border-slate-100 dark:border-white/5 rounded-2xl px-6 py-4 text-slate-900 dark:text-white font-bold outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all appearance-none">
                <option value="">Semua Status</option>
                <option value="success">Berhasil (Success)</option>
                <option value="pending">Tertunda (Pending)</option>
                <option value="failed">Gagal/Batal (Failed)</option>
            </select>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/10 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-100 dark:border-white/5 bg-slate-50 dark:bg-slate-800/50 flex justify-between items-center">
            <h3 class="text-lg font-black text-slate-800 dark:text-white">Daftar Transaksi Lengkap</h3>
            <span class="px-3 py-1 bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 text-xs font-black rounded-lg">{{ $transactions->total() }} Data</span>
        </div>
        <div class="p-0 overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse min-w-[1000px]">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-white/10 border-t-0 p-4">
                        <th class="py-4 px-6 text-xs font-black uppercase text-slate-400">ID Pesanan</th>
                        <th class="py-4 px-6 text-xs font-black uppercase text-slate-400">Pembeli</th>
                        <th class="py-4 px-6 text-xs font-black uppercase text-slate-400">Item Produk</th>
                        <th class="py-4 px-6 text-xs font-black uppercase text-slate-400">Metode & Waktu</th>
                        <th class="py-4 px-6 text-xs font-black uppercase text-slate-400 text-right">Nominal</th>
                        <th class="py-4 px-6 text-xs font-black uppercase text-slate-400 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                    @forelse ($transactions as $tx)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="py-4 px-6 font-mono text-xs font-bold text-slate-500 dark:text-slate-400">
                                <span class="bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 px-3 py-1.5 rounded-lg border border-indigo-100 dark:border-indigo-500/20">#{{ $tx->invoice_number }}</span>
                            </td>
                            <td class="py-4 px-6">
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
                            <td class="py-4 px-6">
                                <p class="font-bold text-sm text-slate-900 dark:text-slate-300 max-w-[200px] truncate" title="{{ $tx->ebook->title }}">{{ $tx->ebook->title }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-bold text-sm text-slate-900 dark:text-white uppercase">{{ $tx->transaction ? str_replace('_', ' ', $tx->transaction->payment_method) : '-' }}</p>
                                <p class="text-[10px] text-slate-500">{{ $tx->created_at->format('d M Y, H:i') }}</p>
                            </td>
                            <td class="py-4 px-6 text-right font-black text-slate-900 dark:text-white">
                                Rp {{ number_format($tx->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if(in_array($tx->status, ['completed', 'paid', 'success']))
                                    <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-full bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        <span class="text-emerald-600 dark:text-emerald-400 text-[10px] font-black uppercase tracking-widest">Sukses</span>
                                    </div>
                                @elseif(in_array($tx->status, ['failed', 'cancel', 'deny', 'expire']))
                                    <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-full bg-rose-50 dark:bg-rose-500/10 border border-rose-200 dark:border-rose-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        <span class="text-rose-600 dark:text-rose-400 text-[10px] font-black uppercase tracking-widest">Gagal</span>
                                    </div>
                                @else
                                    <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-full bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        <span class="text-amber-600 dark:text-amber-400 text-[10px] font-black uppercase tracking-widest">Pending</span>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400 font-bold">Belum ada data transaksi yang sesuai filter/pencarian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($transactions->hasPages())
            <div class="p-6 border-t border-slate-100 dark:border-white/5 bg-slate-50 dark:bg-slate-800/10">
                {{ $transactions->links(data: ['scrollTo' => false]) }}
            </div>
        @endif
    </div>
</div>
