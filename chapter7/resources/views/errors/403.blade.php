@extends('layouts.master')
@section('title', 'Access restricted')
@section('content')
    <section class="empty-state">
        <p class="eyebrow">403 / ACCESS RESTRICTED</p>
        <h1>This action is for administrators.</h1>
        <p>You can still explore all books in the catalog.</p>
        <a class="button" href="{{ route('books.index') }}">Back to the catalog</a>
    </section>
@endsection
