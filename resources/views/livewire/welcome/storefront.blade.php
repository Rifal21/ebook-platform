<?php

use App\Models\Ebook;
use App\Models\Category;
use App\Models\Order;
use Livewire\Volt\Component;

new class extends Component {
    public $activeCategory = 'all';

    public function getEbooksProperty()
    {
        $query = Ebook::with('category')->where('is_published', true);

        if ($this->activeCategory !== 'all') {
            $query->where('category_id', $this->activeCategory);
        }

        return $query->latest()->get();
    }

    public function getCategoriesProperty()
    {
        return Category::all();
    }

    public function buy(Ebook $ebook)
    {
        if (!auth()->check()) {
            return $this->redirect(route('login'), navigate: true);
        }

        return $this->redirect(route('checkout.show', $ebook->id), navigate: true);
    }
}; ?>

<div class="space-y-8">
    <!-- Filter Tabs -->
    <div class="flex overflow-x-auto hide-scrollbar space-x-2 pb-2 -mx-6 px-6 sm:mx-0 sm:px-0 scroll-smooth">
        <button wire:click="$set('activeCategory', 'all')"
            class="whitespace-nowrap px-5 py-2.5 rounded-full text-sm font-bold transition-all {{ $activeCategory === 'all' ? 'bg-slate-900 text-white dark:bg-white dark:text-slate-900 shadow-md' : 'bg-white text-slate-600 dark:bg-slate-800 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700' }}">Semua
            Produk</button>
        @foreach ($this->categories as $cat)
            <button wire:click="$set('activeCategory', '{{ $cat->id }}')"
                class="whitespace-nowrap px-5 py-2.5 rounded-full text-sm font-bold transition-all {{ $activeCategory === $cat->id ? 'bg-slate-900 text-white dark:bg-white dark:text-slate-900 shadow-md' : 'bg-white text-slate-600 dark:bg-slate-800 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700' }}">{{ $cat->name }}</button>
        @endforeach
    </div>

    <!-- Product Grid -->
    @if ($this->ebooks->isEmpty())
        <div
            class="text-center py-16 bg-white dark:bg-slate-800/50 rounded-[32px] border border-dashed border-slate-200 dark:border-slate-700">
            <p class="text-slate-400 font-bold text-lg">Belum ada produk di kategori ini.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach ($this->ebooks as $book)
                <div
                    class="group bg-white dark:bg-slate-800/80 backdrop-blur-md rounded-[28px] p-4 border border-slate-200 dark:border-slate-700 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] hover:shadow-[0_8px_30px_-5px_rgba(6,81,237,0.15)] hover:border-indigo-500/30 transition-all duration-300 flex items-stretch cursor-pointer">
                    <!-- Image -->
                    <div
                        class="w-24 h-24 sm:w-32 sm:h-32 flex-shrink-0 bg-slate-100 dark:bg-slate-700 rounded-[20px] overflow-hidden relative border border-slate-100 dark:border-slate-600">
                        @if ($book->cover_image)
                            <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div
                                class="w-full h-full flex items-center justify-center text-slate-400 text-xs font-bold bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-800">
                                COVER</div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="ml-4 sm:ml-6 py-1 flex flex-col justify-between flex-grow">
                        <div>
                            <div class="flex items-center space-x-2 mb-2">
                                <span
                                    class="px-2 py-0.5 rounded-md bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 text-[10px] font-black uppercase tracking-wider">{{ $book->category?->name ?? 'Digital' }}</span>
                            </div>
                            <h3
                                class="text-lg sm:text-xl font-extrabold text-slate-900 dark:text-white leading-tight mb-1 line-clamp-2 md:line-clamp-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                {{ $book->title }}</h3>
                        </div>

                        <div class="flex items-end justify-between mt-2 space-x-2">
                            <div>
                                <span
                                    class="text-slate-400 dark:text-slate-500 text-[10px] font-bold uppercase tracking-widest block mb-1">Akses
                                    Permanen</span>
                                <span
                                    class="text-slate-900 dark:text-white font-black text-lg sm:text-xl leading-none block">Rp
                                    {{ number_format($book->price, 0, ',', '.') }}</span>
                            </div>
                            <button wire:click="buy('{{ $book->id }}')"
                                class="px-6 py-3 rounded-full bg-slate-900 text-white dark:bg-white dark:text-slate-900 font-extrabold text-sm hover:scale-105 active:scale-95 transition-transform shadow-md">Beli</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</div>
