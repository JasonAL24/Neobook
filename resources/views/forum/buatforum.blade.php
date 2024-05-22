@extends('layouts.main')

@section('container')
    <div>
        <h1 class="p-4 fw-bold">Forum Saya</h1>
    </div>

    <div class="forumContainer d-flex justify-content-center align-items-center">
        <button class="forumdiskusiButton " type="button" onclick="location.href='/forumdiskusi'"> Forum Diskusi </button>

        <button class="forumsayaButton2" type="button" onclick="location.href='/forumsaya'"> Forum Saya </button>
    </div>

    <form class="mt-5 p-4" method="POST" action="{{route('addForum')}}">
        @csrf
        <div class="row mb-3 ms-5">
            <label for="judulforum" class="col-sm-1 col-form-label">Judul Form</label>
            <div class="col-sm-10">
                <input type="text" name="title" class="form-control" id="judulforum" placeholder="Tulis judul forum...">
            </div>
        </div>

        <div class="row mb-3 ms-5">
            <label for="chooseBook" class="col-sm-1 col-form-label">Pilih Buku</label>
            <div class="select-menu col-sm-10">
                <div class="select-btn form-control">
                    <span class="fw-light sBtn-text">Pilih nama buku </span>
                    <input class="fw-light sBtn-text-id hidden" name="book_id" type="hidden">
                    <i class="fa-solid fa-arrow-down"></i>
                </div>
                <div class="custom-input-forum mt-2">
                    <div class="d-flex search-input-forum" role="search" id="searchForm">
                        <img src="/img/svg/Search_light.svg" alt="search">
                        <input class="custom-input" type="search" id="searchInputForum" placeholder="cari nama buku..." aria-label="Search">

                    </div>
                    <div class="options" id="searchResultsDropdownForum" aria-labelledby="searchInput" style="height: 26vh">
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3 ms-5">
            <label for="isiforum" class="col-sm-1 col-form-label">Isi Forum</label>
            <div class="col-sm-10">
                <input type="text" name="content"  class="form-control" id="content" aria-label="With textarea" placeholder="Tulis forum anda disini...">
{{--                <textarea name="content" class="form-control" id="content" aria-label="With textarea" placeholder="Tulis forum anda disini..."></textarea>--}}
            </div>

        </div>

        <div class="row mb-3 ms-5">
            <div class="col-sm-11 d-flex justify-content-end">
                <button type="submit" class="btn btn-secondary mt-4 " style="width: 6vw">Kirim</button>
            </div>
        </div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


    </form>




    <script src="/js/search2.js"></script>
@endsection
