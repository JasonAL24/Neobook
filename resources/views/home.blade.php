@extends('layouts.main')

@section('container')
<div class="home">
    <div class="row">
        <div class="col">
            <div class="home-bg">
                <div class="ps-5">
                    {{-- ! Ganti 'User' dengan backend nama user --}}
                    <p style="font-size: 43px">Selamat membaca, User</p>
                    <p></p>
                    <p style="font-size: 32px">Mau melanjutkan bacaan kamu?</p>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-2">
                                <img class="img-shadow img-large" src="img/books/harry_potter.png" alt="Harry Potter">
                            </div>
                            <div class="col-lg-10">
                                <div class="d-flex flex-column flex-fill">
                                    <p class="ms-lg-5 fst-italic" style="font-size: 16px">Harry Potter adalah novel fantasi yang ditulis oleh penulis Inggris J. K. Rowling. Novel ini menceritakan kehidupan seorang penyihir muda, Harry Potter, dan teman-temannya...</p>
                                    <div class="box ms-lg-5">
                                        <div class="title">Progress Baca</div>
                                        <div class="chapter">Chapter 3: "Chamber of Reflection"</div>
                                        <div class="d-flex flex-row">
                                            <div class="percentage">70% (525/750 halaman)</div>
                                            <div class="time-left ms-auto">2 Hari</div>
                                        </div>
                                        <div class="progress" role="progressbar" aria-label="Read Progress" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="background: #252734; width: 70%"></div>
                                        </div>
                                    </div>
                                    <span class="border border-1 ms-lg-5 mt-4 rounded-4 border-custom">
                                        <a href="#" class="no-blue">
                                            <div class="text-center">
                                                Mulai Baca
                                                <img src="img/svg/read_arrow.svg" alt="arrow">
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
                            <div class="col-md-3">
                                <a class="no-blue" href="#">
                                    <div class="text-center">
                                        <img src="img/books/harry_potter.png" alt="Harry Potter" class="img-fluid mb-3">
                                        <p class="book-name">Harry Potter and the Deathly Hallows</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="#" class="no-blue">
                                    <div class="text-center">
                                        <img src="img/books/fantastic_beasts.png" alt="Fantastic Beasts" class="img-fluid mb-3">
                                        <p class="book-name">Fantastic Beasts and Where to Find Them</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="#" class="no-blue">
                                    <div class="text-center">
                                        <img src="img/books/game_of_thrones.png" alt="Game Of Thrones" class="img-fluid mb-3">
                                        <p class="book-name">Game of Thrones</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="#" class="no-blue">
                                    <div class="text-center">
                                        <img src="img/books/wise_man_fear.png" alt="Game Of Thrones" class="img-fluid mb-3">
                                        <p class="book-name">The Wise Man's Fear</p>
                                    </div>
                                </a>
                            </div>
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
                            <div class="col-md-3">
                                <a href="#" class="no-blue">
                                    <div class="text-center">
                                        <img src="img/books/kedamaian.png" alt="kedamaian" class="img-fluid mb-3">
                                        <p class="book-name">Kedamaian</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="#" class="no-blue">
                                    <div class="text-center">
                                        <img src="img/books/obsesi.png" alt="Obsesi" class="img-fluid mb-3">
                                        <p class="book-name">Obsesi</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="#" class="no-blue">
                                    <div class="text-center">
                                        <img src="img/books/izinkan_perempuan.png" alt="Izinkan Perempuan Bicara" class="img-fluid mb-3">
                                        <p class="book-name">Izinkan Perempuan Bicara</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="#" class="no-blue">
                                    <div class="text-center">
                                        <img src="img/books/lukisan_senja.png" alt="Lukisan Senja" class="img-fluid mb-3">
                                        <p class="book-name">Lukisan Senja</p>
                                    </div>
                                </a>
                            </div>
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
        </div>
        <div class="col bg-color-white">
            <p style="font-size: 32px"><b>Forum Diskusi</b></p>
        </div>
    </div>
</div>


@endsection
