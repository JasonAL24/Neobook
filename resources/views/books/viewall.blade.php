@extends('layouts.main')

@section('container')
    <div class="main-bg">
        <h2>Ayo lanjutkan ceritamu!</h2>
        <h3 class="fw-bold mt-3 mb-4">Terpopuler</h3>
        <div class="row d-flex flex-row">
            <div class="col-lg-1 ms-3" style="margin-top: 20vh">
                <button class="btn btn-light rounded-circle" type="button" data-bs-target="#bookCarousel" data-bs-slide="prev" style="width: 64px; height: 64px">
                    {{--                <span class="carousel-control-prev-icon" aria-hidden="true"></span>--}}
                    <img src="/img/svg/arrow.svg" alt="arrow_left" style="width: 40px; height: 40px">
                </button>
            </div>
            <div id="bookCarousel" class="carousel slide col" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @php $count = 0 @endphp
                    @foreach($books->sortByDesc('average_rating')->take(16)->chunk(4) as $bookChunk)
                        <div class="carousel-item {{ $count == 0 ? 'active' : '' }}">
                            <div class="row">
                                @foreach($bookChunk as $book)
                                    <div class="col-auto me-auto">
                                        <div class="text-center d-flex flex-column book-box">
                                            <div>
                                                <a class="no-blue" href="/books/{{$book->id}}">
                                                    <div class="book-container">
                                                        <img onerror="this.onerror=null; this.src='/img/default_book.jpg';" src="/img/books/{{ $book->cover_image }}.jpg" alt="{{ $book->name }}" class="mb-3 book-image-lg">
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
                            </div>
                        </div>
                        @php $count++ @endphp
                    @endforeach
                </div>
            </div>
            <div class="col-lg-1 ms-3" style="margin-top: 20vh">
                <button class="btn btn-light rounded-circle" type="button" data-bs-target="#bookCarousel" data-bs-slide="next" style="width: 64px; height: 64px">
                    {{--                <span class="carousel-control-next-icon" aria-hidden="true"></span>--}}
                    <img src="/img/svg/arrow.svg" alt="arrow_right" style="transform: scaleX(-1); width: 40px; height: 40px">
                </button>
            </div>
        </div>


        <h3 class="fw-bold mt-3 mb-4">Semua</h3>
        <div class="row">
            @foreach($books as $book)
                <div class="col-auto me-4">
                    <div class="text-center d-flex flex-column">
                        <div>
                            <a class="no-blue" href="/books/{{$book->id}}">
                                <div class="book-container">
                                    <img onerror="this.onerror=null; this.src='/img/default_book.jpg';" src="/img/books/{{ $book->cover_image }}.jpg" alt="{{ $book->name }}" class="mb-3 book-image">
                                    <div class="overlay d-flex flex-column book-image">
                                        <img src="img/svg/look.svg" alt="look">
                                        <span class="text-overlay">Lihat</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div>
                            <p class="book-name">{{ $book->name }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
{{--<script>--}}
{{--        $(document).ready(function(){--}}
{{--            var currentIndex = 0;--}}
{{--            var totalBooks = $(".book-box").length;--}}

{{--            $("#prevItem").click(function(){--}}
{{--                currentIndex--;--}}
{{--                if (currentIndex < 0) {--}}
{{--                    currentIndex = 0;--}}
{{--                }--}}
{{--                updateBooks();--}}
{{--            });--}}

{{--            $("#nextItem").click(function(){--}}
{{--                currentIndex++;--}}
{{--                if (currentIndex >= totalBooks) {--}}
{{--                    currentIndex = totalBooks;--}}
{{--                }--}}
{{--                updateBooks();--}}
{{--            });--}}

{{--            function updateBooks() {--}}
{{--                $(".book-box").fadeOut(function() {--}}
{{--                    // Show the books in the range of currentIndex to currentIndex + 4--}}
{{--                    for (var i = 0; i < 4; i++) {--}}
{{--                        var index = currentIndex + i;--}}
{{--                        $(".book-box").eq(index).fadeIn();--}}
{{--                    }--}}

{{--                    // Disable or enable the "Next" button based on currentIndex--}}
{{--                    $("#nextItem").prop("disabled", currentIndex >= totalBooks - 4);--}}
{{--                    // Disable or enable the "Previous" button based on currentIndex--}}
{{--                    $("#prevItem").prop("disabled", currentIndex <= 0);--}}
{{--                });--}}
{{--            }--}}

{{--            updateBooks();--}}
{{--        });--}}
{{--    </script>--}}


@endsection
