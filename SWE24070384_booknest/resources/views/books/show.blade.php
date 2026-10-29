@extends('layouts.app')

@section('title', $book->title)

@section('content')
    <h2>{{ $book->title }}</h2>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <table>
        <tr>
            <th>Author</th>
            <td>{{ $book->author }}</td>
        </tr>

        <tr>
            <th>Category</th>
            <td>{{ $book->category->name }}</td>
        </tr>

        <tr>
            <th>Year Published</th>
            <td>{{ $book->year_published }}</td>
        </tr>

        <tr>
            <th>Price</th>
            <td>RM {{ number_format($book->price, 2) }}</td>
        </tr>

        <tr>
            <th>Books in this category</th>
            <td>{{ $book->category->books->count() }}</td>
        </tr>
    </table>

    <p>
        <a class="btn" href="{{ route('books.edit', $book->id) }}">Edit</a>
    </p>

    <form action="{{ route('books.destroy', $book->id) }}" method="POST">
        @csrf
        @method('DELETE')

        <button
            class="btn"
            type="submit"
            onclick="return confirm('Delete this book?')"
        >
            Delete
        </button>
    </form>
@endsection