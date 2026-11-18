@extends('layouts.app')

@section('title', $category->name)

@section('content')
    <h2>{{ $category->name }}</h2>
    <p><a href="{{ route('categories.index') }}">Back to categories</a></p>

    <table>
        <thead>
            <tr>
                <th scope="col">Title</th>
                <th scope="col">Author</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($books as $book)
                <tr>
                    <td><a href="{{ route('books.show', $book) }}">{{ $book->title }}</a></td>
                    <td>{{ $book->author }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No books in this category.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
