<header class="site-header">
    <nav class="container nav" aria-label="Main navigation">
        <a class="brand" href="{{ route('home') }}">Tech Bookstore</a>
        <div class="nav-links">
            <a href="{{ route('home') }}" @if(request()->routeIs('home')) aria-current="page" @endif>Home</a>
            <a href="{{ route('books.index') }}" @if(request()->routeIs('books.index', 'books.show')) aria-current="page" @endif>All books</a>
            @can('manage-books')
                <a class="button small" href="{{ route('books.create') }}">+ Add book</a>
            @endcan
            @guest
                <a href="{{ route('login') }}">Log in</a>
                <a class="button small" href="{{ route('register') }}">Register</a>
            @endguest
            @auth
                <a href="{{ route('dashboard') }}">{{ auth()->user()->name }}</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="link-button" type="submit">Log out</button>
                </form>
            @endauth
        </div>
    </nav>
</header>
