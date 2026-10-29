@extends('layouts.app')

@section('title', 'All Books')

@section('content')
    <h2>Book Catalogue</h2>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <p>Total books: {{ $books->count() }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Year</th>
                <th>Price (RM)</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($books as $book)
                <tr>
                    <td>{{ $book->id }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->category->name }}</td>
                    <td>{{ $book->year_published }}</td>
                    <td>{{ number_format($book->price, 2) }}</td>
                    <td>
                        <a href="{{ route('books.show', $book->id) }}">View</a>
                        |
                        <a href="{{ route('books.edit', $book->id) }}">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No books found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection