@extends('layouts.app')

@section('title', 'Home - Travel Portal')

@section('content')

<div class="bg-primary text-white text-center py-5">

    <div class="container">

        <h1 class="display-4 fw-bold">
            Explore Malaysia
        </h1>

        <p class="lead">
            Discover amazing destinations for your next adventure.
        </p>

        <a href="/destinations" class="btn btn-light btn-lg">
            Explore Destinations
        </a>

    </div>

</div>


<div class="container py-5">

    <h2 class="text-center mb-4">
        Featured Destinations
    </h2>

    <div class="row">

        @forelse ($destinations as $destination)

            <div class="col-md-4 mb-4">

                <div class="card h-100 shadow-sm">

                    <img
                        src="{{ asset('images/' . $destination->image) }}"
                        class="card-img-top"
                        style="height: 220px; object-fit: cover;"
                        alt="{{ $destination->name }}">

                    <div class="card-body">

                        <span class="badge bg-primary mb-2">
                            {{ $destination->category->name }}
                        </span>

                        <h4 class="card-title">
                            {{ $destination->name }}
                        </h4>

                        <p class="text-muted">
                            📍 {{ $destination->location }}
                        </p>

                        <p>
                            {{ $destination->description }}
                        </p>

                        <p class="fw-bold text-primary">
                            RM {{ number_format($destination->price, 2) }}
                        </p>

                    </div>

                </div>

            </div>

        @empty

            <p class="text-center">
                No featured destinations available.
            </p>

        @endforelse

    </div>

</div>

@endsection