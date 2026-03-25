<?php

use App\Models\User;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $search = '';
    public $editingUser = null;
    
    // Form fields
    public $name, $email, $role, $phone_number, $address;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function edit(User $user)
    {
        $this->editingUser = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->phone_number = $user->phone_number;
        $this->address = $user->address;
        
        $this->dispatch('open-modal', 'edit-user-modal');
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->editingUser->id,
            'role' => 'required|in:user,admin',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $this->editingUser->update([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
        ]);

        $this->dispatch('close-modal', 'edit-user-modal');
        $this->dispatch('notify', 'Data pengguna berhasil diperbarui!');
        $this->editingUser = null;
    }

    public function delete(User $user)
    {
        if ($user->id === auth()->id()) {
            $this->dispatch('notify', 'Anda tidak dapat menghapus akun Anda sendiri!', 'error');
            return;
        }
        
        $user->delete();
        $this->dispatch('notify', 'Pengguna berhasil dihapus!');
    }

    public function with()
    {
        return [
            'users' => User::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('user_code', 'like', '%' . $this->search . '%')
                ->latest()
                ->paginate(10),
        ];
    }
}; ?>

<div class="space-y-10">
    <!-- Header & Search -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h2 class="text-3xl font-black text-slate-900 dark:text-white">Kelola <span class="text-indigo-600">Pengguna</span></h2>
            <p class="text-slate-500 dark:text-slate-400 mt-2">Daftar lengkap pengguna terdaftar di platform Nexora.</p>
        </div>
        <div class="w-full md:w-96">
            <div class="relative group">
                <input wire:model.live="search" type="text" placeholder="Cari nama, email, atau kode unik..." 
                    class="w-full h-14 pl-12 pr-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/10 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-slate-900 rounded-[30px] p-8 shadow-2xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-white/5 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-separate border-spacing-y-3 min-w-[1000px]">
                <thead>
                    <tr class="text-[10px] font-black uppercase tracking-[2px] text-slate-400">
                        <th class="py-2 px-6 text-center">Profil</th>
                        <th class="py-2 px-6">Identitas & Kontak</th>
                        <th class="py-2 px-6">Informasi Tambahan</th>
                        <th class="py-2 px-6">Status Verifikasi</th>
                        <th class="py-2 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="bg-slate-50/50 dark:bg-white/[0.02] rounded-3xl transition-all hover:bg-white dark:hover:bg-white/[0.05] hover:shadow-xl hover:shadow-indigo-500/5 group border border-transparent hover:border-indigo-100 dark:hover:border-indigo-500/20">
                            <td class="py-8 px-6 first:rounded-l-3xl">
                                <div class="flex flex-col items-center">
                                    <div class="w-14 h-14 rounded-full bg-indigo-600 flex items-center justify-center font-black text-white text-lg shadow-lg shadow-indigo-600/20 mb-2">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span class="text-[9px] font-black uppercase tracking-widest px-2 py-0.5 rounded-lg {{ $user->role === 'admin' ? 'bg-amber-100 text-amber-600' : 'bg-slate-100 text-slate-600' }}">
                                        {{ $user->role }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-8 px-6">
                                <div class="flex flex-col">
                                    <h4 class="font-black text-slate-900 dark:text-white group-hover:text-indigo-600 transition-colors">{{ $user->name }}</h4>
                                    <p class="text-sm text-slate-500 font-medium mb-1">{{ $user->email }}</p>
                                    <div class="flex items-center text-[10px] font-mono font-bold text-indigo-500 bg-indigo-50 dark:bg-indigo-500/10 px-2 py-0.5 rounded-md w-fit">
                                        {{ $user->user_code }}
                                    </div>
                                </div>
                            </td>
                            <td class="py-8 px-6">
                                <div class="flex flex-col space-y-1">
                                    <div class="flex items-center text-xs text-slate-600 dark:text-slate-400">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        {{ $user->phone_number ?? 'Belum ada nomor' }}
                                    </div>
                                    <div class="flex items-start text-xs text-slate-600 dark:text-slate-400">
                                        <svg class="w-4 h-4 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <span class="line-clamp-2 max-w-[200px]">{{ $user->address ?? 'Alamat belum diisi' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-8 px-6">
                                @if($user->email_verified_at)
                                    <div class="flex items-center text-emerald-500 font-bold text-xs uppercase tracking-widest">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Verified
                                    </div>
                                    <p class="text-[9px] text-slate-400 mt-1">{{ $user->email_verified_at->format('d M Y') }}</p>
                                @else
                                    <div class="flex items-center text-amber-500 font-bold text-xs uppercase tracking-widest">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Unverified
                                    </div>
                                @endif
                            </td>
                            <td class="py-8 px-6 last:rounded-r-3xl text-right">
                                <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button wire:click="edit('{{ $user->id }}')" 
                                        class="p-3 bg-white dark:bg-slate-800 text-indigo-600 rounded-2xl border border-slate-100 dark:border-white/10 shadow-sm hover:scale-110 active:scale-95 transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    <button wire:click="delete('{{ $user->id }}')" wire:confirm="Apakah Anda yakin ingin menghapus pengguna ini?"
                                        class="p-3 bg-white dark:bg-slate-800 text-rose-500 rounded-2xl border border-slate-100 dark:border-white/10 shadow-sm hover:scale-110 active:scale-95 transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-8 px-6">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Edit User Modal -->
    <x-modal name="edit-user-modal" title="Edit Profil Pengguna">
        <form wire:submit="save" class="p-8 space-y-6">
            <div class="grid md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Nama Lengkap</label>
                    <input wire:model="name" type="text" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all p-4 text-sm font-bold">
                    @error('name') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Email Address</label>
                    <input wire:model="email" type="email" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all p-4 text-sm font-bold">
                    @error('email') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Role</label>
                    <select wire:model="role" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all p-4 text-sm font-bold">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Nomor Telepon</label>
                    <input wire:model="phone_number" type="text" placeholder="Contoh: 08123456789" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all p-4 text-sm font-bold">
                </div>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Alamat Lengkap</label>
                <textarea wire:model="address" rows="3" placeholder="Masukkan alamat lengkap pengiriman/tagihan..." class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all p-4 text-sm font-bold"></textarea>
            </div>

            <div class="flex justify-end gap-4 pt-6 border-t border-slate-100 dark:border-white/5">
                <button type="button" x-on:click="$dispatch('close-modal', 'edit-user-modal')" 
                    class="px-8 py-4 bg-slate-100 dark:bg-white/5 text-slate-600 dark:text-slate-400 rounded-2xl font-black uppercase text-[10px] tracking-widest hover:bg-slate-200 transition-all">Batal</button>
                <button type="submit" 
                    class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-xl shadow-indigo-600/20 hover:scale-105 active:scale-95 transition-all">Simpan Perubahan</button>
            </div>
        </form>
    </x-modal>
</div>
