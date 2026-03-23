<?php

use App\Models\Ebook;
use Livewire\Volt\Component;

new class extends Component {
    public function getFeaturedProperty()
    {
        return Ebook::with('category')->where('is_published', true)->latest()->first();
    }

    public function buy(Ebook $ebook)
    {
        if (!auth()->check()) {
            return $this->redirect(route('login'), navigate: true);
        }
        return $this->redirect(route('checkout.show', $ebook->id), navigate: true);
    }
}; ?>

<div>
    @if ($this->featured)
        <section class="py-12 md:py-24 px-4 md:px-8">
            <div class="max-w-7xl mx-auto">
                <div
                    class="reveal active relative overflow-hidden rounded-[40px] md:rounded-[60px] bg-slate-900 border border-white/5 shadow-2xl group min-h-[500px] lg:min-h-[700px]">
                    <!-- Background Mesh -->
                    <div class="absolute inset-0 opacity-20 pointer-events-none">
                        <div
                            class="absolute top-0 right-0 w-[500px] h-[500px] bg-indigo-500 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/3 animate-pulse">
                        </div>
                        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-emerald-500 rounded-full blur-[100px] translate-y-1/2 -translate-x-1/3 animate-pulse"
                            style="animation-delay: 2s;"></div>
                    </div>

                    <!-- Right Full-Bleed Image -->
                    <div class="absolute inset-y-0 right-0 w-full lg:w-1/2 pointer-events-none overflow-hidden">
                        @if ($this->featured && $this->featured->cover_image)
                            <img src="{{ Storage::url($this->featured->cover_image) }}" alt="Featured"
                                class="w-full h-full object-cover">

                            <!-- Hero-style Gradient Blend -->
                            <div class="absolute inset-0 bg-gradient-to-r from-slate-900 via-slate-900/60 to-transparent">
                            </div>
                            <div class="absolute inset-x-0 bottom-0 h-64 bg-gradient-to-t from-slate-900 to-transparent">
                            </div>
                            <div class="absolute inset-x-0 top-0 h-40 bg-gradient-to-b from-slate-900/30 to-transparent">
                            </div>
                        @endif
                    </div>

                    <div class="relative z-10 grid lg:grid-cols-2 gap-12 lg:gap-16 items-center p-8 md:p-12 lg:p-24">
                        <div class="max-w-xl">
                            <span
                                class="inline-flex items-center space-x-2 px-4 py-2 rounded-full bg-white/10 text-emerald-400 text-[10px] font-black uppercase tracking-widest mb-10">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                                <span>Rilis Terbaru</span>
                            </span>
                            <h2
                                class="text-3xl md:text-5xl lg:text-7xl font-black text-white mb-6 md:mb-8 leading-tight">
                                {{ $this->featured->title }}</h2>
                            <p class="text-base md:text-lg text-slate-400 mb-8 md:mb-10 leading-relaxed max-w-lg">
                                {{ Str::limit($this->featured->description, 180) }}</p>

                            <div class="flex items-center space-x-8 mb-12">
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-1">
                                        Harga Premium</p>
                                    <p class="text-3xl font-black text-white">Rp
                                        {{ number_format($this->featured->price, 0, ',', '.') }}</p>
                                </div>
                                <div class="w-px h-12 bg-white/10"></div>
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-1">
                                        Kategori</p>
                                    <p class="text-3xl font-black text-emerald-400">
                                        {{ $this->featured->category?->name ?? 'Update' }}</p>
                                </div>
                            </div>

                            <button wire:click="buy('{{ $this->featured->id }}')"
                                class="w-full md:w-auto px-12 py-5 rounded-[22px] bg-white text-slate-900 font-black uppercase text-xs tracking-[2px] transition-all hover:bg-emerald-400 hover:scale-105 active:scale-95 shadow-xl shadow-white/5">Beli
                                Koleksi Terbatas</button>
                        </div>

                        <!-- Empty space for absolute image -->
                        <div class="hidden lg:block h-full"></div>
                    </div>
                </div>
                </div>
            </div>
        </section>
    @endif
</div>
