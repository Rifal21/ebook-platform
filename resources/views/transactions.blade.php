<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center py-4">
            <h2 class="font-black text-3xl text-slate-900 dark:text-white leading-tight">
                {{ __('Riwayat Transaksi') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <livewire:user.transactions />
    </div>
</x-app-layout>
