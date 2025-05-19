<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'System CRUD')</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')


</head>
<body class="bg-gray-100">

    {{-- Sidebar --}}
    @include('components.sidebar')

    {{-- Main Content --}}
    <div id="mainContent" class="ml-64 transition-all duration-300">
        @include('components.nav')

        <main class="p-6">
        @yield('content')
        </main>
    </div>
</body>
</html>
