<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone_number = '';
    public string $address = '';
    public string $user_code = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone_number = $user->phone_number ?? '';
        $this->address = $user->address ?? '';
        $this->user_code = $user->user_code ?? '';
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Perbarui informasi profil akun dan alamat email Anda.") }}
        </p>
    </header>

    @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
        <div class="mt-6 p-6 bg-rose-50 dark:bg-rose-900/10 border border-rose-200 dark:border-rose-500/20 rounded-2xl flex items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-rose-500 rounded-xl flex items-center justify-center text-white text-xl shrink-0">
                    <i class="fa-solid fa-envelope-circle-check"></i>
                </div>
                <div>
                    <h4 class="text-sm font-black text-rose-900 dark:text-rose-500">Email Belum Terverifikasi</h4>
                    <p class="text-xs text-rose-700/70 dark:text-rose-500/60 font-medium">Silahkan verifikasi email Anda untuk mendapatkan akses penuh ke fitur pembelian.</p>
                </div>
            </div>
            <button wire:click.prevent="sendVerification" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-lg transition-colors shrink-0">
                Kirim Ulang Link
            </button>
        </div>

        @if (session('status') === 'verification-link-sent')
            <div class="mt-4 p-4 bg-emerald-50 dark:bg-emerald-900/10 border border-emerald-200 dark:border-emerald-500/20 rounded-xl flex items-center gap-3">
                <i class="fa-solid fa-check-circle text-emerald-500"></i>
                <p class="text-xs font-bold text-emerald-800 dark:text-emerald-400">Link verifikasi baru telah dikirim!</p>
            </div>
        @endif
    @endif

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        <div>
            <x-input-label for="user_code" :value="__('Kode Unik Pengguna')" />
            <x-text-input wire:model="user_code" id="user_code" type="text" class="mt-1 block w-full bg-gray-100 dark:bg-gray-800" readonly disabled />
            <p class="text-[10px] text-indigo-500 font-bold mt-1 uppercase tracking-widest">ID Unik Platform Nexora</p>
        </div>

        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Alamat Email')" />
            <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="phone_number" :value="__('Nomor Telepon')" />
            <x-text-input wire:model="phone_number" id="phone_number" name="phone_number" type="text" class="mt-1 block w-full" placeholder="08123456789" />
            <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
        </div>

        <div>
            <x-input-label for="address" :value="__('Alamat Pengiriman / Lengkap')" />
            <textarea wire:model="address" id="address" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" rows="3"></textarea>
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Simpan Berhasil.') }}
            </x-action-message>
        </div>
    </form>
</section>
