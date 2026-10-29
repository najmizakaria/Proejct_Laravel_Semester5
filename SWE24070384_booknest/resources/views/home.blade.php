@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <h2>Welcome to BookNest</h2>

    <p>BookNest is the online catalogue for our college library.</p>
    <p>Browse the collection, view book details, and manage records.</p>

    <a class="btn" href="{{ route('books.index') }}">View All Books</a>
@endsection