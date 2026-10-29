<?php

use Illuminate\Support\Facades\Route;
use App\Models\Destination;

Route::get('/', function () {

    $destinations = Destination::with('category')
        ->where('featured', true)
        ->take(6)
        ->get();

    return view('home', compact('destinations'));
});


Route::get('/destinations', function () {

    $destinations = Destination::with('category')->get();

    return view('destinations.index', compact('destinations'));
});