<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'App')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">

        <div class="fixed top-0 w-full z-10 bg-white shadow">
            @include('layouts.navigation')
        </div>

        @if (isset($header))
        <header class="bg-white shadow pt-16"> 
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif

        <main class="pt-20 pb-16"> 
            {{ $slot ?? '' }}

            @yield('content')
        </main>

        <footer class="fixed bottom-0 w-full bg-white border-t py-4 text-center text-sm text-gray-600 z-10">
            &copy; {{ date('Y') }} Contact Manager.
        </footer>

    </div>
</body>

</html>