@extends('layouts.main')

@section('container')
    <div class="main-bg">
        <div class="white-container p-3">
            <h1 class="ms-5 p-4">Penilaian</h1>
            @if($books)
                @foreach ($books as $book)
                    <div class="row mt-5 p-4" style="background-color: white; width: 80vw; margin-left: 5vw">
                        <div class="col-auto">
                            <a href="/books/{{$book->id}}" class="text-decoration-none text-black">
                                <img src="/img/books/{{ $book['filename'] }}.png" alt="{{ $book['name'] }}" class="me-3 book-image">
                            </a>
                        </div>
                        <div class="col d-flex flex-column">
                            <div class="d-flex flex-row">
                                <h3><b>{{ $book->name }}</b></h3>
                            </div>
                            <div class="fw-bold mt-1 fs-5">{{ $book->author }}</div>
                            <div class="mt-auto fs-5">
                                <b>Penilaian</b>
                                <p>{{count($book->ratings)}} Pengguna</p>
                            </div>
                            <div class="d-flex flex-row align-items-center">
                                <div class="rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="star {{ $i <= $book->average_rating ? 'filled' : '' }}"></span>
                                    @endfor
                                </div>
                                <div style="font-size: 20px" class="ms-1">
                                    <strong>{{$book->average_rating}}/5</strong>
                                </div>
                                <button class="btn expand-reviews ms-4" onclick="toggleReviews({{ $book->id }})">
                                    Lihat Komentar
                                    <img id="expand-img-{{ $book->id }}" class="expand-img" src="/img/svg/expand.svg" alt="expand">
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="member-reviews-{{ $book->id }}" class="member-reviews hidden" style="background-color: white; width: 80vw; margin-left: 5vw">
                        @foreach ($book->ratings as $rating)
                            @php
                                $member = $rating->member;
                                $profile_picture = $member->profile_picture;
                            @endphp
                            <div class="d-flex flex-row pb-4" style="margin-left: 3vw;">
                                <div>
                                    @if ($member->profile_picture)
                                        <img src="/img/profile/{{$member->id}}/{{$profile_picture}}" alt="profile picture" style="width: 56px; height: 56px" class="rounded-circle">
                                    @else
                                        <img src="/img/profile/default_pp.png" alt="profile picture" style="width: 56px; height: 56px" class="rounded-circle">
                                    @endif
                                </div>
                                <div class="ms-4">
                                    <div class="d-flex flex-row">
                                        <div><b>{{$member->name}} </b> </div>
                                        <div class="ms-3 text-secondary">Diunggah {{ $rating->created_at->diffForHumans()}}</div>
                                    </div>
                                    <div>{{ $rating->review }}</div>
                                    <div class="mt-2"><img src="/img/svg/star_yellow.svg" alt="star"> {{ $rating->rating }}/5</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @else
                <div class="text-center">
                    <img src="/img/what1.png" alt="Not Found">
                    <h3><b>Belom ada rating</b></h3>
                </div>
            @endif
        </div>
    </div>
    <script>
        function toggleReviews(bookId) {
            const reviewsSection = document.getElementById(`member-reviews-${bookId}`);
            if (reviewsSection) {
                reviewsSection.classList.toggle('hidden');
            }
            const expandImg = document.getElementById(`expand-img-${bookId}`);
            if (expandImg) {
                expandImg.classList.toggle('expand-img');
            }
        }
    </script>
@endsection
