<div class="flex items-center space-x-12">
    @auth
        @if (auth()->user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}"
                class="bg-indigo-600 dark:bg-indigo-500 text-white py-2.5 px-6 rounded-2xl text-sm font-bold shadow-md shadow-indigo-500/20 hover:bg-indigo-700 transition-all">Admin
                Dashboard</a>
        @else
            <a href="{{ route('dashboard') }}"
                class="bg-indigo-600 dark:bg-indigo-500 text-white py-2.5 px-6 rounded-2xl text-sm font-bold shadow-md shadow-indigo-500/20 hover:bg-indigo-700 transition-all">Koleksi
                Saya</a>
        @endif
    @else
        <a href="{{ route('login') }}"
            class="text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Masuk</a>
        @if (Route::has('register'))
            <a href="{{ route('register') }}"
                class="bg-indigo-600 dark:bg-indigo-500 text-white py-2.5 px-6 rounded-2xl text-sm font-bold shadow-md shadow-indigo-500/20 hover:bg-indigo-700 transition-all">Daftar
                Sekarang</a>
        @endif
    @endauth
</div>
