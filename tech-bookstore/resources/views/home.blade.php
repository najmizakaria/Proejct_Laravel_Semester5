@extends('layouts.master')
@section('title', 'Home')
@section('content')
    <!-- Main Content -->
        <h2 class="text-2xl font-bold mb-4">Welcome to Our Store!</h2>
        <p class="mb-4 text-gray-600">Check out our featured tech titles below:</p>

        <ul class="space-y-2">
            @foreach ($featuredBooks as $book)
                <li class="p-3 bg-indigo-50 border border-indigo-200 rounded flex justify-between items-center">
                    <span><strong>{{ $book['title'] }}</strong> by {{ $book['author'] }}</span>
                    <a href="{{ route('books.show', $book['id']) }}" class="text-indigo-600 hover:underline">
                        View Details →
                    </a>
                </li>
            @endforeach
        </ul>
@endsection
