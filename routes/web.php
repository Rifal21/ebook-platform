<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

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
});

require __DIR__.'/auth.php';
