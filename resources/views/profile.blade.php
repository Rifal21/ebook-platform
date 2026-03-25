<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status') === 'profile-incomplete')
                <div class="p-8 bg-amber-50 dark:bg-amber-900/10 border border-amber-200 dark:border-amber-500/20 rounded-[30px] flex items-center gap-6 shadow-xl shadow-amber-500/5 animate-pulse">
                    <div class="w-16 h-16 bg-amber-500 rounded-2xl flex items-center justify-center text-white text-3xl shrink-0">
                        <i class="fa-solid fa-user-pen"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-black text-amber-900 dark:text-amber-500">Lengkapi Profil Anda Terlebih Dahulu!</h4>
                        <p class="text-sm text-amber-700/80 dark:text-amber-500/60 font-medium">Anda wajib melengkapi <strong>Nomor Telepon (WhatsApp)</strong> dan <strong>Alamat Lengkap</strong> sebelum bisa melakukan pembelian E-Book.</p>
                    </div>
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.update-password-form />
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
