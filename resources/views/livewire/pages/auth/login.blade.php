<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        if (auth()->user()->role === 'admin') {
            $this->redirectIntended(default: route('admin.dashboard', absolute: false), navigate: true);
            return;
        }

        $this->redirectIntended(default: route('profile', absolute: false), navigate: true);
    }
}; ?>

<div>
    <h2 class="text-3xl font-black text-slate-900 dark:text-white mb-2 text-center">Selamat Datang</h2>
    <p class="text-slate-500 dark:text-slate-400 text-sm text-center mb-10">Masukkan kredensial Anda untuk melanjutkan
        akses ke akun Nexora.</p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-6">
        <!-- Email Address -->
        <div>
            <label for="email"
                class="block text-[10px] sm:text-xs font-black uppercase tracking-widest text-slate-400 mb-2 ml-2">Alamat
                Email</label>
            <input wire:model="form.email" id="email"
                class="w-full bg-slate-50/50 dark:bg-slate-950/50 border-2 border-slate-100 dark:border-white/5 rounded-2xl md:rounded-[20px] px-5 sm:px-6 py-4 sm:py-5 text-sm sm:text-base text-slate-900 dark:text-white font-bold outline-none focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all placeholder:text-slate-300 dark:placeholder:text-slate-600"
                type="email" name="email" required autofocus autocomplete="username"
                placeholder="anda@contoh.com" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2 ml-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password"
                class="block text-[10px] sm:text-xs font-black uppercase tracking-widest text-slate-400 mb-2 ml-2">Kata
                Sandi</label>
            <input wire:model="form.password" id="password"
                class="w-full bg-slate-50/50 dark:bg-slate-950/50 border-2 border-slate-100 dark:border-white/5 rounded-2xl md:rounded-[20px] px-5 sm:px-6 py-4 sm:py-5 text-sm sm:text-base text-slate-900 dark:text-white font-bold outline-none focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all placeholder:text-slate-300 dark:placeholder:text-slate-600"
                type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-2 ml-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between px-1 md:px-2 pt-2">
            <label for="remember" class="inline-flex items-center cursor-pointer group">
                <div class="relative flex items-center">
                    <input wire:model.boolean="form.remember" value="1" id="remember" type="checkbox"
                        class="peer h-5 w-5 bg-white border-2 border-slate-200 dark:bg-slate-900 dark:border-slate-700 text-indigo-600 focus:ring-indigo-500 focus:ring-offset-0 rounded-[6px] cursor-pointer transition-all">
                </div>
                <span
                    class="ms-3 text-xs sm:text-sm font-bold text-slate-500 dark:text-slate-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">Ingat
                    saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs sm:text-sm font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors"
                    href="{{ route('password.request') }}" wire:navigate>
                    Lupa sandi?
                </a>
            @endif
        </div>

        <div class="mt-10 pt-4">
            <button type="submit"
                class="w-full bg-indigo-600 text-white dark:text-white px-8 py-4 sm:py-5 rounded-2xl md:rounded-[24px] font-black text-base sm:text-lg hover:bg-indigo-700 shadow-xl shadow-indigo-600/20 transition-transform active:scale-[0.98] outline-none">
                Masuk ke Akun
            </button>
        </div>

        <p class="text-center text-xs sm:text-sm font-bold text-slate-500 dark:text-slate-400 mt-8">
            Belum punya akun? <a href="{{ route('register') }}" wire:navigate
                class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">Daftar
                sekarang</a>
        </p>
    </form>
</div>
