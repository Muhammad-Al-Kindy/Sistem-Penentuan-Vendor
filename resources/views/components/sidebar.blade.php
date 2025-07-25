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

            <!-- Dashboard -->
            {{-- <li>
                <a href="{{ route('dashboard.index') }}"
                    class="flex items-center px-4 py-2 rounded-lg transition hover:bg-indigo-100 {{ request()->routeIs('dashboard.index') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700' }}">
                    <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                    Dashboard
                </a>
            </li> --}}

            <!-- Kriteria -->
            <li>
                <a href="{{ route('kriteria.index') }}"
                    class="flex items-center px-4 py-2 rounded-lg transition hover:bg-indigo-100 {{ request()->routeIs('kriteria.*') || request()->routeIs('subkriteria.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700' }}">
                    <i class="fas fa-stream w-5 h-5 mr-3"></i>
                    Kriteria
                </a>
            </li>

            <!-- Vendor -->
            <li>
                <a href="{{ route('vendor.index') }}"
                    class="flex items-center px-4 py-2 rounded-lg transition hover:bg-indigo-100 {{ request()->routeIs('vendor.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700' }}">
                    <i class="fas fa-users w-5 h-5 mr-3"></i>
                    List Vendor
                </a>
            </li>

            <!-- Purchase Order -->
            <li>
                <a href="{{ route('purchase.index') }}"
                    class="flex items-center px-4 py-2 rounded-lg transition hover:bg-indigo-100 {{ request()->routeIs('purchase.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700' }}">
                    <i class="fas fa-file-invoice w-5 h-5 mr-3"></i>
                    List Purchase Order
                </a>
            </li>

            <!-- Kedatangan -->
            <li>
                <a href="{{ route('kedatangan.index') }}"
                    class="flex items-center px-4 py-2 rounded-lg transition hover:bg-indigo-100 {{ request()->routeIs('kedatangan.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700' }}">
                    <i class="fas fa-truck-loading w-5 h-5 mr-3"></i>
                    Kelola Kedatangan
                </a>
            </li>

            <!-- Rekomendasi -->
            <li>
                <a href="{{ route('rekomendasi.index') }}"
                    class="flex items-center px-4 py-2 rounded-lg transition hover:bg-indigo-100 {{ request()->routeIs('rekomendasi.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700' }}">
                    <i class="fas fa-thumbs-up w-5 h-5 mr-3"></i>
                    Rekomendasi
                </a>
            </li>

            <!-- Chat -->
            <li>
                @if (auth()->check())
                    @if (auth()->user()->isVendor())
                        <a href="{{ route('chat.index.vendor') }}"
                            class="flex items-center px-4 py-2 rounded-lg transition hover:bg-indigo-100 {{ request()->routeIs('chat.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700' }}">
                            <i class="fas fa-comments w-5 h-5 mr-3"></i>
                            Chat
                        </a>
                    @elseif(auth()->user()->isAdmin())
                        <a href="{{ route('chat.index') }}"
                            class="flex items-center px-4 py-2 rounded-lg transition hover:bg-indigo-100 {{ request()->routeIs('chat.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700' }}">
                            <i class="fas fa-comments w-5 h-5 mr-3"></i>
                            Chat
                        </a>
                    @endif
                @endif
            </li>

            <!-- Users -->
            <li>
                <a href="{{ route('users.index') }}"
                    class="flex items-center px-4 py-2 rounded-lg transition hover:bg-indigo-100 {{ request()->routeIs('users.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700' }}">
                    <i class="fas fa-user-cog w-5 h-5 mr-3"></i>
                    Users
                </a>
            </li>

        </ul>
    </nav>
</aside>
