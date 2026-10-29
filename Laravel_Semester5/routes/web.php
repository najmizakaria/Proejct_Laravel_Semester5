<?php

use Illuminate\Support\Facades\Route;

function getDestinations() {
    return [
        1 => [
            'id' => 1,
            'name' => 'Langkawi Island',
            'country' => 'Malaysia',
            'price' => 450,
            'image' => 'images/langkawi.avif',
            'description' => 'Pristine white-sand beaches, lush rainforest cable car rides, and duty-free shopping.',
            'is_featured' => true,
            'rating' => 4.9
        ],
        2 => [
            'id' => 2,
            'name' => 'Phuket',
            'country' => 'Thailand',
            'price' => 550,
            'image' => 'images/phuket.webp',
            'description' => 'Crystal-clear waters, vibrant night markets, and iconic Phi Phi island tours.',
            'is_featured' => true,
            'rating' => 4.8
        ],
        3 => [
            'id' => 3,
            'name' => 'Cliffs of Moher',
            'country' => 'Ireland',
            'price' => 1100,
            'image' => 'images/cliffs-of-moher.jpg',
            'description' => 'Dramatic ocean cliffs, breathtaking Atlantic views, and rich Celtic heritage.',
            'is_featured' => false,
            'rating' => 4.7
        ],
    ];
}

Route::get('/', function () {
    $featured = array_filter(getDestinations(), fn($d) => $d['is_featured']);
    return view('home', ['destinations' => $featured]);
})->name('home');

Route::get('/destinations', function () {
    return view('destinations.index', ['destinations' => getDestinations()]);
})->name('destinations.index');

Route::get('/destinations/{id}', function ($id) {
    $destinations = getDestinations();
    if (!isset($destinations[$id])) {
        abort(404, 'Destination not found!');
    }
    return view('destinations.show', ['destination' => $destinations[$id]]);
})->name('destinations.show');