@extends('layouts.master')
@section('title', $book->title)
@section('content')
    <a class="back-link" href="{{ route('books.index') }}">&larr; Back to all books</a>
    <article class="book-detail">
        
        <div>
            <p class="eyebrow">{{ $book->category->name }} @if($book->is_featured) &middot; Featured read @endif</p>
            <h1>{{ $book->title }}</h1>
            <p class="lead">By {{ $book->author }}</p>
            <p class="detail-price">RM {{ number_format((float) $book->price, 2) }}</p>
            <p class="description">{{ $book->description ?: 'No description has been added for this book yet.' }}</p>
            <dl class="book-facts"><div><dt>ISBN</dt><dd>{{ $book->isbn }}</dd></div><div><dt>Availability</dt><dd>{{ $book->stock === 0 ? 'Out of stock' : $book->stock.' copies available' }}</dd></div><div><dt>Category</dt><dd>{{ $book->category->name }}</dd></div></dl>
            @can('manage-books')
                <div class="actions detail-actions"><a class="button" href="{{ route('books.edit', $book) }}">Edit book</a>@include('books._delete')</div>
            @endcan
        </div>
    </article>
@endsection
