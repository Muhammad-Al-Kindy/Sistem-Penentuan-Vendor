<aside id="sidebar"
    class="fixed top-0 left-0 z-40 w-64 bg-white h-full overflow-y-auto transform transition-transform duration-300 ease-in-out translate-x-0">
    <div class="p-5 items-center">
        <img src="{{ asset('assets/Logo-REKA--300x104.png') }}" alt="Logo" class="h-16 ">
    </div>
    <nav class="p-4 space-y-2 border-t border-b">
        <h2 class="text-xl font-semibold mb-2">Menu</h2>
        <a href="{{ route('dashboard.index') }}"
            class="block py-2 px-4 rounded hover:bg-blue-300 {{ request()->routeIs('dashboard.index') ? 'bg-blue-300' : '' }}">Dashboard</a>
        <a href="{{ route('kriteria.index') }}"
            class="block py-2 px-4 rounded hover:bg-blue-300 {{ request()->routeIs('kriteria.*') || request()->routeIs('subkriteria.*') ? 'bg-blue-300' : '' }}">Kriteria</a>
        <a href="{{ route('vendor.index') }}"
            class="block py-2 px-4 rounded hover:bg-blue-300 {{ request()->routeIs('vendor.*') ? 'bg-blue-300' : '' }}">List Vendor</a>
        <a href="{{ route('purchase.index') }}"
            class="block py-2 px-4 rounded hover:bg-blue-300 {{ request()->routeIs('purchase.*') ? 'bg-blue-300' : '' }}">List Purchase Order</a>
        <a href="{{ route('kedatangan.index') }}"
            class="block py-2 px-4 rounded hover:bg-blue-300 {{ request()->routeIs('kedatangan.*') ? 'bg-blue-300' : '' }}">Kelola Kedatangan</a>
        <a href="{{ route('rating.index') }}"
            class="block py-2 px-4 rounded hover:bg-blue-300 {{ request()->routeIs('rating.*') ? 'bg-blue-300' : '' }}">Rating</a>
        <a href="{{ route('rekomendasi.index') }}"
            class="block py-2 px-4 rounded hover:bg-blue-300 {{ request()->routeIs('rekomendasi.*') ? 'bg-blue-300' : '' }}">Rekomendasi</a>
        <a href="{{ route('chat.index') }}"
            class="block py-2 px-4 rounded hover:bg-blue-300 {{ request()->routeIs('chat.*') ? 'bg-blue-300' : '' }}">Chat</a>
    </nav>

    <nav class="p-4 space-y-2">
        <h2 class="text-xl font-semibold mb-2">Support</h2>
        <a href="#" class="block py-2 px-4 rounded hover:bg-blue-300">Setting</a>
        <a href="#" class="block py-2 px-4 rounded hover:bg-blue-300">Info</a>
    </nav>
</aside>
