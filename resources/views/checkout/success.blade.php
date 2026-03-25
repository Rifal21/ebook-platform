<x-app-layout>
    <div class="py-24 px-6 flex items-center justify-center min-h-[80vh]">
        <div class="max-w-xl w-full text-center">
            <!-- success icon -->
            <div class="w-24 h-24 bg-emerald-500 rounded-[40px] flex items-center justify-center text-white text-5xl mx-auto mb-10 shadow-2xl shadow-emerald-500/20 animate-bounce">
                <i class="fa-solid fa-check"></i>
            </div>

            <h1 class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-6">Pembayaran Berhasil!</h1>
            <p class="text-slate-500 dark:text-slate-400 text-lg mb-12 leading-relaxed">Terima kasih atas pembelian Anda. E-book Anda sekarang sudah tersedia di koleksi pribadi dan dapat langsung dibaca.</p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('dashboard') }}" class="w-full sm:w-auto px-10 py-5 bg-indigo-600 text-white rounded-3xl font-black uppercase text-xs tracking-[2px] shadow-xl shadow-indigo-600/20 hover:scale-105 active:scale-95 transition-all">
                    Lihat Koleksi Saya
                </a>
                <a href="{{ route('katalog') }}" class="w-full sm:w-auto px-10 py-5 bg-white dark:bg-white/5 text-slate-900 dark:text-white rounded-3xl font-black uppercase text-xs tracking-[2px] border border-slate-100 dark:border-white/5 hover:bg-slate-50 transition-all">
                    Lanjut Belanja
                </a>
            </div>
            
            <p class="mt-12 text-slate-400 text-xs font-medium uppercase tracking-widest">Gunakan Invoice ID untuk pertanyaan lebih lanjut</p>
            <p class="mt-2 font-mono font-bold text-indigo-600 dark:text-indigo-400">{{ request('order_id') }}</p>
        </div>
    </div>
</x-app-layout>
