@extends('layouts.app')

@section('title', 'Edit Book')

@section('content')
    <h2>Edit Book: {{ $book->title }}</h2>

    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('books.update', $book->id) }}" method="POST">
        @csrf
        @method('PUT')

        <p>
            Title:
            <input
                type="text"
                name="title"
                value="{{ old('title', $book->title) }}"
            >
        </p>

        <p>
            Author:
            <input
                type="text"
                name="author"
                value="{{ old('author', $book->author) }}"
            >
        </p>

        <p>
            Category:
            <select name="category_id">
                @foreach ($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}
                    >
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </p>

        <p>
            Year:
            <input
                type="number"
                name="year_published"
                value="{{ old('year_published', $book->year_published) }}"
            >
        </p>

        <p>
            Price:
            <input
                type="text"
                name="price"
                value="{{ old('price', $book->price) }}"
            >
        </p>

        <button class="btn" type="submit">Update Book</button>
    </form>
@endsection