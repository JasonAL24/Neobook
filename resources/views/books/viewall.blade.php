@extends('layouts.main')

@section('container')
    <div class="main-bg">
        <h2>Ayo lanjutkan ceritamu!</h2>
        <h3 class="fw-bold mt-3">Terpopuler</h3>
        <div class="row">
            <div class="col-lg-1 ms-3" style="margin-top: 20vh">
                <button id="prevItem" class="btn btn-light rounded-circle" style="width: 64px; height: 64px">
                    <img src="/img/svg/arrow.svg" alt="arrow_left" style="width: 40px; height: 40px">
                </button>
            </div>
            @foreach($books as $book)
                <div class="col-auto me-auto book-box">
                    <div class="text-center d-flex flex-column">
                        <div>
                            <a class="no-blue" href="/books/{{$book->id}}">
                                <div class="book-container">
                                    <img src="/img/books/{{ $book->filename}}.png" alt="{{ $book->name }}" class="mb-3 book-image-lg">
                                    <div class="overlay d-flex flex-column book-image-lg">
                                        <img src="img/svg/look.svg" alt="look">
                                        <span class="text-overlay">Lihat</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div>
                            <p class="book-name-lg">{{ $book->name }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="col-lg-1 me-3" style="margin-top: 20vh">
                <button id="nextItem" class="btn btn-light rounded-circle" style="width: 64px; height: 64px">
                    <img src="/img/svg/arrow.svg" alt="arrow_right" style="transform: scaleX(-1); width: 40px; height: 40px">
                </button>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            var currentIndex = 0;
            var totalBooks = $(".book-box").length;

            $("#prevItem").click(function(){
                currentIndex--;
                if (currentIndex < 0) {
                    currentIndex = 0;
                }
                updateBooks();
            });

            $("#nextItem").click(function(){
                currentIndex++;
                if (currentIndex >= totalBooks) {
                    currentIndex = totalBooks;
                }
                updateBooks();
            });

            function updateBooks() {
                $(".book-box").hide();
                for (var i = 0; i < 4; i++) {
                    var index = currentIndex + i;
                    $(".book-box").eq(index).show();
                }

                // Disable or enable the "Next" button based on currentIndex
                $("#nextItem").prop("disabled", currentIndex >= totalBooks - 4);
                // Disable or enable the "Previous" button based on currentIndex
                $("#prevItem").prop("disabled", currentIndex <= 0);
            }

            updateBooks();
        });
    </script>


@endsection
