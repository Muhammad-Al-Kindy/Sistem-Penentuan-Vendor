@extends('layouts.app')

@section('title', 'Form SMART')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded">
    <h2 class="text-2xl font-bold mb-4">Form Input SMART</h2>

    <form action="{{ route('smart.process') }}" method="POST">
        @csrf

        <h3 class="text-lg font-semibold mb-2">Matrix Alternatif vs Kriteria</h3>

        @php
            $jumlahAlternatif = 3; // ubah sesuai kebutuhan
            $jumlahKriteria = 3;
        @endphp

        @for ($i = 0; $i < $jumlahAlternatif; $i++)
            <div class="mb-2 font-semibold text-blue-700">Alternatif {{ $i + 1 }}</div>
            <div class="grid grid-cols-1 md:grid-cols-{{ $jumlahKriteria }} gap-4 mb-4">
                @for ($j = 0; $j < $jumlahKriteria; $j++)
                    <div>
                        <label for="alternatives[{{ $i }}][{{ $j }}]" class="block text-sm">Kriteria {{ $j + 1 }}</label>
                        <input type="number" step="0.01" name="alternatives[{{ $i }}][{{ $j }}]" class="w-full border border-gray-300 px-3 py-2 rounded" required>
                    </div>
                @endfor
            </div>
        @endfor

        <hr class="my-4">

        <h3 class="text-lg font-semibold mb-2">Bobot Kriteria</h3>
        <div class="grid grid-cols-1 md:grid-cols-{{ $jumlahKriteria }} gap-4 mb-4">
            @for ($j = 0; $j < $jumlahKriteria; $j++)
                <div>
                    <label for="weights[]" class="block text-sm">Bobot Kriteria {{ $j + 1 }}</label>
                    <input type="number" step="0.01" name="weights[]" class="w-full border border-gray-300 px-3 py-2 rounded" required>
                </div>
            @endfor
        </div>

        <h3 class="text-lg font-semibold mb-2">Tipe Kriteria</h3>
        <div class="grid grid-cols-1 md:grid-cols-{{ $jumlahKriteria }} gap-4 mb-4">
            @for ($j = 0; $j < $jumlahKriteria; $j++)
                <div>
                    <label for="types[]" class="block text-sm">Tipe Kriteria {{ $j + 1 }} (1=Benefit, -1=Cost)</label>
                    <input type="number" name="types[]" class="w-full border border-gray-300 px-3 py-2 rounded" required>
                </div>
            @endfor
        </div>

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">
            Proses SMART
        </button>
    </form>
</div>
@endsection
