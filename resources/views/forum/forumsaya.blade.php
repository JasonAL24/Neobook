@extends('layouts.main')

@section('container')
    <div>
        <h1 class="p-4 fw-bold">Forum Saya</h1>
    </div>

    <div class="forumContainer d-flex justify-content-center align-items-center">
        <button class="forumdiskusiButton " type="button" onclick="location.href='/forumdiskusi'"> Forum Diskusi </button>

        <button class="forumsayaButton {{ ($title === "Forum Saya") ? 'active' : '' }}" type="button" onclick="location.href='/forumsaya'"> Forum Saya </button>
    </div>

    <div class="imageWhat d-flex justify-content-center align-items-center"> <img src="/img/what2.png" alt=""> </div>

    <div class="text-center mt-3">
        <h2 class="fw-bold"> Anda Belum Memiliki Forum Aktif</h2>
    </div>

    <div class=" mt-3 mb-3 d-flex justify-content-center align-items-center">
        <button class="buatforumButton" type="button" onclick="location.href='/buatforum'"> Buat Sekarang </button>
    </div>



@endsection
