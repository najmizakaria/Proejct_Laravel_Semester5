<?php
/**
 * Student Name : Najmi
 * Student ID   : SWE24070384
 */

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::resource('books', BookController::class);