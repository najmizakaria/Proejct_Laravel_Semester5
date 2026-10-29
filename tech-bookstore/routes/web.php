<?php

use Illuminate\Support\Facades\Route;

// Mock Dataset
function getBooks() {
    return [
        1 => ['id' => 1, 'title' => 'Laravel Up & Running', 'author' => 'Matt Stauffer', 'price' => 39.99, 'is_featured' => true],
        2 => ['id' => 2, 'title' => 'Clean Code', 'author' => 'Robert C. Martin', 'price' => 45.00, 'is_featured' => false],
        3 => ['id' => 3, 'title' => 'Refactoring UI', 'author' => 'Adam Wathan', 'price' => 29.99, 'is_featured' => true],
        4 => ['id' => 4, 'title' => 'Design Patterns', 'author' => 'Gang of Four', 'price' => 54.50, 'is_featured' => false],
    ];
}

// Route 1: Home Page
Route::get('/', function () {
    $allBooks = getBooks();
    // Filter featured books
    $featuredBooks = array_filter($allBooks, fn($book) => $book['is_featured']);

    return view('home', ['featuredBooks' => $featuredBooks]);
})->name('home');

// Route 2: All Books Catalog
Route::get('/books', function () {
    $books = getBooks();
    return view('books.index', ['books' => $books]);
})->name('books.index');

// Route 3: Single Book Detail Page
Route::get('/books/{id}', function ($id) {
    $books = getBooks();
    
    if (!isset($books[$id])) {
        abort(404, 'Book not found!');
    }

    return view('books.show', ['book' => $books[$id]]);
})->name('books.show');

