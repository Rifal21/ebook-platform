<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <h2 class="text-3xl font-black text-slate-900 dark:text-white mb-2 text-center">Buat Akun Baru</h2>
    <p class="text-slate-500 dark:text-slate-400 text-sm text-center mb-10">Bergabung dengan Nexora dan mulai petualangan
        karya cipta Anda.</p>

    <form wire:submit="register" class="space-y-6">
        <!-- Name -->
        <div>
            <label for="name"
                class="block text-[10px] sm:text-xs font-black uppercase tracking-widest text-slate-400 mb-2 ml-2">Nama
                Lengkap</label>
            <input wire:model="name" id="name"
                class="w-full bg-slate-50/50 dark:bg-slate-950/50 border-2 border-slate-100 dark:border-white/5 rounded-2xl md:rounded-[20px] px-5 sm:px-6 py-4 sm:py-5 text-sm sm:text-base text-slate-900 dark:text-white font-bold outline-none focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all placeholder:text-slate-300 dark:placeholder:text-slate-600"
                type="text" name="name" required autofocus autocomplete="name" placeholder="Rifal Kurniawan" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 ml-2" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email"
                class="block text-[10px] sm:text-xs font-black uppercase tracking-widest text-slate-400 mb-2 ml-2">Alamat
                Email</label>
            <input wire:model="email" id="email"
                class="w-full bg-slate-50/50 dark:bg-slate-950/50 border-2 border-slate-100 dark:border-white/5 rounded-2xl md:rounded-[20px] px-5 sm:px-6 py-4 sm:py-5 text-sm sm:text-base text-slate-900 dark:text-white font-bold outline-none focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all placeholder:text-slate-300 dark:placeholder:text-slate-600"
                type="email" name="email" required autocomplete="username" placeholder="anda@contoh.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 ml-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password"
                class="block text-[10px] sm:text-xs font-black uppercase tracking-widest text-slate-400 mb-2 ml-2">Kata
                Sandi</label>
            <input wire:model="password" id="password"
                class="w-full bg-slate-50/50 dark:bg-slate-950/50 border-2 border-slate-100 dark:border-white/5 rounded-2xl md:rounded-[20px] px-5 sm:px-6 py-4 sm:py-5 text-sm sm:text-base text-slate-900 dark:text-white font-bold outline-none focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all placeholder:text-slate-300 dark:placeholder:text-slate-600"
                type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 ml-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation"
                class="block text-[10px] sm:text-xs font-black uppercase tracking-widest text-slate-400 mb-2 ml-2">Konfirmasi
                Sandi</label>
            <input wire:model="password_confirmation" id="password_confirmation"
                class="w-full bg-slate-50/50 dark:bg-slate-950/50 border-2 border-slate-100 dark:border-white/5 rounded-2xl md:rounded-[20px] px-5 sm:px-6 py-4 sm:py-5 text-sm sm:text-base text-slate-900 dark:text-white font-bold outline-none focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all placeholder:text-slate-300 dark:placeholder:text-slate-600"
                type="password" name="password_confirmation" required autocomplete="new-password"
                placeholder="Ulangi sandi" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 ml-2" />
        </div>

        <div class="mt-10 pt-4">
            <button type="submit"
                class="w-full bg-indigo-600 text-white dark:text-white px-8 py-4 sm:py-5 rounded-2xl md:rounded-[24px] font-black text-base sm:text-lg hover:bg-indigo-700 shadow-xl shadow-indigo-600/20 transition-transform active:scale-[0.98] outline-none">
                Daftar Sekarang
            </button>
        </div>

        <p class="text-center text-xs sm:text-sm font-bold text-slate-500 dark:text-slate-400 mt-8">
            Sudah punya akun? <a href="{{ route('login') }}" wire:navigate
                class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">Masuk
                di sini</a>
        </p>
    </form>
</div>
