@extends('layouts.app')

@section('title', 'Kriteria')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-500 mb-6">
            <a href="#" class="hover:underline">Home</a>
            <span class="mx-2">/</span>
            <span>Kriteria</span>
        </nav>

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Kriteria</h1>
        </div>

        <div class="mb-4">
            <!-- Search Form -->
            <form method="GET" action="{{ route('kriteria.index') }}" class="mb-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search kriteria..."
                    class="w-1/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
                <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    🔍 Cari
                </button>
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100 text-gray-600 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">No</th>
                        <th class="px-6 py-3 text-left">Kriteria</th>
                        <th class="px-6 py-3 text-left">Bobot</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 ">
                    @forelse($kriterias as $index => $kriteria)
                        <tr class="hover:bg-blue-100 transition duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $kriterias->firstItem() + $index }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $kriteria->namaKriteria }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $kriteria->bobot }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <a href="{{ route('subkriteria.index', ['kriteriaId' => $kriteria->idKriteria]) }}"
                                    class="inline-flex items-center bg-yellow-400 hover:bg-yellow-500 text-black px-3 py-1 rounded text-sm font-semibold">
                                    <i class="ri-edit-box-line mr-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada data kriteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $kriterias->links('pagination::tailwind') }}
        </div>
    </div>
@endsection
