{{-- Main page where content resides that every page loads in --}}
<!DOCTYPE html>
<html>

<head>
    <title>@yield('title')</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" />
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <header>
        @include('components.header')
    </header>
    <main>
        @yield('content')
    </main>
    <nav>
        @include('components.navbar')
    </nav>
</body>

</html>
