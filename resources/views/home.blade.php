@extends('layouts.main')

@section('container')
<div class="home">
    <div class="row">
        {{-- Left Column --}}
        <div class="col-auto">
            <div class="home-bg">
                <p style="font-size: 43px">Selamat membaca, {{ explode(' ', $member->name)[0] }}</p>
                @php
                    $firstBook = $member->books->sortByDesc(function ($book) {
                        return optional($book->pivot)->updated_at ?? $book->created_at;
                    })->first();

                    $last_page = 1;
                    $total_page = 1;
                    $percentage = 0;

                    if ($firstBook && $firstBook->pivot) {
                        $last_page = $firstBook->pivot->last_page ?? 1;
                        $total_page = $firstBook->pages ?? 1;
                        $percentage = round(($last_page / $total_page) * 100);
                        if ($percentage > 100) $percentage = 100;
                    }
                @endphp
                @if($firstBook)
                <p style="font-size: 32px">Mau melanjutkan bacaan kamu?</p>
                <div class="container">
                    <div class="row">
                        <div class="col-auto">
                            <img class="img-shadow img-large" src="/img/books/{{$firstBook->filename}}.png" alt="{{$firstBook->name}}">
                        </div>
                        <div class="col">
                            <div class="d-flex flex-column flex-fill">
                                <p class="fw-bold fs-4">{{$firstBook->name}}</p>
                                <div class="box mt-3">
                                    <div class="title">Progress Baca</div>
                                    <div class="d-flex flex-row mt-3">
                                        <div class="percentage">{{$percentage}}% ({{$last_page}}/{{$total_page}} halaman)</div>
{{--                                        <div class="time-left ms-auto">2 Hari</div>--}}
                                    </div>
                                    <div class="progress" role="progressbar" aria-label="Read Progress" aria-valuenow="{{$percentage}}" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar" style="background: #252734; width: {{$percentage}}%"></div>
                                    </div>
                                </div>
                                <div class="border border-1 mt-4 rounded-4 border-custom button-shadow">
                                    <a href="/books/{{$firstBook->id}}/read?startPage={{$last_page}}" class="no-blue">
                                        <div class="text-center">
                                            Mulai Baca
                                            <img src="/img/svg/read_arrow.svg" alt="arrow">
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <p class="fw-semibold mt-3" style="font-size: 32px">Buku Kami</p>
                <div class="container">
                    <div class="row">
                        @php $count = 0 @endphp
                        @foreach ($books as $book)
                            @if ($count < 4)
                                <div class="col-auto me-auto">
                                    <div class="text-center">
                                        <a class="no-blue" href="/books/{{$book->id}}">
                                            <div class="book-container">
                                                <img src="/img/books/{{ $book->filename }}.png" alt="{{ $book->name }}" class="mb-3 book-image">
                                                <div class="overlay d-flex flex-column book-image">
                                                    <img src="img/svg/look.svg" alt="look">
                                                    <span class="text-overlay">Lihat</span>
                                                </div>
                                            </div>
                                        </a>
                                        <p class="book-name">{{ $book->name }}</p>
                                    </div>
                                </div>
                                @php $count++ @endphp
                            @endif
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col d-flex flex-row">
                            <div class="ms-auto me-3">
                                <a href="{{route('books.viewall')}}" class="no-blue">
                                    Selengkapnya >>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                    $hasCerpen = false;
                @endphp

                @foreach ($books as $book)
                    @if($book['category'] == 'cerpen')
                        @php
                            $hasCerpen = true;
                            break;
                        @endphp
                    @endif
                @endforeach

                @if($hasCerpen)
                    <p class="fw-semibold mt-3" style="font-size: 32px">Karya Tulis Orisinil</p>
                    <div class="container">
                        <div class="row">
                        @php $count = 0 @endphp
                        @foreach ($books as $book)
                                @if($book['category'] == 'cerpen' && $count < 4)
                                    <div class="col-auto me-auto">
                                        <div class="text-center">
                                            <a class="no-blue" href="/books/{{$book->id}}">
                                                <div class="book-container">
                                                    <img src="/img/books/{{ $book->filename}}.png" alt="{{ $book->name }}" class="img-fluid mb-3 book-image">
                                                    <div class="overlay d-flex flex-column">
                                                        <img src="img/svg/look.svg" alt="look">
                                                        <span class="text-overlay">Lihat</span>
                                                    </div>
                                                </div>
                                            </a>
                                            <p class="book-name">{{ $book->name }}</p>
                                        </div>
                                    </div>
                                    @php $count++ @endphp
                                @endif
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col d-flex flex-row">
                                <div class="ms-auto me-3">
                                    <a href="{{route('books.viewall')}}" class="no-blue">
                                        Selengkapnya >>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        {{-- Right Column --}}
        <div class="col bg-color-white ms-5">
            <div class="container">
                <h2 class="mb-3">Forum Diskusi</h2>
                <div class="container font-size-18">
                    <div class="row">
                        <div class="col-auto">
                            <img src="img/profile_picture_mike.png" alt="Profile Picture of Mike">
                        </div>
                        <div class="col">
                            <div class="row align-items-center">
                                <div class="col">
                                    Mike
                                    <img src="img/svg/checkmark.svg" alt="Checkmark">
                                </div>
                            </div>
                            <div class="row row-custom-size mt-1">
                                <div class="col">
                                    <strong>Buku Harry Potter yang baru mau rilis!!</strong>
                                </div>
                            </div>
                            <div class="row row-custom-size mt-1">
                                <div class="col">
                                    Hype parah sih, jadi inget buku terakhirnya seru abis, apalagi pas bagian le..
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col">
                                    <img src="img/svg/heart.svg" alt="like"> 14
                                    <img src="img/svg/comment.svg" alt="comment" class="ms-3"> 9
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3"></div>
                <div class="container font-size-18">
                    <div class="row">
                        <div class="col-auto">
                            <img src="img/profile_picture_hannah.png" alt="Profile Picture of Hannah">
                        </div>
                        <div class="col">
                            <div class="row align-items-center">
                                <div class="col">
                                    Hannah
                                    <img src="img/svg/checkmark.svg" alt="Checkmark">
                                </div>
                            </div>
                            <div class="row row-custom-size mt-1">
                                <div class="col">
                                    <strong>Just finished "American Wolf" by Nate Blakeslee and loved every minute of it</strong>
                                </div>
                            </div>
                            <div class="row row-custom-size mt-1">
                                <div class="col">
                                    I just finished reading American Wolf by Nate Blakeslee and it was really good. I am surprised...
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col">
                                    <img src="img/svg/heart.svg" alt="like"> 40
                                    <img src="img/svg/comment.svg" alt="comment" class="ms-3"> 21
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container mt-5">
                <div class="d-flex flex-row align-items-center">
                    <h2 class="mt-1">Obrolan Grup</h2>
                    <div class="border ms-2" style="background-color: yellow; width: 9em; border-radius: 30px; height: 1.6em;">
                        <img src="img/svg/checkmark.svg" alt="Checkmark">
                        Fitur Premium!
                    </div>
                </div>
                <div class="container font-size-18 mt-3">
                    @if ($isMemberPremium)
                    @php $countChat = 0 @endphp
                    @foreach($communitiesWithLastMessage as $communityChat)
                        @if($countChat < 3)
                            <div class="row mb-4 align-items-center">
                                <div class="col-auto">
                                    <a href="/komunitas/{{$communityChat->id}}">
                                        @if($communityChat->profile_picture)
                                            <img src="/img/communities/profile_picture/{{$communityChat->id}}/{{$communityChat->profile_picture}}"
                                                 alt="{{$communityChat->name}}" class="rounded-circle profile-picture">
                                        @else
                                            <img src="/img/communities/profile_picture/default_profile_picture.png"
                                                 alt="Default Group Picture" class="profile-picture rounded-circle">
                                        @endif
                                    </a>
                                </div>
                                <div class="col d-flex flex-column">
                                    <strong>{{$communityChat->name}}</strong>
                                    @if($communityChat->lastMessage)
                                        <small><strong>{{$communityChat->lastMessage->member->name}}:</strong> {{ $communityChat->lastMessage->content }}</small>
                                    @else
                                        <small>No messages yet.</small>
                                    @endif
                                </div>
                            </div>
                            @php $countChat++ @endphp
                        @endif
                    @endforeach
                    @else
                        <span>Langganan premium sekarang untuk membuka fitur ini!</span>
                    @endif
                </div>
            </div>
            <div class="container mt-5">
                <h2 class="mb-1">Penilaian</h2>
                @php
                    $count = 0;
                @endphp
                <div class="row pb-3">
                    @foreach ($booksWithRating->shuffle() as $book_rating)
                        @php
                            $latestRating = $book_rating->ratings()->latest()->first();
                        @endphp
                        @if($count < 3)
                        <div class="mt-3"></div>
                        <div class="col-auto">
                            <div class="text-center">
                                <a class="no-blue" href="/books/{{$book_rating->id}}">
                                    <div>
                                        <img src="/img/books/{{ $book_rating->filename }}.png" alt="{{ $book_rating->name }}" class="img-small mt-2">
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col d-flex flex-column">
                            <b class="mt-1" style="font-size: 18px">{{ $book_rating->name }}</b>
                            <div class="d-flex flex-row align-items-center mt-2 row-custom-size mt-auto">
                                <div>
                                    <b>{{$latestRating->member->name}}</b>
                                </div>
                                <div class="ms-auto">
                                    {{$latestRating->created_at->format('d-m-Y')}}
                                </div>
                            </div>
                            <div class="d-flex flex-row align-items-center">
                                <div class="rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="star {{ $i <= $book_rating->average_rating ? 'filled' : '' }}"></span>
                                    @endfor
                                </div>
                                <div class="ms-1 font-inter font-size-review">
                                    <b>{{ $book_rating->average_rating }}</b>
                                </div>
                            </div>
                            <div class="row-custom-size font-inter font-size-review">
                                {{$latestRating->review}}
                            </div>
                            <a href="/viewrating" class="text-decoration-none font-inter font-size-review align-items-center"><img src="/img/svg/arrow_blue.svg" alt=">">Baca selengkapnya</a>
                        </div>
                        @php $count++; @endphp
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
