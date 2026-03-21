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

        // Simpan sebagai Order Terbeli (Simulasi Berhasil)
        Order::updateOrCreate(
            ['user_id' => auth()->id(), 'ebook_id' => $ebook->id],
            [
                'total_amount' => $ebook->price,
                'status' => 'completed',
            ],
        );

        $this->dispatch('ebook-purchased', title: $ebook->title);

        return $this->redirect(route('dashboard'), navigate: true);
    }
}; ?>

<section id="katalog" class="py-32 px-8 bg-slate-100/50 dark:bg-white/5 transition-colors">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-end mb-20 reveal active">
            <div>
                <h2 class="text-5xl lg:text-7xl font-black mb-8 text-slate-900 dark:text-white">Koleksi <span
                        class="text-gradient">Terbaik</span></h2>
                <div class="flex flex-wrap gap-3">
                    <button wire:click="$set('activeCategory', 'all')"
                        class="px-6 py-2.5 rounded-2xl text-xs font-black uppercase tracking-widest transition-all {{ $activeCategory === 'all' ? 'bg-indigo-600 text-white shadow-lg' : 'bg-white dark:bg-slate-900 text-slate-400' }}">Semua</button>
                    @foreach ($this->categories as $cat)
                        <button wire:click="$set('activeCategory', '{{ $cat->id }}')"
                            class="px-6 py-2.5 rounded-2xl text-xs font-black uppercase tracking-widest transition-all {{ $activeCategory === $cat->id ? 'bg-indigo-600 text-white shadow-lg' : 'bg-white dark:bg-slate-900 text-slate-400' }}">{{ $cat->name }}</button>
                    @endforeach
                </div>
            </div>
        </div>

        @if ($this->ebooks->isEmpty())
            <div
                class="text-center py-32 bg-white dark:bg-slate-900 rounded-[50px] border border-dashed border-slate-200 dark:border-white/5">
                <p class="text-slate-400 font-bold text-xl">Belum ada e-book di kategori ini.</p>
            </div>
        @else
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-12">
                @foreach ($this->ebooks as $i => $book)
                    <div class="reveal active bg-white dark:bg-slate-900 rounded-[50px] p-10 group transition-all duration-500 hover:-translate-y-2 border border-slate-100 dark:border-white/5 shadow-sm"
                        style="transition-delay: {{ $i * 100 }}ms">
                        <div
                            class="relative mb-8 aspect-[3/4] overflow-hidden rounded-[40px] bg-slate-100 dark:bg-slate-800 transition-colors shadow-inner">
                            @if ($book->cover_image)
                                <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}"
                                    class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400 font-black">
                                    COVER</div>
                            @endif
                        </div>
                        <div class="flex justify-between items-center mb-6">
                            <span
                                class="px-5 py-2 rounded-2xl bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 text-[10px] font-black uppercase tracking-widest">{{ $book->category?->name ?? 'E-Book' }}</span>
                            <span class="text-slate-900 dark:text-white font-black text-xl">Rp
                                {{ number_format($book->price, 0, ',', '.') }}</span>
                        </div>
                        <h4
                            class="text-2xl font-black mb-8 text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                            {{ $book->title }}</h4>
                        <button wire:click="buy('{{ $book->id }}')"
                            class="w-full py-5 rounded-[22px] bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-black uppercase text-xs tracking-widest hover:bg-indigo-600 hover:text-white transition-all active:scale-95 shadow-xl shadow-slate-900/10">Beli
                            Sekarang</button>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
