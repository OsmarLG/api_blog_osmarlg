<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - @yield('title')</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
</head>
<body class="bg-gray-100 text-gray-800 flex flex-col min-h-screen">
    @include('partials.header')
    
    <main class="flex-grow flex items-center justify-center">
        @yield('content')
    </main>
    
    @include('partials.footer')
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    @vite(['resources/js/app.js'])
    @vite(['resources/js/auth/logout.js'])
    @yield('js')
</body>
</html>