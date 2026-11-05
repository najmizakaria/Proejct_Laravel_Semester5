<?php
/**
 * Student Name : Muhammad Najmi Bin Zakaria
 * Student ID   : SWE24070384
 */

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';

Route::middleware('auth')->group(function () {
    Route::livewire(
        'articles',
        'pages::articles.index'
    )->name('articles.index');

    Route::livewire(
        'articles/create',
        'pages::articles.create'
    )->name('articles.create');

    Route::livewire(
        'articles/{article}/edit',
        'pages::articles.edit'
    )->name('articles.edit');
});
