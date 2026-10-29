<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>BookNest - @yield('title', 'Home')</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f8;
            color: #222;
        }

        header {
            background: #1f3b57;
            color: #fff;
            padding: 18px 40px;
        }

        header h1 {
            font-size: 22px;
        }

        nav {
            background: #2c5378;
            padding: 10px 40px;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            margin-right: 20px;
            font-size: 14px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 960px;
            margin: 30px auto;
            background: #fff;
            padding: 25px;
            border-radius: 6px;
        }

        h2 {
            margin-bottom: 12px;
            color: #1f3b57;
        }

        p {
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .btn {
            display: inline-block;
            background: #1f3b57;
            color: #fff;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px 10px;
            text-align: left;
            font-size: 14px;
        }

        th {
            background: #eef2f6;
        }

        footer {
            text-align: center;
            padding: 15px;
            font-size: 13px;
            color: #666;
        }
    </style>
</head>
<body>
    <header>
        <h1>BookNest</h1>
    </header>

    <nav>
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('books.index') }}">Books</a>
        <a href="{{ route('books.create') }}">Add New Book</a>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <footer>
        &copy; 2026 BookNest Library System
    </footer>
</body>
</html>