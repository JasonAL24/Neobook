@extends('layouts.main')

@section('container')
<div class="home">
    <div class="row">
        <div class="col">
            <div class="home-bg">
                {{-- ! Ganti 'User' dengan backend nama user --}}
                <p style="font-size: 43px">Selamat membaca, User</p>
                <p></p>
                <p style="font-size: 32px">Mau melanjutkan bacaan kamu?</p>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-2">
                            <img class="img-shadow img-large" src="/img/books/harry_potter_and_the_deathly_hallows.png" alt="Harry Potter">
                        </div>
                        <div class="col-lg-10">
                            <div class="d-flex flex-column flex-fill">
                                <p class="ms-lg-5 fst-italic" style="font-size: 16px">Harry Potter adalah novel fantasi yang ditulis oleh penulis Inggris J. K. Rowling. Novel ini menceritakan kehidupan seorang penyihir muda, Harry Potter, dan teman-temannya...</p>
                                <div class="box ms-lg-5">
                                    <div class="title">Progress Baca</div>
                                    <div class="chapter">Chapter 25: "Shell Cottage"</div>
                                    <div class="d-flex flex-row">
                                        <div class="percentage">70% (441/638 halaman)</div>
                                        <div class="time-left ms-auto">2 Hari</div>
                                    </div>
                                    <div class="progress" role="progressbar" aria-label="Read Progress" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar" style="background: #252734; width: 70%"></div>
                                    </div>
                                </div>
                                <span class="border border-1 ms-lg-5 mt-4 rounded-4 border-custom button-shadow">
                                    <a href="/books/1/read?startPage=441" class="no-blue">
                                        <div class="text-center">
                                            Mulai Baca
                                            <img src="/img/svg/read_arrow.svg" alt="arrow">
                                        </div>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="fw-semibold mt-3" style="font-size: 32px">Buku Kami</p>
                <div class="container">
                    <div class="row">
                        @foreach ($books as $book)
                            @if($book['type'] == 'novel')
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <a class="no-blue" href="/books/{{$book['id']}}">
                                            <div class="book-container">
                                                <img src="{{ $book['image'] }}" alt="{{ $book['name'] }}" class="mb-3 book-image">
                                                <div class="overlay d-flex flex-column">
                                                    <img src="img/svg/look.svg" alt="look">
                                                    <span class="text-overlay">Lihat</span>
                                                </div>
                                            </div>
                                        </a>
                                        <p class="book-name">{{ $book['name'] }}</p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="row">
                        <a href="#" class="no-blue">
                            <div class="col-md-4 offset-md-10">
                                Selengkapnya >>
                            </div>
                        </a>
                    </div>
                </div>
                <p class="fw-semibold mt-3" style="font-size: 32px">Karya Tulis Orisinil</p>
                <div class="container">
                    <div class="row">
                        @foreach ($books as $book)
                            @if($book['type'] == 'cerpen')
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <a class="no-blue" href="/books/{{$book['id']}}">
                                            <div class="book-container">
                                                <img src="{{ $book['image'] }}" alt="{{ $book['name'] }}" class="img-fluid mb-3 book-image">
                                                <div class="overlay d-flex flex-column">
                                                    <img src="img/svg/look.svg" alt="look">
                                                    <span class="text-overlay">Lihat</span>
                                                </div>
                                            </div>
                                        </a>
                                        <p class="book-name">{{ $book['name'] }}</p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="row">
                        <a href="#" class="no-blue">
                            <div class="col-md-4 offset-md-10">
                                Selengkapnya >>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col bg-color-white ms-5">
            <div class="container">
                <h2 class="mb-3">Forum Diskusi</h2>
                <div class="container font-size-18">
                    <div class="row">
                        <div class="col-lg-1">
                            <img src="img/profile_picture_mike.png" alt="Profile Picture of Mike">
                        </div>
                        <div class="col-lg-11">
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
                        <div class="col-lg-1">
                            <img src="img/profile_picture_hannah.png" alt="Profile Picture of Hannah">
                        </div>
                        <div class="col-lg-11">
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
                <h2 class="mb-3">Obrolan Grup</h2>
                <div class="container font-size-18">
                    <div class="row">
                        <div class="col-lg-1">
                            <img src="img/book_group.png" alt="Book Group">
                        </div>
                        <div class="col-lg-11">
                            <div class="row align-items-center">
                                <div class="col">
                                    <strong>The Nerds Group 🤓</strong>
                                </div>
                            </div>
                            <div class="row row-custom-size mt-1">
                                <div class="col">
                                    <strong>User:</strong> Eh udah liat buku lord of the rings yang baru blom? Gua udah sampe hal....
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3"></div>
                <div class="container font-size-18">
                    <div class="row">
                        <div class="col-lg-1">
                            <img src="img/harry_potter_group.png" alt="Harry Potter Group">
                        </div>
                        <div class="col-lg-11">
                            <div class="row align-items-center">
                                <div class="col">
                                    <strong>Wizards 🧙</strong>
                                </div>
                            </div>
                            <div class="row row-custom-size mt-1">
                                <div class="col">
                                    <strong>User:</strong> Gila ges, buku harry potter yang baru mau rilis ges, gw harus dateng per...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container mt-5">
                <h2 class="mb-3">Penilaian</h2>
                <div class="row">
                    @php
                        $booksToShow = $books;
                        shuffle($booksToShow);
                        $endIndex = 2;
                        $booksToShow = array_slice($booksToShow, 0, $endIndex + 1);
                    @endphp

                    @foreach ($booksToShow as $book)
                        <div class="mt-3"></div>
                        <div class="col-lg-2">
                            <div class="text-center">
                                <a class="no-blue" href="#">
                                    <div>
                                        <img src="{{ $book['image'] }}" alt="{{ $book['name'] }}" class="img-small mt-2">
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-10 d-flex flex-column">
                            <b style="font-size: 18px">{{ $book['name'] }}</b>
                            <div class="d-flex flex-row align-items-center mt-2 row-custom-size">
                                <div>
                                    <b>User</b>
                                </div>
                                <div class="ms-auto">
                                    {{$book['last_rating_date']}}
                                </div>
                            </div>
                            <div class="d-flex flex-row align-items-center">
                                <div class="rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="star {{ $i <= $book['rating'] ? 'filled' : '' }}"></span>
                                    @endfor
                                </div>
                                <div style="font-size: 20px" class="ms-1">
                                    <strong>{{ $book['rating'] }}</strong>
                                </div>
                            </div>
                            <div class="row-custom-size">
                                {{$book['last_rating_desc']}}
                            </div>
                            <a href="#">> Baca selengkapnya</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
