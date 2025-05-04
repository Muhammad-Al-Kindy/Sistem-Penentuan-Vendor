<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'System CRUD')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
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

    <!-- JS TOGGLE -->
    <script src="{{ asset('js/navbar.js') }}"></script>

</body>
</html>
