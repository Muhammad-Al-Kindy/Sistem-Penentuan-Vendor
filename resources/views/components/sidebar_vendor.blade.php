<aside id="sidebar"
    class="fixed top-0 left-0 z-40 w-64 bg-white h-full overflow-y-auto transform transition-transform duration-300 ease-in-out translate-x-0 shadow-md">
    <div class="p-5 flex items-center justify-center border-b">
        <img src="{{ asset('assets/Logo-REKA--300x104.png') }}" alt="Logo" class="h-14">
    </div>
    <nav class="p-4 space-y-1 text-gray-700 text-sm font-medium">
        <h2 class="text-base font-semibold text-gray-500 px-2 mb-2">Menu Vendor</h2>

        <a href="{{ route('vendor.reports') }}"
            class="flex items-center px-4 py-2 rounded-lg transition hover:bg-blue-100 {{ request()->routeIs('vendor.reports*') || request()->routeIs('chat.index.vendor*') || request()->routeIs('chat.message*') ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">
            <i class="fas fa-chart-line w-5 mr-3 text-gray-500"></i>
            Reports
        </a>

        <a href="{{ route('vendor.purchase_order') }}"
            class="flex items-center px-4 py-2 rounded-lg transition hover:bg-blue-100 {{ request()->routeIs('vendor.purchase_order*') ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">
            <i class="fas fa-file-alt w-5 mr-3 text-gray-500"></i>
            Purchase Order
        </a>

        <a href="{{ route('vendor.riwayat_evaluasi') }}"
            class="flex items-center px-4 py-2 rounded-lg transition hover:bg-blue-100 {{ request()->routeIs('vendor.riwayat_evaluasi') ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">
            <i class="fas fa-history w-5 mr-3 text-gray-500"></i>
            Riwayat Evaluasi
        </a>
    </nav>
</aside>
