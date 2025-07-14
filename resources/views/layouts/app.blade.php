<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'System Pengelolaan')</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script>
        window.materials = @json($materials ?? []);
        console.log('window.materials:', window.materials);
    </script>
    <!-- Remix Icon CDN -->
<link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

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
