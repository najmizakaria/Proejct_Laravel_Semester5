<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BookController extends Controller
{
    public function home(): View
    {
        return view('home', [
            'books' => Book::with('category')->where('is_featured', true)->latest('id')->take(6)->get(),
            'bookCount' => Book::count(),
            'categoryCount' => Category::count(),
        ]);
    }

    public function index(): View
    {
        return view('books.index', ['books' => Book::with('category')->latest('id')->get()]);
    }

    public function create(): View
    {
        Gate::authorize('manage-books');

        return view('books.create', ['categories' => Category::orderBy('name')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('manage-books');

        $book = Book::create($this->validatedData($request));

        return redirect()->route('books.show', $book)->with('success', 'Book added successfully.');
    }

    public function show(Book $book): View
    {
        return view('books.show', ['book' => $book->load('category')]);
    }

    public function edit(Book $book): View
    {
        Gate::authorize('manage-books');

        return view('books.edit', ['book' => $book, 'categories' => Category::orderBy('name')->get()]);
    }

    public function update(Request $request, Book $book): RedirectResponse
    {
        Gate::authorize('manage-books');

        $book->update($this->validatedData($request, $book));

        return redirect()->route('books.show', $book)->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book): RedirectResponse
    {
        Gate::authorize('manage-books');

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }

    private function validatedData(Request $request, ?Book $book = null): array
    {
        $data = $request->validate([
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'title' => ['required', 'string', 'min:2', 'max:255'],
            'author' => ['required', 'string', 'min:2', 'max:255'],
            'isbn' => ['required', 'regex:/\A(?:[0-9]{10}|[0-9]{13})\z/', Rule::unique('books', 'isbn')->ignore($book)],
            'description' => ['nullable', 'string', 'max:5000'],
            'price' => ['required', 'numeric', 'decimal:0,2', 'min:0', 'max:99999999.99'],
            'stock' => ['required', 'integer', 'min:0', 'max:1000000'],
            'is_featured' => ['sometimes', 'boolean'],
        ], ['isbn.regex' => 'The ISBN must contain exactly 10 or 13 digits, without spaces or hyphens.']);

        $data['is_featured'] = $request->boolean('is_featured');

        return $data;
    }
}
