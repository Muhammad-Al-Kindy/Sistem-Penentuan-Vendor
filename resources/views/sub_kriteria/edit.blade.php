@extends('layouts.app')

@section('title', 'Edit Sub Kriteria')

@section('content')
<div id="app" data-subkriteria-url="{{ route('subkriteria.index') }}" class="max-w-7xl mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <div class="mb-4 text-sm text-gray-500">
        <a href="{{ route('kriteria.index') }}" class="hover:underline">Home</a> >
        <a href="{{ route('kriteria.index') }}" class="hover:underline">Kriteria</a> >
        <span class="text-gray-800 font-medium">Sub Kriteria</span>
    </div>

    <!-- Title -->
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Sub Kriteria</h2>

    <!-- Form -->
    <form action="{{ route('subkriteria.update', $subkriteria->idSubKriteria) }}" method="POST" class="space-y-6" data-update-form data-redirect-url="{{ route('subkriteria.index') }}">
        @csrf
        @method('PUT')

        <!-- Nama -->
        <div>
            <label for="namaSubKriteria" class="block text-sm font-semibold text-gray-700 mb-1">Nama</label>
            <input type="text" name="namaSubKriteria" id="namaSubKriteria"
                   value="{{ old('namaSubKriteria', $subkriteria->namaSubKriteria) }}"
                   class="w-full border border-gray-300 px-4 py-2 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-500"
                   required>
        </div>

        <!-- Skor -->
        <div>
            <label for="skorSubKriteria" class="block text-sm font-semibold text-gray-700 mb-1">Skor</label>
            <input type="number" step="0.01" name="skorSubKriteria" id="skorSubKriteria"
                   value="{{ old('skorSubKriteria', $subkriteria->skorSubKriteria) }}"
                   class="w-full border border-gray-300 px-4 py-2 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-500"
                   required>
        </div>

        <!-- Submit -->
        <div class="pt-4 flex justify-end">
            <button type="submit"
                    class="bg-black hover:bg-gray-800 text-white font-semibold py-2 px-6 rounded-md shadow text-sm">
                Update Sub Kriteria
            </button>
        </div>
    </form>
</div>
@endsection
