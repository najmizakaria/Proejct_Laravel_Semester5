@extends('layouts.master')

@section('title', $destination['name'])

@section('content')
<a href="{{ route('destinations.index') }}" class="btn btn-outline-secondary btn-sm mb-4">← Back to Catalog</a>

<div class="card shadow-sm border-0">
    <img src="{{ asset($destination['image']) }}" class="card-img-top rounded-top" alt="{{ $destination['name'] }}" style="max-height: 400px; object-fit: cover;" onerror="this.src='https://placehold.co/800x400?text=Travel+Destination'">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h1 class="fw-bold mb-0">{{ $destination['name'] }}</h1>
            <span class="badge bg-warning text-dark fs-6">★ {{ $destination['rating'] }}</span>
        </div>
        <p class="fs-5 text-muted mb-3">Location: {{ $destination['country'] }}</p>
        
        <p class="lead text-secondary">{{ $destination['description'] }}</p>
        
        <div class="d-flex align-items-center mt-4">
            <h4 class="text-success fw-bold me-3 mb-0">Est. Price: ${{ number_format($destination['price'], 2) }}</h4>
            @if ($destination['is_featured'])
                <span class="badge bg-purple bg-gradient  px-3 py-2">🔥 Featured Destination</span>
            @endif
        </div>
    </div>
</div>
@endsection