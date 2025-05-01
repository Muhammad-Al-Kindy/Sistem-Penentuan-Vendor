<aside class="w-64 bg-white text-black flex flex-col h-full">
    <div class="p-5 flex items-center space-x-3 border-b border-gray-700">
        <img src="{{ asset('assets/Logo-REKA--300x104.png') }}" alt="Logo Rekaindo" >
    </div>

    <nav class="mt-4 flex flex-col gap-2 px-4">
        <a href="#" class="py-2 px-4 rounded hover:bg-blue-300 {{ request()->routeIs('dokter.dashboard') ? 'bg-gray-800' : '' }}">
            <i class="ri-dashboard-line mr-2"></i> Dashboard
        </a>
        <a href="#" class="py-2 px-4 rounded hover:bg-blue-300 {{ request()->routeIs('dokter.data_dokter') ? 'bg-gray-800' : '' }}">
            <i class="ri-user-3-line mr-2"></i> Kriteria
        </a>
        <a href="#" class="py-2 px-4 rounded hover:bg-blue-300 {{ request()->routeIs('dokter.rekam_medis') ? 'bg-gray-800' : '' }}">
            <i class="ri-clipboard-line mr-2"></i> List Vendor
        </a>
        <a href="#" class="py-2 px-4 rounded hover:bg-blue-300 {{ request()->routeIs('dokter.rekam_medis') ? 'bg-gray-800' : '' }}">
            <i class="ri-clipboard-line mr-2"></i> List Purchase Order
        </a>
        <a href="#" class="py-2 px-4 rounded hover:bg-blue-300 {{ request()->routeIs('dokter.rekam_medis') ? 'bg-gray-800' : '' }}">
            <i class="ri-clipboard-line mr-2"></i> Kelola Kedatangan
        </a>
        <a href="#" class="py-2 px-4 rounded hover:bg-blue-300 {{ request()->routeIs('dokter.rekam_medis') ? 'bg-gray-800' : '' }}">
            <i class="ri-clipboard-line mr-2"></i> Rating
        </a>
        <a href="#" class="py-2 px-4 rounded hover:bg-blue-300 {{ request()->routeIs('dokter.rekam_medis') ? 'bg-gray-800' : '' }}">
            <i class="ri-clipboard-line mr-2"></i> Rekomendasi
        </a>
    </nav>
</aside>
