<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">✈️ Wanderlust Portal</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('destinations.index') }}">Destinations</a>
                </li>
                <li class="nav-item ms-lg-2">
                    <a class="btn btn-light btn-sm fw-semibold" href="{{ route('destinations.create') }}">+ Add Destination</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
