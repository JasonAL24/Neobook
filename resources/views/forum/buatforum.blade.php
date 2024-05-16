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
            <label for="chooseBook" class="col-sm-1 col-form-label">Pilih Buku</label>
            <div class="select-menu col-sm-10">
                <div class="select-btn form-control">
                    <span class="fw-light sBtn-text">Pilih nama buku </span>
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
                <textarea class="form-control" id="isiforum" aria-label="With textarea" placeholder="Tulis forum anda disini..."></textarea>
            </div>
        </div>
    </form>
    <script src="/js/search2.js"></script>
@endsection
