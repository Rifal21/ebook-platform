<?php

use App\Models\Ebook;
use App\Models\Category;
use App\Models\Order;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $search = '';
    public $activeCategory = 'all';

    protected $queryString = [
        'search' => ['except' => ''],
        'activeCategory' => ['except' => 'all'],
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedActiveCategory()
    {
        $this->resetPage();
    }

    public function getEbooksProperty()
    {
        $query = Ebook::with('category')->where('is_published', true);

        if ($this->activeCategory !== 'all') {
            $query->where('category_id', $this->activeCategory);
        }

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        return $query->latest()->paginate(9);
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

<div class="px-6 md:px-12">
    <div class="max-w-7xl mx-auto">
        <!-- Header & Search Section -->
        <div class="mb-16 md:mb-24 flex flex-col space-y-12">
            <div class="text-center md:text-left max-w-3xl">
                <h2 class="text-5xl md:text-7xl font-black mb-6 text-slate-900 dark:text-white tracking-tighter">
                    Katalog <span class="text-indigo-600">Digital</span>
                </h2>
                <p class="text-lg md:text-xl text-slate-500 dark:text-slate-400 font-medium leading-relaxed">
                    Jelajahi ribuan pengetahuan berkualitas tinggi, mulai dari e-book, produk digital, hingga source code eksklusif.
                </p>
            </div>

            <!-- Modern Search & Filter Bar -->
            <div class="flex flex-col lg:flex-row gap-8 items-stretch lg:items-center justify-between">
                <!-- Search Box -->
                <div class="relative group flex-1 max-w-2xl">
                    <div class="absolute inset-y-0 left-6 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                        <i class="fa-solid fa-magnifying-glass text-lg"></i>
                    </div>
                    <input type="text" 
                        wire:model.live.debounce.300ms="search"
                        placeholder="Cari judul atau deskripsi produk..."
                        class="w-full pl-16 pr-8 py-5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/10 rounded-3xl text-sm font-bold focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 transition-all outline-none shadow-sm dark:text-white">
                </div>

                <!-- Category Pills (Scrollable on mobile) -->
                <div class="flex items-center space-x-3 overflow-x-auto pb-4 lg:pb-0 no-scrollbar">
                    <button wire:click="$set('activeCategory', 'all')"
                        class="whitespace-nowrap px-8 py-3.5 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all {{ $activeCategory === 'all' ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-600/20' : 'bg-white dark:bg-slate-900 text-slate-400 hover:text-indigo-600 dark:hover:text-white border border-slate-100 dark:border-white/5' }}">
                        Semua
                    </button>
                    @foreach ($this->categories as $cat)
                        <button wire:click="$set('activeCategory', '{{ $cat->id }}')"
                            class="whitespace-nowrap px-8 py-3.5 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all {{ $activeCategory === $cat->id ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-600/20' : 'bg-white dark:bg-slate-900 text-slate-400 hover:text-indigo-600 dark:hover:text-white border border-slate-100 dark:border-white/5' }}">
                            {{ $cat->name }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Product Grid -->
        @if ($this->ebooks->isEmpty())
            <div class="reveal active text-center py-40 bg-white/50 dark:bg-slate-900/50 rounded-[60px] border border-dashed border-slate-200 dark:border-white/10">
                <div class="w-24 h-24 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-8">
                    <i class="fa-solid fa-face-frown text-4xl text-slate-400"></i>
                </div>
                <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-2">Tidak ditemukan</h3>
                <p class="text-slate-400 font-medium">Coba gunakan kata kunci lain atau pilih kategori berbeda.</p>
            </div>
        @else
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach ($this->ebooks as $i => $book)
                    <div class="reveal active bg-white dark:bg-slate-900 rounded-[45px] p-8 group transition-all duration-500 hover:-translate-y-3 border border-slate-100 dark:border-white/5 shadow-sm hover:shadow-2xl hover:shadow-indigo-500/10"
                        style="transition-delay: {{ $i * 50 }}ms">
                        
                        <div class="relative mb-10 aspect-[3/4] overflow-hidden rounded-[35px] bg-slate-50 dark:bg-slate-800 transition-colors">
                            @if ($book->cover_image)
                                <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}"
                                    class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-indigo-50 dark:bg-indigo-900/20">
                                    <span class="text-indigo-300 dark:text-indigo-800 font-black text-4xl">NEX</span>
                                </div>
                            @endif
                            <!-- Dynamic Badge -->
                            <div class="absolute top-6 left-6">
                                <span class="px-5 py-2.5 rounded-2xl bg-white/90 dark:bg-slate-900/90 backdrop-blur-md text-indigo-600 dark:text-indigo-400 text-[10px] font-black uppercase tracking-widest shadow-xl">
                                    {{ $book->category?->name ?? 'E-Book' }}
                                </span>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <h4 class="text-2xl font-black text-slate-900 dark:text-white leading-tight group-hover:text-indigo-600 transition-colors line-clamp-2">
                                {{ $book->title }}
                            </h4>
                            
                            <div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-white/5">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Harga</span>
                                    <span class="text-2xl font-black text-emerald-500">Rp {{ number_format($book->price, 0, ',', '.') }}</span>
                                </div>
                                <button wire:click="buy('{{ $book->id }}')"
                                    class="p-5 rounded-3xl bg-slate-900 dark:bg-white text-white dark:text-slate-900 hover:bg-indigo-600 hover:text-white transition-all active:scale-95 shadow-sm group-hover:shadow-indigo-600/30">
                                    <i class="fa-solid fa-cart-shopping text-xl"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-20 flex justify-center">
                {{ $this->ebooks->links() }}
            </div>
        @endif
    </div>
</div>

