@extends('layouts.main')

@section('container')
    <div class="main-bg">
        <div class="white-container p-3">
            <h1 class="ms-5 p-4">Bacaan Saat Ini</h1>
            @foreach ($member->books->sortByDesc('pivot.updated_at') as $book)
                    <div class="row mt-5 p-4" style="background-color: white; width: 80vw; margin-left: 5vw">
                        <div class="col-lg-1">
                            <a href="/books/{{$book->id}}" class="text-decoration-none text-black">
                                <img src="/img/books/{{ $book['filename'] }}.png" alt="{{ $book['name'] }}" class="me-3 book-image">
                            </a>
                        </div>
                        <div class="col ms-5 d-flex flex-column">
                            <div class="d-flex flex-row">
                                <h2><b>{{ $book->name }}</b></h2>
                                <button id="delete-book-{{ $book->id }}" class="btn btn-danger delete-book ms-4 ms-auto" data-book-id="{{ $book->id }}">
                                    <img src="/img/svg/trash.svg" alt="trash">
                                </button>
                            </div>
                            <div class="fw-bold mt-2 fs-5">{{ $book->author }}</div>
                            @php
                                $percentage = round(($book->pivot->last_page / $book->pages) * 100);
                            @endphp
                            <div class="mt-auto fs-5">
                                <b>Progress</b>
                            </div>
                            <div class="d-flex flex-row align-items-center mt-2 mb-2">
                                <div style="font-family: 'Inter', sans-serif; width: 30px">{{$percentage}}%</div>
                                <div class="progress ms-4" style="height: 15px; width: 50vw; background-color: lightgray">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%; background-color: gray" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="ms-3" style="font-family: 'Inter', sans-serif">{{ $book->pivot->last_page }}/{{ $book->pages }} halaman</div>
                            </div>
                            <div class="border border-1 mt-2 rounded-4 border-custom">
                                <a href="/books/{{$book->id}}/read?startPage={{$book->pivot->last_page}}" class="no-blue">
                                    <div class="text-center">
                                        Mulai Baca
                                        <img src="/img/svg/read_arrow.svg" alt="arrow">
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

            @endforeach
        </div>
    </div>
    <script>
        // Add event listener to delete buttons
        @foreach ($member->books as $book)
        document.getElementById('delete-book-{{ $book->id }}').addEventListener('click', function() {
            var bookId = this.getAttribute('data-book-id');
            if (confirm('Apakah kamu yakin untuk menghapus buku ini?')) {
                $.ajax({
                    url: '{{ route("members.books.remove", ["member" => $member->id, "book" => $book->id]) }}',
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response.message);

                        $('#delete-book-{{ $book->id }}').closest('.row').fadeOut(500, function() {
                            $(this).remove();
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error removing book:', error);
                    }
                });
            }
        });
        @endforeach
    </script>
@endsection
