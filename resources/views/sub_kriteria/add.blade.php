@extends('layouts.app')

@section('title', 'Tambah Sub Kriteria')

@section('content')
<div id="app" data-subkriteria-url="{{ route('subkriteria.index') }}" class="max-w-7xl mx-auto px-4 py-8">
    <!-- Header and Back Button -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Tambah Sub Kriteria</h1>
    </div>

    <!-- Form -->
    <form action="{{ route('subkriteria.submit') }}" method="POST" class="space-y-6" data-store-form>
        @csrf
        <input type="hidden" name="kriteriaId" value="{{ $kriteria->idKriteria }}">

        <!-- Nama -->
        <div>
            <label for="namaSubKriteria" class="block text-sm font-semibold text-gray-700 mb-1">Nama Sub Kriteria</label>
            <input type="text" name="namaSubKriteria" id="namaSubKriteria"
                   class="w-full border border-gray-300 px-4 py-2 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-500"
                   placeholder="Contoh: Ketepatan waktu" required>
        </div>

        <!-- Skor -->
        <div>
            <label for="skorSubKriteria" class="block text-sm font-semibold text-gray-700 mb-1">Skor</label>
            <input type="number" step="0.01" name="skorSubKriteria" id="skorSubKriteria"
                   class="w-full border border-gray-300 px-4 py-2 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-500"
                   placeholder="Contoh: 5" required>
        </div>

        <!-- Submit & Back Buttons -->
        <div class="pt-4 flex justify-start gap-3">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-md shadow text-sm">
                💾 Simpan
            </button>
            <a href="{{ route('subkriteria.index', ['kriteriaId' => $kriteria->idKriteria]) }}"
            class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded shadow text-sm">
                ⬅ Kembali
            </a>
        </div>

    </form>
</div>
@endsection
