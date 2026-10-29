<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Explore and manage the Tech Bookstore catalog.">
    <title>@yield('title', 'Home') | Tech Bookstore</title>
    <link rel="stylesheet" href="{{ asset('css/bookstore.css') }}">
</head>
<body>
    <a class="skip-link" href="#main">Skip to content</a>
    @include('layouts.header')
    <main id="main" class="container">
        @if(session('success'))
            <div class="alert success" role="status">{{ session('success') }}</div>
        @endif
        @yield('content')
    </main>
    @include('layouts.footer')
</body>
</html>
