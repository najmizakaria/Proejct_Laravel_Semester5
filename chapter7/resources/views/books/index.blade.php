@extends('layouts.master')
@section('title', 'All books')
@section('content')
    <div class="page-heading">
        <div><h1>Book List</h1><p class="muted">{{ $books->count() }} {{ Str::plural('book', $books->count()) }} in the catalog.</p></div>
        @can('manage-books')
            <a class="button" href="{{ route('books.create') }}">+ Add book</a>
        @endcan
    </div>
    <div class="table-wrap">
        <table>
            <caption class="sr-only">Book catalog with prices, availability, and management actions</caption>
            <thead><tr><th scope="col">#</th><th scope="col">Book / Author</th><th scope="col">Category</th><th scope="col">Price</th><th scope="col">Stock</th><th scope="col">Actions</th></tr></thead>
            <tbody>
                @forelse($books as $book)
                    <tr class="{{ $loop->even ? 'alternate' : '' }}">
                        <td class="muted">{{ $loop->iteration }}</td>
                        <td><a class="book-title" href="{{ route('books.show', $book) }}">{{ $book->title }}</a><span class="table-author">{{ $book->author }} @if($book->is_featured)<span class="featured">Featured</span>@endif</span></td>
                        <td>{{ $book->category->name }}</td>
                        <td class="no-wrap">RM {{ number_format((float) $book->price, 2) }}</td>
                        <td><span class="stock {{ $book->stock === 0 ? 'out' : '' }}">{{ $book->stock === 0 ? 'Out of stock' : $book->stock.' available' }}</span></td>
                        <td><div class="actions"><a href="{{ route('books.show', $book) }}" aria-label="View {{ $book->title }}">View</a>@can('manage-books')<a href="{{ route('books.edit', $book) }}" aria-label="Edit {{ $book->title }}">Edit</a>@include('books._delete')@endcan</div></td>
                    </tr>
                @empty
                    <tr><td colspan="6"><div class="empty-state"><h2>The shelf is waiting</h2><p>No books are available yet. Check back soon.</p>@can('manage-books')<a class="button" href="{{ route('books.create') }}">+ Add your first book</a>@endcan</div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
