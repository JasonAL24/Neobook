@extends('layouts.main')

@section('container')
    <div class="home-bg">
        <div class="ms-3">
            {{-- ! Ganti 'User' dengan backend nama user --}}
            <p style="font-size: 43px">Selamat membaca, User</p>
            <p></p>
            <p style="font-size: 32px">Mau melanjutkan bacaan kamu?</p>
            <div class="d-flex flex-row">
                <img class="img-shadow img-large" src="img/books/harry_potter.png" alt="Harry Potter">
                <div class="d-inline-flex flex-column flex-fill">
{{--                    <p class="ms-3 fst-italic" style="font-size: 16px">Harry Potter adalah novel fantasi yang ditulis oleh penulis Inggris J. K. Rowling. Novel ini menceritakan kehidupan seorang penyihir muda, Harry Potter, dan teman-temannya...</p>--}}
                    {{-- Progress Bar Box  --}}
                    <div class="box ms-3">
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
                    {{-- Mulai Baca, Jangan lupa kasih klik untuk redirect ke bacaan --}}
                    <span class="border border-1 ms-3 mt-4 rounded-4 border-custom">
                        <div class="text-center">
                            Mulai Baca
                        <img src="img/svg/read_arrow.svg" alt="arrow">
                        </div>
                    </span>
                </div>
            </div>
            <p class="fw-semibold mt-3" style="font-size: 32px">Buku Kami</p>
        </div>
    </div>

@endsection
