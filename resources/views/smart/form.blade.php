@extends('layouts.app')

@section('title', 'Form SMART')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded">
    <h2 class="text-2xl font-bold mb-4">Form Input SMART</h2>

    <form method="POST" action="{{ route('smart.process') }}">
    @csrf
        <div>
            <label>Jumlah Alternatif:</label>
            <input type="number" name="jumlah_alternatif" value="3" readonly class="w-full border p-2">
        </div>
        <div>
            <label>Jumlah Kriteria:</label>
            <input type="number" name="jumlah_kriteria" value="3" readonly class="w-full border p-2">
        </div>

        <hr class="my-4">
        <h3 class="text-lg font-bold mb-2">Nilai Alternatif per Kriteria</h3>
        @for ($i = 0; $i < 3; $i++)
            <div class="mb-2">Alternatif {{ $i + 1 }}</div>
            @for ($j = 0; $j < 3; $j++)
                <div class="mb-1">
                    <label>Kriteria {{ $j + 1 }}:</label>
                    <input type="number" step="0.01" name="alternatives[{{ $i }}][{{ $j }}]" class="w-full border p-2">
                </div>
            @endfor
            <hr class="my-2">
        @endfor

        <h3 class="text-lg font-bold mt-4 mb-2">Bobot Kriteria</h3>
        @for ($j = 0; $j < 3; $j++)
            <div class="mb-2">
                <label>Bobot Kriteria {{ $j + 1 }}:</label>
                <input type="number" step="0.01" name="weights[]" class="w-full border p-2">
            </div>
        @endfor

        <h3 class="text-lg font-bold mt-4 mb-2">Tipe Kriteria</h3>
        @for ($j = 0; $j < 3; $j++)
            <div class="mb-2">
                <label>Tipe Kriteria {{ $j + 1 }} (1=Benefit, -1=Cost):</label>
                <input type="number" name="types[]" class="w-full border p-2">
            </div>
        @endfor

        <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2">Proses</button>
    </form>
</div>
@endsection
