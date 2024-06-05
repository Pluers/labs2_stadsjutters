{{-- Main page where content resides that every page loads in --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0&display=swap" />
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <link rel="preload" fetchpriority="high" as="image"
        href="{{ asset('logo-met-witte-achtergrond-stadsjutters-1.webp') }}" type="image/png">
    {{-- For the map import --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- For the map import --}}
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</head>

<body>
    @if (auth()->check())
        <header>
            @include('components.header')
        </header>
        <main>
            <router-view></router-view>
        </main>
        <nav>
            <navbar></navbar>
        </nav>
    @else
        <main>
            @yield('content')
        </main>
    @endif
</body>

</html>
