@extends('layouts.main')

@section('container')
    <div>
        <h1 class="p-4 fw-bold">Forum Saya</h1>
    </div>

    <div class="forumContainer d-flex justify-content-center align-items-center">
        <button class="forumdiskusiButton " type="button" onclick="location.href='/forumdiskusi'"> Forum Diskusi </button>

        <button class="forumsayaButton2" type="button" onclick="location.href='/forumsaya'"> Forum Saya </button>
    </div>

    <form class="mt-5 p-4">
        <div class="row mb-3 ms-5">
            <label for="judulforum" class="col-sm-1 col-form-label">Judul Form</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="judulforum" placeholder="Tulis judul forum...">

            </div>
        </div>

        <div class="row mb-3 ms-5">
            <label for="inputEmail3" class="col-sm-1 col-form-label">Pilih Buku</label>
            <div class="select-menu col-sm-10">
{{--                <div class="select-btn form-control">--}}
{{--                    <span class="fw-light sBtn-text">Pilih nama buku </span>--}}
{{--                    <i class="fa-solid fa-arrow-down"></i>--}}
{{--                </div>--}}

{{--                <ul class="options" id="options">--}}
{{--                    @foreach (($results ?? $books) as $book)--}}
{{--                    <li class="option" id="option">--}}
{{--                        <div class="books d-flex align-items-center ms-2">--}}
{{--                            <div class="book-img"><img class="book-images me-3" src="/img/books/{{$book['filename']}}.png"  alt=""> </div>--}}
{{--                            <div class="bookDetailsContainer">--}}
{{--                                    <div class="judulBuku option-text"> {{$book->name}} </div>--}}
{{--                                    <div class="penulisBuku">Penulis: {{ $book->author }}</div>--}}
{{--                                    <div class="ratingBuku">Rating: {{ $book->rating }}</div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </li>--}}
{{--                    @endforeach--}}
{{--                </ul>--}}

                <div class="wrapper">
                    <div class="select-btn form-control">
                        <span>Pilih nama buku</span>
                        <i class="fa-solid fa-arrow-down"></i>
                    </div>
                    <div class="content">
                        <div class="search">
                            <i class="fas fa-search"></i>
                            <input class="" type="text" placeholder="Cari nama buku">
                        </div>
                        <ul class="optionz">
                        </ul>
                    </div>
                </div>

            </div>
        </div>

        <div class="row mb-3 ms-5">
            <label for="isiforum" class="col-sm-1 col-form-label">Isi Forum</label>
            <div class="col-sm-10">
                <textarea class="form-control" id="isiforum" aria-label="With textarea" placeholder="Tulis forum anda disini..."></textarea>
            </div>
        </div>

    </form>


    <script src="/js/search2.js"></script>




@endsection
