@extends('layouts.app')

@section('title', 'Sub Kriteria')

@section('content')
<div class="max-w-5xl mx-auto p-6 bg-white shadow-md rounded">
    <!-- Breadcrumb -->
    <div class="mb-2 text-sm text-gray-500">
        <a href="{{ route('kriteria.index') }}" class="hover:underline">Home</a> >
        <a href="{{ route('kriteria.index') }}" class="hover:underline">Kriteria</a> >
        <span class="text-gray-700">Sub Kriteria</span>
    </div>

    <!-- Header and Add Button -->
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-gray-800">Sub Kriteria</h2>
        <a href="{{ route('subkriteria.create', ['kriteriaId' => request()->query('kriteriaId') ?? 1]) }}"
           class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded shadow text-sm">
            ➕ Tambah Sub Kriteria
        </a>
    </div>

    <!-- Table -->
    <div class="overflow-auto">
        <table class="min-w-full text-sm text-left text-gray-700 border border-gray-300 shadow rounded-lg">
            <thead class="bg-blue-50 text-gray-700 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-6 py-3 border border-gray-300 text-center">No</th>
                    <th class="px-6 py-3 border border-gray-300">Sub Kriteria</th>
                    <th class="px-6 py-3 border border-gray-300 text-center">Skor</th>
                    <th class="px-6 py-3 border border-gray-300 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($subkriterias as $index => $sub)
                <tr class="hover:bg-blue-100 transition duration-200">
                    <td class="px-6 py-3 border border-gray-300 text-center">{{ $loop->iteration }}</td>
                    <td class="px-6 py-3 border border-gray-300">{{ $sub->namaSubKriteria }}</td>
                    <td class="px-6 py-3 border border-gray-300 text-center">{{ $sub->skorSubKriteria }}</td>
                    <td class="px-6 py-3 border border-gray-300 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('subkriteria.edit', $sub->idSubKriteria) }}"
                               class="inline-flex items-center gap-1 bg-yellow-400 hover:bg-yellow-500 text-black px-3 py-1 rounded text-sm shadow">
                                ✏️ Edit
                            </a>
                            <form action="{{ route('subkriteria.destroy', $sub->idSubKriteria) }}"
                                method="POST"
                                data-delete-form>
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm shadow">
                                    🗑 Hapus
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-3 text-center text-gray-500">
                        Tidak ada data sub kriteria.
                    </td>
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

@section('scripts')
    @if(session('status') === 'stored')
        <script src="{{ asset('js/store_success.js') }}"></script>
    @endif

    @if(session('status') === 'updated')
        <script src="{{ asset('js/update.js') }}"></script>
    @endif

   <script src="{{ asset('js/delete.js') }}"></script>
@endsection
