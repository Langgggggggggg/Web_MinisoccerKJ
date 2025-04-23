<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MinisoccerKj</title>
    <link rel="icon" href="{{ asset('images/logo_kj.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white dark:bg-gray-900 dark:text-gray-100">

    {{-- Navbar --}}
    @include('landing_page.partials.navbar')

    {{-- Konten utama --}}
    <main class="container mx-auto px-4 py-8">
        {{-- @yield('content') --}}
    </main>

    {{-- Footer --}}
    {{-- @include('landing_page.partials.footer') --}}

</body>
</html>
