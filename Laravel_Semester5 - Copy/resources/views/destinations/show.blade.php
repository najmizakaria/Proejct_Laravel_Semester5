@extends('layouts.master')

@section('title', $destination->name)

@section('content')
<a href="{{ route('destinations.index') }}" class="btn btn-outline-secondary btn-sm mb-4">← Back to Catalog</a>

<div class="card shadow-sm border-0">
    <img src="{{ $destination->image_url }}" class="card-img-top rounded-top" alt="{{ $destination->name }}" style="max-height: 400px; object-fit: cover;" onerror="this.src='https://placehold.co/800x400?text=Travel+Destination'">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h1 class="fw-bold mb-0">{{ $destination->name }}</h1>
            <span class="badge bg-warning text-dark fs-6">★ {{ $destination->rating }}</span>
        </div>
        <p class="fs-5 text-muted mb-1">Location: {{ $destination->country }}</p>
        <p class="mb-3"><span class="badge bg-secondary">{{ $destination->category->name }}</span></p>

        <p class="lead text-secondary">{{ $destination->description }}</p>

        <div class="d-flex align-items-center mt-4">
            <h4 class="text-success fw-bold me-3 mb-0">Est. Price: ${{ number_format($destination->price, 2) }}</h4>
            @if ($destination->is_featured)
                <span class="badge bg-primary px-3 py-2">🔥 Featured Destination</span>
            @endif
        </div>

        <hr class="my-4">

        <div class="d-flex gap-2">
            <a href="{{ route('destinations.edit', $destination) }}" class="btn btn-secondary">Edit</a>

            {{-- Button triggers a separate form (forms must never be nested) --}}
            <button type="submit" form="delete-form" class="btn btn-outline-danger" onclick="return confirm('Delete this destination?')">Delete</button>
        </div>

        <form id="delete-form" method="POST" action="{{ route('destinations.destroy', $destination) }}" class="d-none">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
@endsection
