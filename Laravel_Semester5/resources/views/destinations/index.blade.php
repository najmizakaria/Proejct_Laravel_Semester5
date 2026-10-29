@extends('layouts.master')

@section('title', 'All Destinations')

@section('content')
<h2 class="fw-bold mb-4">All Travel Destinations</h2>

<div class="row row-cols-1 row-cols-md-3 g-4">
    @forelse ($destinations as $destination)
        <div class="col">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset($destination['image']) }}" class="card-img-top" alt="{{ $destination['name'] }}" style="height: 180px; object-fit: cover;" onerror="this.src='https://placehold.co/600x400?text=Travel+Destination'">
                <div class="card-body">
                    <h5 class="card-title fw-bold">{{ $destination['name'] }}</h5>
                    <p class="text-muted mb-2"><small>📍 {{ $destination['country'] }}</small></p>
                    <p class="fw-bold text-success mb-3">${{ number_format($destination['price'], 2) }} / person</p>
                    <a href="{{ route('destinations.show', $destination['id']) }}" class="btn btn-primary w-100">Explore</a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted">No travel destinations available right now.</p>
        </div>
    @endforelse
</div>
@endsection