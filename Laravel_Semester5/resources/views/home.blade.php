@extends('layouts.master')

@section('title', 'Featured Travel Spot')

@section('content')
<div class="p-5 mb-4 bg-white rounded-3 shadow-sm border">
    <h1 class="display-5 fw-bold text-primary">Discover Your Next Adventure</h1>
    <p class="col-md-8 fs-4 text-muted">Explore handpicked top-rated travel destinations across the globe.</p>
    <a class="btn btn-primary btn-lg" href="{{ route('destinations.index') }}">Browse Catalog</a>
</div>

<h3 class="mb-3 fw-bold">Featured Spots</h3>
<div class="row row-cols-1 row-cols-md-2 g-4">
    @foreach ($destinations as $destination)
        <div class="col">
            <div class="card h-100 shadow-sm">
                <!-- Serving static image safely from public/ storage -->
                <img src="{{ asset($destination['image']) }}" class="card-img-top" alt="{{ $destination['name'] }}" style="height: 220px; object-fit: cover;" onerror="this.src='https://placehold.co/600x400?text=Travel+Destination'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title mb-0 fw-bold">{{ $destination['name'] }}</h5>
                        <span class="badge bg-warning text-dark">★ {{ $destination['rating'] }}</span>
                    </div>
                    <p class="card-text text-secondary">{{ $destination['description'] }}</p>
                    <a href="{{ route('destinations.show', $destination['id']) }}" class="btn btn-outline-primary btn-sm">View Details →</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection