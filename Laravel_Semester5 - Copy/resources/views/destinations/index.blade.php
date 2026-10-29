@extends('layouts.master')

@section('title', 'All Destinations')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">All Travel Destinations</h2>
    <a href="{{ route('destinations.create') }}" class="btn btn-primary">+ Add Destination</a>
</div>

<div class="row row-cols-1 row-cols-md-3 g-4">
    @forelse ($destinations as $destination)
        <div class="col">
            <div class="card h-100 shadow-sm">
                <img src="{{ $destination->image_url }}" class="card-img-top" alt="{{ $destination->name }}" style="height: 180px; object-fit: cover;" onerror="this.src='https://placehold.co/600x400?text=Travel+Destination'">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold">{{ $destination->name }}</h5>
                    <p class="text-muted mb-1"><small>📍 {{ $destination->country }}</small></p>
                    <p class="mb-2"><span class="badge bg-secondary">{{ $destination->category->name }}</span></p>
                    <p class="fw-bold text-success mb-3">${{ number_format($destination->price, 2) }} / person</p>

                    <div class="mt-auto">
                        <a href="{{ route('destinations.show', $destination) }}" class="btn btn-primary w-100 mb-2">Explore</a>
                        <div class="d-flex gap-2">
                            <a href="{{ route('destinations.edit', $destination) }}" class="btn btn-outline-secondary btn-sm flex-fill">Edit</a>
                            <form method="POST" action="{{ route('destinations.destroy', $destination) }}" class="flex-fill" onsubmit="return confirm('Delete this destination?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm w-100">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted">No travel destinations yet — <a href="{{ route('destinations.create') }}">create a new one</a>.</p>
        </div>
    @endforelse
</div>
@endsection
