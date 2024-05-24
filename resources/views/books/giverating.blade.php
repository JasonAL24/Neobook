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
                    <div class="row mt-3">
                        <div class="col fs-5 pb-2" style="margin-left: 6em;">
                            <div id="predefined-comments" class="mb-3" style="display: none;">
                                <b>Pilih alasan berikut:</b>
                                <div class="mt-2 btn-group row ms-1" role="group" aria-label="Predefined Comments">
                                    <input type="button" class="btn btn-outline-secondary predefined-comment col-auto" value="Ceritanya sangat menarik!">
                                    <input type="button" class="btn btn-outline-secondary predefined-comment col-auto" value="Saya sangat rekomendasi buku ini!">
                                    <input type="button" class="btn btn-outline-secondary predefined-comment col-auto" value="Karakter dalam cerita sangat menginspirasi!">
                                    <input type="button" class="btn btn-outline-secondary predefined-comment col-auto" value="Alur cerita sangat mendebarkan!">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col fs-4 pb-4" style="margin-left: 5em;">
                            <div class="mb-3 mt-4 position-relative komentar" style="width: 50vw;">
                                <textarea class="form-control" id="review" name="review" rows="3" maxlength="200" placeholder="Tulis komentar anda disini..."></textarea>
                                <div class="position-absolute bottom-0 end-0 me-3" style="pointer-events: none; font-size: 16px; opacity: 50%">
                                    <span id="char-count" class="">0/200</span>
                                </div>
                            </div>
                            <div class="d-flex flex-row" style="width: 50vw;">
                                <button type="submit" class="btn btn-secondary ms-auto mt-4" style="width: 8em;" id="submit-btn">Kirim</button>
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
                $('#char-count').text(charCount + '/200');
            });

            $('input[name="ratingnumber"]').on('change', function() {
                var rating = $(this).val();
                if (rating == 5) {
                    $('#predefined-comments').show();
                    $('#submit-btn').attr('disabled', true);
                } else {
                    $('#predefined-comments').hide();
                    $('#submit-btn').attr('disabled', false);
                }
            });

            $('.predefined-comment').on('click', function() {
                $(this).toggleClass('btn-outline-secondary btn-secondary');
                updateReview();
            });

            $('#review').on('input', function() {
                if ($(this).val().length > 0) {
                    $('#submit-btn').attr('disabled', false);
                } else {
                    $('#submit-btn').attr('disabled', true);
                }
            });

            function updateReview() {
                var selectedComments = [];
                $('.predefined-comment.btn-secondary').each(function() {
                    selectedComments.push($(this).val());
                });

                $('#review').val(selectedComments.join(' ') + (selectedComments.length ? ' ' : ''));
                var charCount = $('#review').val().length;
                $('#char-count').text(charCount + '/200');

                if (selectedComments.length > 0 || $('#review').val().length > 0) {
                    $('#submit-btn').attr('disabled', false);
                } else {
                    $('#submit-btn').attr('disabled', true);
                }
            }
        });
    </script>

@endsection
