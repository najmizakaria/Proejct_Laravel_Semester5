<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- Dynamic Browser Title -->
    <title>@yield('title', 'Home') - Tech Bookstore</title>


    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 p-8 min-h-screen flex flex-col justify-between">


    <div>
        <!-- Include Header Partial -->
        @include('layouts.header')


        <!-- Main Content Region -->
        <main class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
            @yield('content')
        </main>
    </div>


    <!-- Include Footer Partial -->
    @include('layouts.footer')


</body>
</html>

