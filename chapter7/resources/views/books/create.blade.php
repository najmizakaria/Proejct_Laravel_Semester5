@extends('layouts.master')
@section('title', 'Add book')
@section('content')
    <a class="back-link" href="{{ route('books.index') }}">&larr; Back to all books</a>
    <div class="page-heading"><div><h1>Add a book</h1><p class="muted">Enter the book details below.</p></div></div>
    <form class="form-panel" method="POST" action="{{ route('books.store') }}">
        @csrf
        @include('books._form', ['book' => null, 'submitLabel' => 'Add book'])
    </form>
@endsection
