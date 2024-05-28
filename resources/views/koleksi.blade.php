@extends('layouts.main')

@section('container')
    <div class="main-bg">
        <div class="white-container p-3">
            <h1 class="ms-5 p-4">Koleksi Bacaan Saat Ini</h1>
            @php
                $firstBook = $member->books->sortByDesc(function ($book) {
                            return optional($book->pivot)->updated_at ?? $book->created_at;
                        })->first();
            @endphp
            @if($firstBook)
                @foreach ($member->books->sortByDesc('pivot.updated_at') as $book)
                    <div class="row mt-5 p-4" style="background-color: white; width: 80vw; margin-left: 5vw">
                        <div class="col-auto">
                            <a href="/books/{{$book->id}}" class="text-decoration-none text-black">
                                <img onerror="this.onerror=null; this.src='/img/default_book.jpg';" src="/img/books/{{ $book['filename'] }}.jpg" alt="{{ $book['name'] }}" class="me-3 book-image">
                            </a>
                        </div>
                        <div class="col d-flex flex-column">
                            <div class="d-flex flex-row">
                                <h2><b>{{ $book->name }}</b></h2>
                                <button id="delete-book-{{ $book->id }}" class="btn btn-danger delete-book ms-4 ms-auto" data-book-id="{{ $book->id }}">
                                    <img src="/img/svg/trash.svg" alt="trash">
                                </button>
                            </div>
                            <div class="fw-bold mt-2 fs-5">{{ $book->author }}</div>
                            @php
                                $percentage = round(($book->pivot->last_page / $book->pages) * 100);
                                if ($percentage > 100) $percentage = 100;
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
            @else
                <div class="text-center">
                    <img src="/img/bacaan_not_found.png" alt="Bacaan Tidak Ada">
                    <h3><b>Anda Belum Memiliki Koleksi Bacaan</b></h3>
                </div>
                <div>
                    <h3 class="ms-5 mt-4">Ayo mulai baca dan simpan ke koleksi sekarang!</h3>
                    <div class="row ms-5">
                        @php $count = 0 @endphp
                        @foreach($books as $book)
                            @if ($count < 7)
                            <div class="col-auto me-auto">
                                <div class="text-center">
                                    <a class="no-blue" href="/books/{{$book['id']}}">
                                        <div class="book-container">
                                            <img onerror="this.onerror=null; this.src='/img/default_book.jpg';" src="/img/books/{{ $book['filename'] }}.jpg" alt="{{ $book['name'] }}" class="mb-3 book-image">
                                            <div class="overlay d-flex flex-column book-image">
                                                <img src="img/svg/look.svg" alt="look">
                                                <span class="text-overlay">Lihat</span>
                                            </div>
                                        </div>
                                    </a>
                                    <p class="book-name">{{ $book['name'] }}</p>
                                    @if($book->average_rating > 0)
                                        <div style="margin-top: -1em">
                                            <img src="/img/svg/star_yellow.svg" alt="star"> {{$book->average_rating}}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @php $count++ @endphp
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
            <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header d-flex flex-row" style="border-bottom: 0;">
                            <h5 class="modal-title" id="deleteConfirmationModalLabel">Konfirmasi Penghapusan</h5>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">
                            Apakah kamu yakin untuk menghapus buku ini dari koleksi?
                        </div>
                        <div class="modal-footer" style="border-top: 0;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteButton">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let bookIdToDelete = null; // Variable to store the book ID to delete

        // Add event listener to delete buttons
        @foreach ($member->books as $book)
        document.getElementById('delete-book-{{ $book->id }}').addEventListener('click', function() {
            bookIdToDelete = {{ $book->id }}; // Set the book ID to delete
            $('#deleteConfirmationModal').modal('show'); // Show the modal
        });
        @endforeach

        // Add event listener to the confirm delete button in the modal
        document.getElementById('confirmDeleteButton').addEventListener('click', function() {
            var isLastBook = $('.delete-book').length === 1;
            $.ajax({
                url: '{{ route("members.books.remove", ["member" => $member->id, "book" => $book->id]) }}',
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response.message);

                    $('#delete-book-' + {{$book->id}}).closest('.row').fadeOut(500, function() {
                        $(this).remove();
                    });
                    if (isLastBook) {
                        location.reload(); // Refresh the page if the last book is deleted
                    }
                    $('#deleteConfirmationModal').modal('hide'); // Hide the modal after deletion
                },
                error: function(xhr, status, error) {
                    console.error('Error removing book:', error);
                    $('#deleteConfirmationModal').modal('hide'); // Hide the modal on error
                }
            });
        });
    </script>
@endsection
