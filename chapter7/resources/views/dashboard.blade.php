@extends('layouts.master')
@section('title', 'My account')
@section('content')
    <div class="page-heading"><div><h1>Hello, {{ auth()->user()->name }}.</h1><p>Welcome to your account.</p></div></div>
    <section class="form-panel">
        <h2>Account details</h2>
        <dl class="book-facts">
            <div><dt>Name</dt><dd>{{ auth()->user()->name }}</dd></div>
            <div><dt>Email</dt><dd>{{ auth()->user()->email }}</dd></div>
            <div><dt>Access</dt><dd>{{ auth()->user()->isAdmin() ? 'Administrator' : 'Reader' }}</dd></div>
        </dl>
        @can('manage-books')
            <p>You can add, edit, and delete books in the catalog.</p>
            <div class="actions"><a class="button" href="{{ route('books.create') }}">+ Add book</a><a href="{{ route('books.index') }}">Manage catalog &rarr;</a></div>
        @else
            <p>Explore the catalog and find your next read. Catalog management is available to administrators.</p>
            <a class="button" href="{{ route('books.index') }}">Browse books &rarr;</a>
        @endcan
    </section>
@endsection
