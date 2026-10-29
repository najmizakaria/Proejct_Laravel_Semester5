<header class="max-w-4xl mx-auto mb-6 flex justify-between items-center bg-white p-4 rounded shadow">
   
    <!-- Brand: Logo Image + Text Wording Side-by-Side -->
    <a href="{{ route('home') }}" class="flex items-center space-x-3">
        <img src="{{ asset('storage/logo.png') }}"
             alt="TechBookStore Logo"
             class="h-9 w-auto object-contain">
        <h1 class="text-xl font-bold text-indigo-600">TechBookStore</h1>
    </a>


    <!-- Navigation Links -->
    <nav class="space-x-4">
        <a href="{{ route('home') }}" class="hover:underline">Home</a>
        <a href="{{ route('books.index') }}" class="hover:underline">All Books</a>
    </nav>


</header>



