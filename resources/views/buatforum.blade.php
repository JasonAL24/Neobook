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
            <label for="inputEmail3" class="col-sm-1 col-form-label">Judul Form</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="inputEmail3" placeholder="Tulis judul forum...">
            </div>
        </div>

        <div class="row mb-3 ms-5">
            <label for="inputEmail3" class="col-sm-1 col-form-label">Pilih Buku</label>
            <div class="col-sm-10">
{{--                    BIKIN INPUT TYPE OPTION LIAT YOUTUBE--}}
            </div>
            </div>
        </div>

        <div class="row mb-3 ms-5">
            <label for="inputEmail3" class="col-sm-1 col-form-label">Isi Forum</label>
            <div class="col-sm-10">
                <textarea class="form-control" aria-label="With textarea" placeholder="Tulis forum anda disini..."></textarea>
            </div>
        </div>

    </form>



    <script src="/js/search2.js"></script>




@endsection
