@if(count($results) > 0)
    @php $count = 0; @endphp
    @foreach($results as $book)
        @if($count < 2)
            <div class="mb-3">
                <a href="/books/{{$book['id']}}" class="d-flex align-items-center no-blue ms-2">
                    <img src="/img/books/{{ $book['filename'] }}.png" alt="{{ $book['name'] }}" class="me-3 book-image" style="width: 73px; height: 98px; object-fit: cover; border-radius: 5px;">
                    <div>
                        <h6 class="mb-1">{{$book->name}}</h6>
                        <p class="mb-0 text-muted">Penulis: {{ $book->author }}</p>
                        <p class="mb-0 text-muted">Rating: {{ $book->rating }}</p>
                    </div>
                </a>
            </div>
            @php $count++; @endphp
        @endif
    @endforeach
@else
    <div class="d-flex flex-column justify-content-center align-items-center" style="height: 26vh;">
        <img src="/img/svg/cancel.svg" alt="cancel">
        <p class="text-muted">No results found.</p>
    </div>
@endif