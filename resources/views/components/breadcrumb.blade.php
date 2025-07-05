<nav aria-label="breadcrumb" class="text-sm text-gray-500 mb-4">
    <ol class="list-reset flex">
        @foreach ($items as $index => $item)
            @if ($index + 1 === count($items))
                <li class="text-gray-800 font-semibold" aria-current="page">{{ $item['label'] }}</li>
            @else
                <li>
                    <a href="{{ $item['url'] }}" class="hover:underline">{{ $item['label'] }}</a>
                    <span class="mx-2">/</span>
                </li>
            @endif
        @endforeach
    </ol>
</nav>
