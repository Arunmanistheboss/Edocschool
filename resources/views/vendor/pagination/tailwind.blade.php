@if ($paginator->hasPages())
    <nav role="navigation" class="flex items-center justify-center space-x-1" aria-label="Pagination Navigation">
        {{-- ◀ Précédent --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-2 text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">
                <x-icons.left />
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-100">
                <x-icons.left />
            </a>
        @endif

        @php
            $currentPage = $paginator->currentPage();
            $lastPage = $paginator->lastPage();

            $range = 1; // Nombre de pages visibles de chaque côté
            $start = max(1, $currentPage - $range);
            $end = min($lastPage, $currentPage + $range);
        @endphp

        {{-- 🔢 Première page toujours visible --}}
        @if ($start > 1)
            <a href="{{ $paginator->url(1) }}" class="px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-100">1</a>
            @if ($start > 2)
                <span class="px-2 text-gray-400">...</span>
            @endif
        @endif

        {{-- 🔢 Pages centrales --}}
        @for ($i = $start; $i <= $end; $i++)
            @if ($i == $currentPage)
                <span class="px-3 py-2 font-bold text-white bg-blue-500 rounded-md">{{ $i }}</span>
            @else
                <a href="{{ $paginator->url($i) }}" class="px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-100">{{ $i }}</a>
            @endif
        @endfor

        {{-- 🔢 Dernière page toujours visible --}}
        @if ($end < $lastPage)
            @if ($end < $lastPage - 1)
                <span class="px-2 text-gray-400">...</span>
            @endif
            <a href="{{ $paginator->url($lastPage) }}" class="px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-100">{{ $lastPage }}</a>
        @endif

        {{-- ▶ Suivant --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-100">
                <x-icons.right />
            </a>
        @else
            <span class="px-3 py-2 text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">
                <x-icons.right />
            </span>
        @endif
    </nav>
@endif