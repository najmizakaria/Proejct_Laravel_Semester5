@extends('layouts.app')

@section('title', 'Add New Book')

@section('content')
    <h2>Add New Book</h2>

    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('books.store') }}" method="POST">
        @csrf

        <p>
            Title:
            <input type="text" name="title" value="{{ old('title') }}">
        </p>

        <p>
            Author:
            <input type="text" name="author" value="{{ old('author') }}">
        </p>

        <p>
            Category:
            <select name="category_id">
                <option value="">-- Select --</option>

                @foreach ($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        {{ old('category_id') == $category->id ? 'selected' : '' }}
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
                value="{{ old('year_published') }}"
            >
        </p>

        <p>
            Price:
            <input type="text" name="price" value="{{ old('price') }}">
        </p>

        <button class="btn" type="submit">Save Book</button>
    </form>
@endsection