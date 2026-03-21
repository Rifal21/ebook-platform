<?php

use App\Models\Order;
use Livewire\Volt\Component;

new class extends Component {
    public function getMyEbooksProperty()
    {
        return auth()->user()->orders()->with('ebook.category')->where('status', 'completed')->latest()->get();
    }
}; ?>

<div class="py-12 px-6 lg:px-12">
    <div class="max-w-7xl mx-auto">
        <div class="mb-12 flex justify-between items-end">
            <div>
                <h2 class="text-4xl font-black text-slate-900 dark:text-white">Koleksi <span
                        class="text-indigo-600">Saya</span></h2>
                <p class="text-slate-500 dark:text-slate-400 mt-2">Semua e-book yang telah Anda miliki di ElitePustaka.
                </p>
            </div>
            <a href="/"
                class="px-8 py-3 rounded-2xl bg-slate-900 dark:bg-white text-white dark:text-slate-900 text-xs font-black uppercase tracking-widest hover:bg-indigo-600 hover:text-white transition-all">Cari
                Buku Baru</a>
        </div>

        @if ($this->myEbooks->isEmpty())
            <div
                class="reveal active bg-white dark:bg-slate-900 p-20 rounded-[50px] border border-dashed border-slate-200 dark:border-white/10 text-center">
                <div
                    class="w-20 h-20 bg-indigo-50 dark:bg-indigo-500/10 rounded-full flex items-center justify-center mx-auto mb-8 text-indigo-600">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-4">Belum Ada Koleksi</h3>
                <p class="text-slate-500 dark:text-slate-400 mb-10 max-w-sm mx-auto">Mulailah petualangan membaca Anda
                    dengan menambahkan e-book pertama Anda.</p>
                <a href="/#katalog" class="btn-premium px-10 py-4 inline-block">Telusuri Katalog</a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach ($this->myEbooks as $order)
                    <div
                        class="reveal active bg-white dark:bg-slate-900 rounded-[45px] p-8 border border-slate-100 dark:border-white/5 shadow-sm group hover:-translate-y-2 transition-all duration-500">
                        <div
                            class="aspect-[3/4] rounded-[35px] overflow-hidden bg-slate-100 dark:bg-slate-800 mb-8 border border-slate-100 dark:border-white/5 relative shadow-inner">
                            @if ($order->ebook->cover_image)
                                <img src="{{ Storage::url($order->ebook->cover_image) }}"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400 font-black">
                                    E-BOOK</div>
                            @endif
                            <div
                                class="absolute inset-x-0 bottom-0 p-6 translate-y-full group-hover:translate-y-0 transition-all duration-500 bg-gradient-to-t from-black/80 to-transparent">
                                <a href="{{ Storage::url($order->ebook->file_path) }}" target="_blank"
                                    class="w-full py-4 bg-white text-slate-900 rounded-2xl font-black text-xs uppercase tracking-widest text-center block hover:bg-indigo-600 hover:text-white transition-all">Baca
                                    Sekarang</a>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span
                                    class="px-4 py-1.5 rounded-xl bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 text-[10px] font-black uppercase tracking-widest">{{ $order->ebook->category?->name ?? 'Koleksi' }}</span>
                                <span
                                    class="text-[10px] font-black uppercase tracking-widest text-slate-400">Dimiliki</span>
                            </div>
                            <h4 class="text-xl font-black text-slate-900 dark:text-white leading-tight">
                                {{ $order->ebook->title }}</h4>
                            <p class="text-slate-500 dark:text-slate-400 text-sm line-clamp-2 leading-relaxed">
                                {{ $order->ebook->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
