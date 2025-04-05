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

    <!-- Font Awesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- @vite(['resources/js/sidebar.js'])
    @vite(['resources/js/lazyloading-sidebar.js'])
    @vite(['resources/js/jadwal.js'])
@vite(['resources/js/tabs.js']) --}}
</head>

<body class="font-sans antialiased bg-gray-100">
    <main class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="md:flex md:flex-shrink-0">
            @include('layouts.sidebar')
        </aside>

        <section class="flex-1">
            <!-- Page Header -->
            <header>
                @yield('header')
            </header>

            <!-- Page Content -->
            <section class="p-10">
                @yield('content')
            </section>
        </section>
    </main>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>
