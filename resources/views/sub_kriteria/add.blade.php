@extends('layouts.app')

@section('title', 'Tambah Sub Kriteria')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white shadow-md rounded">
    <!-- Breadcrumb -->
    <div class="mb-4 text-sm text-gray-500">
        <a href="{{ route('kriteria.index') }}" class="hover:underline">Home</a> >
        <a href="{{ route('kriteria.index') }}" class="hover:underline">Kriteria</a> >
        Sub Kriteria
    </div>

    <!-- Title -->
<h2 class="text-2xl font-bold mb-6">Sub Kriteria</h2>

<!-- Form -->
<form action="{{ route('subkriteria.submit') }}" method="POST" class="space-y-6">
    @csrf

    <input type="hidden" name="kriteriaId" value="{{ $kriteria->idKriteria }}">


    <!-- Nama -->
    <div>
        <label for="namaSubKriteria" class="block text-lg font-medium text-gray-700 mb-1">Nama</label>
        <input type="text" name="namaSubKriteria" id="namaSubKriteria"
               class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring focus:border-blue-500"
               required>
    </div>

    <!-- Skor -->
    <div>
        <label for="skorSubKriteria" class="block text-lg font-medium text-gray-700 mb-1">Skor</label>
        <input type="number" step="0.01" name="skorSubKriteria" id="skorSubKriteria"
               class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring focus:border-blue-500"
               required>
    </div>

    <!-- Submit -->
    <div>
        <button type="submit"
                class="bg-black text-white px-6 py-2 rounded hover:bg-gray-800 transition">
            Buat Sub Kriteria
        </button>
    </div>
</form>

</div>
@endsection
