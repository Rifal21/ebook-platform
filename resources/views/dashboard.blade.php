<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center py-4">
            <h2 class="font-black text-3xl text-slate-900 dark:text-white leading-tight">
                {{ __('Dashboard Saya') }}
            </h2>
            <div class="flex items-center space-x-4">
                <span
                    class="px-4 py-2 rounded-2xl bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 text-xs font-black uppercase tracking-widest">{{ auth()->user()->orders()->where('status', 'completed')->count() }}
                    E-Book Dimiliki</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <livewire:user.my-ebooks />
    </div>
</x-app-layout>
