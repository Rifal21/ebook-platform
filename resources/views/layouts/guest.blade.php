<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Nexora') }} - Autentikasi</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800;900&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

<body class="font-sans text-slate-900 dark:text-slate-100 antialiased bg-slate-50 dark:bg-slate-950 overflow-x-hidden">
    <!-- Background Glow -->
    <div class="bg-glow">
        <div class="glow-1 animate-pulse"></div>
        <div class="glow-2 animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-10 sm:pt-0">
        <div>
            <a href="/" wire:navigate
                class="text-4xl md:text-5xl font-black tracking-tighter text-indigo-900 dark:text-white group drop-shadow-sm hover:scale-105 transition-transform">
                NEX<span class="text-indigo-600 transition-colors duration-300 group-hover:text-emerald-500">ORA</span>
            </a>
        </div>

        <div
            class="w-full sm:max-w-[480px] mt-10 px-8 md:px-12 py-10 md:py-14 bg-white/90 dark:bg-slate-900/90 backdrop-blur-3xl shadow-[0_20px_60px_-15px_rgba(0,0,0,0.1)] dark:shadow-[0_20px_60px_-15px_rgba(0,0,0,0.4)] overflow-hidden sm:rounded-[50px] border border-slate-100 dark:border-white/5 relative z-10 transition-all">
            {{ $slot }}
        </div>
    </div>
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        }
    </script>
</body>

</html>
