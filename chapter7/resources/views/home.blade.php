@extends('layouts.master')
@section('title', 'Home')
@section('content')
    <h1>Welcome to Tech Bookstore</h1>
    <p>This website displays books and their categories.</p>
    <p>Total books: {{ $bookCount }} | Total categories: {{ $categoryCount }}</p>
    <p><a href="{{ route('books.index') }}">View all books</a></p>

    <h2>Featured Books</h2>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Author</th>
                    <th scope="col">Category</th>
                    <th scope="col">Price</th>
                    <th scope="col">Details</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                    <tr>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->category->name }}</td>
                        <td>RM {{ number_format((float) $book->price, 2) }}</td>
                        <td><a href="{{ route('books.show', $book) }}">View book</a></td>
                    </tr>
                @empty
                    <tr><td colspan="5">No featured books yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
