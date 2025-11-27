<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'App')</title>

    @vite(['resources/css/app.css'])
</head>

<body class="flex flex-col min-h-screen">

    <header class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <span class="font-bold">Contact Manager</span>
        </div>
    </header>

    <main class="flex-grow container mx-auto p-4">
        @yield('content')
    </main>

    <footer class="bg-gray-200 text-center p-4">
        &copy; {{ date('Y') }} Contact Manager.
    </footer>

</body>

</html>
