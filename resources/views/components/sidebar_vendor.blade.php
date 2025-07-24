<aside id="sidebar"
    class="fixed top-0 left-0 z-40 w-64 bg-white h-full shadow-lg border-r border-gray-200 flex flex-col justify-between translate-x-0 transition-transform duration-300">

    <!-- Logo -->
    <div class="p-6">
        <img src="{{ asset('assets/Logo-REKA--300x104.png') }}" alt="Logo" class="h-12 mx-auto">
    </div>

    <!-- Main Navigation -->
    <nav class="px-4 flex-1">
        <hr class="border-t border-gray-200 my-2">
        <ul class="space-y-2">
            <br>

            <!-- Reports -->
            <li>
                <a href="{{ route('vendor.reports') }}"
                    class="flex items-center px-4 py-2 rounded-lg transition hover:bg-indigo-100 {{ request()->routeIs('vendor.reports*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700' }}">
                    <i class="fas fa-chart-line w-5 h-5 mr-3"></i>
                    Reports
                </a>
            </li>

            <!-- Purchase Order -->
            <li>
                <a href="{{ route('vendor.purchase_order') }}"
                    class="flex items-center px-4 py-2 rounded-lg transition hover:bg-indigo-100 {{ request()->routeIs('vendor.purchase_order*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700' }}">
                    <i class="fas fa-file-alt w-5 h-5 mr-3"></i>
                    Purchase Order
                </a>
            </li>

            {{-- <!-- Chat -->
            <li>
                <a href="{{ route('chat.index.vendor') }}"
                    class="flex items-center px-4 py-2 rounded-lg transition hover:bg-indigo-100 {{ request()->routeIs('chat.index.vendor') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700' }}">
                    <i class="fas fa-comments w-5 h-5 mr-3"></i>
                    Chat
                </a>
            </li> --}}

        </ul>
    </nav>
</aside>
