<?php

use App\Http\Controllers\DestinationController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

// One line registers all 7 RESTful routes:
// destinations.index / create / store / show / edit / update / destroy
Route::resource('destinations', DestinationController::class);
