@extends('layouts.master')
@section('content')
    <!-- Main Content -->
        <h2 class="text-2xl font-bold mb-4">Book Catalog</h2>

        <table class="w-full text-left border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2 border">#</th>
                    <th class="p-2 border">Title</th>
                    <th class="p-2 border">Author</th>
                    <th class="p-2 border">Price</th>
                    <th class="p-2 border">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($books as $book)
                    {{-- Alternate row background colors using $loop->even --}}
                    <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                        <td class="p-2 border">
                            {{ $loop->iteration }}
                            @if($loop->first)
                                <span class="text-xs bg-yellow-300 text-yellow-800 px-1 rounded">Top</span>
                            @endif
                        </td>
                        <td class="p-2 border font-medium">{{ $book['title'] }}</td>
                        <td class="p-2 border">{{ $book['author'] }}</td>
                        <td class="p-2 border">${{ number_format($book['price'], 2) }}</td>
                        <td class="p-2 border">
                            <a href="{{ route('books.show', $book['id']) }}" class="text-blue-600 hover:underline">
                                Details
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-500">No books found in stock.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
@endsection