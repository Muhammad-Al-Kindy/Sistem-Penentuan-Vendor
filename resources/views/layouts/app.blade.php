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

    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/confirmation.js') }}"></script>
    <script src="{{ Vite::asset('resources/js/app.js') }}"></script>
    @if(session('success'))
    <script src="{{ asset('js/sucess.js') }}">
    </script>
    @endif

</body>
</html>
