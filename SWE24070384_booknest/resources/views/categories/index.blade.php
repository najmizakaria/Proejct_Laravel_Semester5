@extends('layouts.app')

@section('title', 'Categories')

@section('content')
    <h2>Book Categories</h2>

    <table>
        <thead>
            <tr>
                <th scope="col">Category</th>
                <th scope="col">Books</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td><a href="{{ route('categories.show', $category) }}">{{ $category->name }}</a></td>
                    <td>{{ $category->books_count }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No categories found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
