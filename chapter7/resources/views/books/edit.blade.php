@extends('layouts.master')
@section('title', 'Edit '.$book->title)
@section('content')
    <a class="back-link" href="{{ route('books.show', $book) }}">&larr; Back to book details</a>
    <div class="page-heading"><div><h1>Edit book</h1><p class="muted">Update {{ $book->title }}.</p></div></div>
    <form class="form-panel" method="POST" action="{{ route('books.update', $book) }}">
        @csrf
        @method('PUT')
        @include('books._form', ['submitLabel' => 'Save changes'])
    </form>
@endsection
