{{-- Main page where content resides that every page loads in --}}
<!DOCTYPE html>
<html>

<head>
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" />
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
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
