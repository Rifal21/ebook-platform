<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="app-html" class="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katalog - Nexora</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.2/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.2/dist/ScrollTrigger.min.js"></script>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            transition: background-color 0.5s ease;
            min-height: 100vh;
        }

        .bg-glow {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: -1;
            pointer-events: none;
            overflow: hidden;
        }

        .glow-1 {
            position: absolute;
            top: -10%;
            left: -10%;
            width: 60%;
            height: 60%;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, transparent 70%);
        }

        .glow-2 {
            position: absolute;
            bottom: -10%;
            right: -10%;
            width: 60%;
            height: 60%;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%);
        }

        .dark .glow-1 {
            background: radial-gradient(circle, rgba(99, 102, 241, 0.1) 0%, transparent 60%);
        }

        .dark .glow-2 {
            background: radial-gradient(circle, rgba(15, 23, 42, 1) 0%, transparent 70%);
        }
    </style>
</head>

<body
    class="antialiased selection:bg-indigo-500/30 overflow-x-hidden bg-slate-50 dark:bg-[#020617] text-slate-900 dark:text-slate-100">
    <div class="bg-glow">
        <div class="glow-1 animate-pulse"></div>
        <div class="glow-2 animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <!-- Navigation -->
    <nav
        class="fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-b border-slate-200/50 dark:border-white/10 px-6 md:px-12 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="/"
                class="text-2xl md:text-3xl font-black tracking-tighter text-indigo-900 dark:text-white group pointer-events-auto">
                NEX<span class="text-indigo-600 transition-colors duration-300 group-hover:text-emerald-500">ORA</span>
            </a>

            <div class="hidden md:flex items-center space-x-10">
                <a href="{{ route('katalog') }}"
                    class="text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Katalog</a>
                <a href="/#fitur"
                    class="text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Keunggulan</a>
                <a href="/#testimoni"
                    class="text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Testimoni</a>

                <button id="theme-toggle"
                    class="p-2.5 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:scale-110 transition-all shadow-sm focus:outline-none">
                    <svg id="sun-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 5a7 7 0 100 14 7 7 0 000-14z">
                        </path>
                    </svg>
                    <svg id="moon-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                        </path>
                    </svg>
                </button>

                @if (Route::has('login'))
                    <livewire:welcome.navigation />
                @endif
            </div>

            <!-- Mobile Menu Toggle -->
            <div class="md:hidden flex items-center space-x-4">
                <button id="theme-toggle-mobile"
                    class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 5a7 7 0 100 14 7 7 0 000-14z">
                        </path>
                    </svg>
                </button>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="text-xs font-bold text-indigo-600 dark:text-indigo-400">Dasbor</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-xs font-bold text-indigo-600 dark:text-indigo-400">Masuk</a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Katalog Page Content -->
    <main class="pt-32 pb-20 min-h-screen">
        <livewire:welcome.katalog />
    </main>

    <!-- Footer -->
    <footer
        class="py-16 md:py-24 px-6 md:px-12 bg-white dark:bg-slate-900/50 border-t border-slate-100 dark:border-white/5 mt-auto">
        <div class="max-w-7xl mx-auto flex flex-col items-center text-center">
            <a href="/" class="text-3xl font-black tracking-tighter text-indigo-900 dark:text-white mb-6 block">
                NEX<span class="text-indigo-600">ORA</span>
            </a>
            <p class="text-[10px] md:text-sm font-bold text-slate-400 dark:text-slate-600">© 2026 Nexora Platform.
                Desain Eksklusif oleh Rifal Kurniawan.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const syncThemeToggle = () => {
                const root = document.getElementById('app-html');
                const isDark = root.classList.contains('dark');
                document.querySelectorAll('#sun-icon').forEach(icon => isDark ? icon.classList.remove(
                    'hidden') : icon.classList.add('hidden'));
                document.querySelectorAll('#moon-icon').forEach(icon => isDark ? icon.classList.add('hidden') :
                    icon.classList.remove('hidden'));
            };

            const toggleTheme = () => {
                const root = document.getElementById('app-html');
                const isDark = !root.classList.contains('dark');
                isDark ? root.classList.add('dark') : root.classList.remove('dark');
                localStorage.theme = isDark ? 'dark' : 'light';
                syncThemeToggle();
            };

            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                    '(prefers-color-scheme: dark)').matches)) {
                document.getElementById('app-html').classList.add('dark');
            }
            syncThemeToggle();

            document.getElementById('theme-toggle')?.addEventListener('click', toggleTheme);
            document.getElementById('theme-toggle-mobile')?.addEventListener('click', toggleTheme);
        });
    </script>
</body>

</html>
