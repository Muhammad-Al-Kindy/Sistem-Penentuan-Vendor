<h2 class="text-xl font-bold mb-4">Hasil Perhitungan SMART</h2>
<ul class="list-disc pl-5">
    @foreach ($result['scores'] as $index => $score)
        <li>Alternatif {{ $index + 1 }}: {{ $score }}</li>
    @endforeach
</ul>
