<?php
/**
 * Student Name : Najmi
 * Student ID   : SWE24070384
 */

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('category')
            ->orderBy('id')
            ->get();

        return view('books.index', compact('books'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'year_published' => 'required|integer|min:1900|max:2100',
            'price' => 'required|numeric|min:0',
        ]);

        Book::create($validated);

        return redirect()
            ->route('books.index')
            ->with('success', 'Book added successfully.');
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $categories = Category::all();

        return view('books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'year_published' => 'required|integer|min:1900|max:2100',
            'price' => 'required|numeric|min:0',
        ]);

        $book->update($validated);

        return redirect()
            ->route('books.show', $book->id)
            ->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()
            ->route('books.index')
            ->with('success', 'Book deleted successfully.');
    }
}