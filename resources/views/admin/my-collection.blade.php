@extends('layouts.admin')

@section('title', 'Koleksi E-Book Saya')

@section('content')
    <div class="reveal active bg-white dark:bg-slate-900 rounded-[40px] shadow-sm border border-slate-100 dark:border-white/5 overflow-hidden">
        <livewire:user.my-ebooks />
    </div>
@endsection
