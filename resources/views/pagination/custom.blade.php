@if ($paginator->hasPages())
    <nav>
        <ul class="pagination justify-content-center">
            {{-- Кнопка "Предыдущая" --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link pink-pagination">‹</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link pink-pagination" href="{{ $paginator->previousPageUrl() }}" rel="prev">‹</a>
                </li>
            @endif

            {{-- Нумерация страниц --}}
            @foreach ($elements as $element)
                {{-- "Троеточие" --}}
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link pink-pagination">{{ $element }}</span></li>
                @endif

                {{-- Ссылки на страницы --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <span class="page-link pink-pagination-active">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link pink-pagination" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Кнопка "Следующая" --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link pink-pagination" href="{{ $paginator->nextPageUrl() }}" rel="next">›</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link pink-pagination">›</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
<style>
    /* Стили для пагинации */
.pagination .page-link {
    color: #ffffff;
    background-color: #f8d7da; /* Розовый фон */
    border: 1px solid #f5c6cb;
    padding: 8px 12px;
    border-radius: 10%;
    margin: 0 5px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.pagination .page-link:hover {
    background-color: #f5c6cb; /* Более насыщенный розовый */
    color: #212529;
    border-color: #f1b0b7;
}

.pagination .page-item.active .page-link {
    background-color: #f06292; /* Темно-розовый */
    color: #fff;
    border-color: #ec407a;
}

.pagination .page-item.disabled .page-link {
    background-color: #f8f9fa; /* Светло-серый */
    color: #6c757d;
    border-color: #dee2e6;
    cursor: not-allowed;
}
    </style>    