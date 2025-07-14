<aside id="sidebar"
    class="fixed top-0 left-0 z-40 w-64 bg-white h-full overflow-y-auto transform transition-transform duration-300 ease-in-out translate-x-0">
    <div class="p-5 items-center">
        <img src="{{ asset('assets/Logo-REKA--300x104.png') }}" alt="Logo" class="h-16">
    </div>
    <nav class="p-4 space-y-2 border-t border-b">
        <h2 class="text-xl font-semibold mb-2">Menu</h2>
        <a href="{{ route('vendor.reports') }}"
            class="block py-2 px-4 rounded hover:bg-blue-300 {{ request()->routeIs('vendor.reports') ? 'bg-blue-300' : '' }}">Reports</a>
            <a href="{{ route('vendor.purchase_order') }}"
            class="block py-2 px-4 rounded hover:bg-blue-300 {{ request()->routeIs('vendor.purchase_order') ? 'bg-blue-300' : '' }}">
            Purchase Order
         </a>
         
        <a href="{{ route('vendor.riwayat_evaluasi') }}"
            class="block py-2 px-4 rounded hover:bg-blue-300 {{ request()->routeIs('vendor.riwayat_evaluasi') ? 'bg-blue-300' : '' }}">Riwayat Evaluasi</a>
    </nav>
</aside>
