@extends('layouts.app')

@section('title', 'Form SMART')

@section('content')
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded">
        <h2 class="text-2xl font-bold mb-4">Form Input SMART</h2>

        <form method="POST" action="{{ route('smart.process') }}">
            @csrf
            <h3 class="text-lg font-bold mb-2">Pilih Subkriteria untuk Setiap Alternatif</h3>
            @php
                $jumlahAlternatif = 3;
                $subkriteriaList = [
                    'Delivery Time' => [
                        'Tepat waktu / lebih cepat' => 3,
                        'Terlambat 1–14 hari' => 2,
                        '>14 hari' => 1,
                    ],
                    'Monitoring' => [
                        'Respon Baik' => 3,
                        'Respon Cukup' => 2,
                        'Respon Buruk' => 1,
                    ],
                    'Kualitas' => [
                        'Sangat Baik (100%)' => 3,
                        'Cukup (81–99%)' => 2,
                        'Kurang (<80%)' => 1,
                    ],
                    'Respon NC' => [
                        '1 Hari' => 3,
                        '3 Hari' => 2,
                        '< 5 Hari' => 1,
                    ],
                    'PO Batal' => [
                        'Pertimbangan REKA' => 3,
                        'Respon Vendor Buruk' => 2,
                        'Vendor Gagal Memenuhi' => 1,
                    ],
                ];
                $kriteriaKeys = array_keys($subkriteriaList);
            @endphp

            @for ($i = 0; $i < $jumlahAlternatif; $i++)
                <div class="mb-4 p-4 border rounded">
                    <h4 class="font-semibold mb-2">Alternatif {{ $i + 1 }}</h4>
                    @foreach ($kriteriaKeys as $index => $kriteria)
                        <label class="block text-sm font-medium">{{ $kriteria }}</label>
                        <select name="alternatives[{{ $i }}][{{ $index }}]" class="w-full border p-2 mb-3">
                            @foreach ($subkriteriaList[$kriteria] as $label => $value)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    @endforeach
                </div>
            @endfor

            <h3 class="text-lg font-bold mt-4 mb-2">Bobot Kriteria</h3>
            @foreach ($kriteriaKeys as $key)
                <div class="mb-2">
                    <label>Bobot {{ $key }}:</label>
                    <input type="number" step="0.01" name="weights[]" class="w-full border p-2">
                </div>
            @endforeach

            <input type="hidden" name="subcriteria" value='@json($kriteriaKeys)'>

            <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2">Proses SMART</button>
        </form>

    </div>
@endsection
