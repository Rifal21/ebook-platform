<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/katalog', function () {
    return view('katalog');
})->name('katalog');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', 'admin'])->group(function() {
    Route::get('admin', function() {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    Route::get('admin/ebooks', function() {
        return view('admin.ebooks');
    })->name('admin.ebooks');

    Route::get('/categories', function () {
        return view('admin.categories');
    })->name('admin.categories');
    
    Route::get('/settings', function () {
        return view('admin.settings');
    })->name('admin.settings');
    
    Route::get('/features', function () {
        return view('admin.features');
    })->name('admin.features');
    
    Route::get('/testimonials', function () {
        return view('admin.testimonials');
    })->name('admin.testimonials');
});

require __DIR__.'/auth.php';
