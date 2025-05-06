@extends('layouts.app')

@section('title', 'Sub Kriteria')

@section('content')
<div class="max-w-5xl mx-auto p-6 bg-white shadow-md rounded">
    <!-- Breadcrumb -->
    <div class="mb-2 text-sm text-gray-500">
        <a href="{{ route('kriteria.index') }}" class="hover:underline">Home</a> >
        <a href="{{ route('kriteria.index') }}" class="hover:underline">Kriteria</a> >
        Sub Kriteria
    </div>

    <!-- Header and Add Button -->
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Sub Kriteria</h2>
        <a href="{{ route('subkriteria.create', ['kriteriaId' => request()->query('kriteriaId') ?? 1]) }}"
            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
             Tambah Sub Kriteria
         </a>
    </div>

    <!-- Table -->
    <div class="overflow-auto">
        <table class="min-w-full bg-yellow-800 text-white rounded shadow text-center">
            <thead class="bg-yellow-900">
                <tr>
                    <th class="px-4 py-2">No</th>
                    <th class="px-4 py-2">Sub Kriteria</th>
                    <th class="px-4 py-2">Skor</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subkriterias as $index => $sub)
                <tr class="odd:bg-yellow-700 even:bg-yellow-600">
                    <td class="px-4 py-2">{{ $sub->idSubKriteria }}</td>
                    <td class="px-4 py-2">{{ $sub->namaSubKriteria }}</td>
                    <td class="px-4 py-2">{{ $sub->skorSubKriteria }}</td>
                    <td class="px-4 py-2">
                        <div class="flex justify-center gap-2">
                            <a href="#"
                               class="bg-yellow-400 hover:bg-yellow-500 text-black px-3 py-1 rounded">
                                ✏️
                            </a>
                            <form action="#"
                                  method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                    🗑
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-3 bg-yellow-700">Tidak ada data sub kriteria.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $subkriterias->links('pagination::tailwind') }}
    </div>
</div>
@endsection
