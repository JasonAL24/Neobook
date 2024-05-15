@extends('layouts.main')

@section('container')
    <div class="main-bg">
        <div class="ms-5">
            <div class="container">
                <div class="row" style="height: 300px">
                    <div class="col-lg-4 offset-md-1" style="height: 115%">
                        <img src="/img/books/{{$book->filename}}.png" alt="Book Image" class="book-detail-image">
                    </div>
                    <div class="col-lg-7 justify-content-between" style="width: 30%">
                        <h1><strong>{{ $book->name }}</strong></h1>
                        <h2 class="mt-5">{{ $book->author }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="container" style="background-color: #FDFCF7">
            <div class="row p-5" style="height: 25vh;">
            </div>
            @if($rating)
                <div class="row">
                    <div class="col fs-4 pb-5" style="margin-left: 5em; height: 25vh;">
                        <b>Terima kasih telah membaca bukunya!</b>
                    </div>
                </div>
            @else
                <form method="POST" action="{{ route('books.createrating') }}">
                    <div class="row">
                        <div class="col fs-4 pb-2" style="margin-left: 5em;">
                            <b>Apakah Anda menyukai buku tersebut?</b>
                            <p>Ayo berikan penilaian dan tinggalkan komentar anda</p>
                                @csrf
                                <input type="hidden" name="member_id" value="{{ auth()->user()->member->id }}">
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <div class="mb-3">
                                    <div class="star-rating">
                                        <input type="radio" id="star5" name="ratingnumber" value="5"><label for="star5"></label>
                                        <input type="radio" id="star4" name="ratingnumber" value="4"><label for="star4"></label>
                                        <input type="radio" id="star3" name="ratingnumber" value="3"><label for="star3"></label>
                                        <input type="radio" id="star2" name="ratingnumber" value="2"><label for="star2"></label>
                                        <input type="radio" id="star1" name="ratingnumber" value="1"><label for="star1"></label>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col fs-4 pb-4" style="margin-left: 5em;">
                            <div class="mb-3 mt-4 position-relative komentar" style="width: 50vw;">
                                <textarea class="form-control" id="review" name="review" rows="3" maxlength="100" placeholder="Tulis komentar anda disini..."></textarea>
                                <div class="position-absolute bottom-0 end-0 me-3" style="pointer-events: none; font-size: 16px; opacity: 50%">
                                    <span id="char-count" class="">0/100</span>
                                </div>
                            </div>
                            <div class="d-flex flex-row" style="width: 50vw;">
                                <button type="submit" class="btn btn-secondary ms-auto mt-4" style="width: 8em;">Kirim</button>
                            </div>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#review').on('input', function() {
                var charCount = $(this).val().length;
                $('#char-count').text(charCount + '/100');
            });
        });
    </script>

@endsection
