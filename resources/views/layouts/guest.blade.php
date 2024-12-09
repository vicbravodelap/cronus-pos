<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Guest Layout')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('css')
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
<div class="w-full max-w-2xl mx-auto p-6">
    <!-- Main content -->
    <main>
        @yield('content')
    </main>
</div>

@yield('js')
</body>

</html>
