<h2 class="text-xl font-bold mb-4">Hasil Perhitungan SMART</h2>
<table class="table-auto border w-full mb-6">
    <thead class="bg-gray-200">
        <tr>
            <th class="px-4 py-2">Alternatif</th>
            @foreach ($result['subcriteria'] as $sub)
                <th class="px-4 py-2">{{ $sub }}</th>
            @endforeach
            <th class="px-4 py-2">Skor</th>
            <th class="px-4 py-2">Peringkat</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($result['scores'] as $i => $score)
            <tr>
                <td class="border px-4 py-2">Alternatif {{ $i + 1 }}</td>
                @foreach ($result['matrix'][$i] as $value)
                    <td class="border px-4 py-2">{{ $value }}</td>
                @endforeach
                <td class="border px-4 py-2">{{ $score }}</td>
                <td class="border px-4 py-2">{{ $result['ranking'][$i] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<h3 class="text-lg font-semibold">Alternatif Terbaik: {{ $result['best_alternative'] }}</h3>
