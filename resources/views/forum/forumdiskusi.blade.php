@extends('layouts.main')

@section('container')
        <div>
            <h1 class="p-4 fw-bold">Forum Diskusi</h1>
        </div>

        <div class="forumContainer d-flex justify-content-center align-items-center">
            <button class="forumdiskusiButton {{ ($title === "Forum Diskusi") ? 'active' : '' }}" type="button" onclick="location.href='/forumdiskusi'"> Forum Diskusi </button>

            <button class="forumsayaButton" type="button" onclick="location.href='/forumsaya'"> Forum Saya </button>
        </div>

        <div class="imageWhat d-flex justify-content-center align-items-center"> <img src="/img/what1.png" alt=""> </div>

        <div class="text-center mt-3">
            <h2 class="fw-bold"> Forum Diskusi Kosong</h2>
        </div>

@endsection
