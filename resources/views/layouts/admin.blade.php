<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="app-html" class="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin - Nexora</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            transition: background-color 0.5s ease, color 0.5s ease;
        }
    </style>
</head>

<body class="bg-slate-50 dark:bg-[#020617] text-slate-900 dark:text-slate-100 selection:bg-indigo-500/30">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside
            class="w-72 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-white/10 flex flex-col fixed inset-y-0 z-50 transition-colors">
            <div class="p-8">
                <a href="/" class="text-2xl font-black tracking-tight text-indigo-900 dark:text-white group">
                    NEX<span
                        class="text-indigo-600 transition-colors duration-300 group-hover:text-emerald-500">ORA</span>
                </a>
            </div>

            <nav class="flex-1 px-6 space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center space-x-4 px-4 py-3 rounded-2xl bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-bold border border-indigo-100 dark:border-indigo-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span>Ringkasan</span>
                </a>
                <a href="{{ route('admin.ebooks') }}"
                    class="flex items-center space-x-4 px-4 py-3 rounded-2xl text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-white/5 transition-all outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.247 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                    <span>E-Book Saya</span>
                </a>
                <a href="{{ route('admin.categories') }}"
                    class="flex items-center space-x-4 px-4 py-3 rounded-2xl text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-white/5 transition-all outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                    <span>Kategori</span>
                </a>

                <!-- Features Link -->
                <a href="{{ route('admin.features') }}"
                    class="flex items-center space-x-4 px-4 py-3 rounded-2xl text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-white/5 transition-all outline-none">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                        </path>
                    </svg>
                    <span class="font-bold whitespace-nowrap overflow-hidden text-ellipsis">Fitur (Keunggulan)</span>
                </a>

                <!-- Testimonials Link -->
                <a href="{{ route('admin.testimonials') }}"
                    class="flex items-center space-x-4 px-4 py-3 rounded-2xl text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-white/5 transition-all outline-none">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                        </path>
                    </svg>
                    <span class="font-bold whitespace-nowrap overflow-hidden text-ellipsis">Testimoni</span>
                </a>

                <!-- Settings Navbar Link -->
                <a href="{{ route('admin.settings') }}"
                    class="flex items-center space-x-4 px-4 py-3 rounded-2xl text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-white/5 transition-all outline-none">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="font-bold whitespace-nowrap overflow-hidden text-ellipsis">Pengaturan</span>
                </a>
                <a href="{{ route('admin.transactions') }}"
                    class="flex items-center space-x-4 px-4 py-3 rounded-2xl text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-white/5 transition-all outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 118 0m-9.172 6.172L12 18.343l-1.828-1.828m4.542-4.542L12 11.234 9.286 13.948m11.234-2.714l-2.714-2.714">
                        </path>
                    </svg>
                    <span>Pesanan/Transaksi</span>
                </a>
            </nav>

            <div class="p-8 border-t border-slate-100 dark:border-white/10">
                <div class="flex items-center space-x-4 mb-6">
                    <div
                        class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center font-black text-xs text-white">
                        R</div>
                    <div>
                        <p class="text-sm font-bold text-slate-900 dark:text-white">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-slate-400 dark:text-slate-500 uppercase font-black tracking-wider">
                            Administrator</p>
                    </div>
                </div>
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left text-xs text-red-500 font-bold uppercase tracking-widest hover:text-red-600 transition-colors">
                        Keluar Akun
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-72 p-12">
            <header class="flex justify-between items-center mb-16">
                <div>
                    <h1 class="text-3xl font-black mb-2 text-slate-900 dark:text-white">@yield('title', 'Ringkasan Admin')</h1>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">Selamat datang kembali,
                        {{ auth()->user()->name }}.</p>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Dark Mode Toggle Small -->
                    <button id="theme-toggle"
                        class="p-3 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/10 text-slate-500 hover:scale-110 transition-all shadow-sm">
                        <svg id="sun-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 5a7 7 0 100 14 7 7 0 000-14z">
                            </path>
                        </svg>
                        <svg id="moon-icon" class="w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                            </path>
                        </svg>
                    </button>
                </div>
            </header>

            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const themeToggle = document.getElementById('theme-toggle');
            const sunIcon = document.getElementById('sun-icon');
            const moonIcon = document.getElementById('moon-icon');
            const root = document.getElementById('app-html');

            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                    '(prefers-color-scheme: dark)').matches)) {
                root.classList.add('dark');
                sunIcon?.classList.remove('hidden');
                moonIcon?.classList.add('hidden');
            }

            themeToggle?.addEventListener('click', () => {
                root.classList.toggle('dark');
                const isDark = root.classList.contains('dark');
                localStorage.theme = isDark ? 'dark' : 'light';

                if (isDark) {
                    sunIcon?.classList.remove('hidden');
                    moonIcon?.classList.add('hidden');
                } else {
                    sunIcon?.classList.add('hidden');
                    moonIcon?.classList.remove('hidden');
                }
            });
        });
    </script>
</body>

</html>
