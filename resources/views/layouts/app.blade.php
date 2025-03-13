<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('images/Kj_Logo.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('layouts.sidebar')
        <div class="flex-1">
            <!-- Page Header -->
            @yield('header')

            <!-- Page Content -->
            <main class="p-10">
                @yield('content')
            </main>
        </div>
    </div>
</body>
<script>
    const menuToggle = document.getElementById('menu-toggle');
    const sidebar = document.getElementById('sidebar');
    const closeMenu = document.getElementById('close-menu');
    const hamburgerIcon = document.getElementById('hamburger-icon');
    const closeIcon = document.getElementById('close-icon');

    menuToggle.addEventListener('click', function() {
        sidebar.classList.remove('-translate-x-full');
        hamburgerIcon.classList.add('hidden');
        closeIcon.classList.remove('hidden');
    });

    closeMenu.addEventListener('click', function() {
        sidebar.classList.add('-translate-x-full');
        hamburgerIcon.classList.remove('hidden');
        closeIcon.classList.add('hidden');
    });
</script>

</html>
