@extends('layouts.main')

@section('container')
    <div>
        <h1 class="p-4 fw-bold">Forum Diskusi</h1>
    </div>

    <div class="forumContainer d-flex justify-content-center align-items-center">
        <button class="forumdiskusiButton {{ ($title === "Forum Diskusi") ? 'active' : '' }}" type="button" onclick="location.href='/forumdiskusi'"> Forum Diskusi </button>
        <button class="forumsayaButton" type="button" onclick="location.href='/forumsaya'"> Forum Saya </button>
    </div>

    @if($posts->isEmpty())
        <div class="imageWhat d-flex justify-content-center align-items-center"> <img src="/img/what1.png" alt=""> </div>
        <div class="text-center mt-3">
            <h2 class="fw-bold"> Forum Diskusi Kosong</h2>
        </div>
    @else
        @foreach($posts as $post)
            <div class="forum-post">
                <div class="post-header">
                    <img src="/img/profile/{{ $post->member->user->profile_picture }}" alt="Profile Picture" class="profile-picture">
                    <div class="user-info">
                        <h3>{{ $post->member->user->name }}</h3>
                        <p>{{ $post->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="book-info">
                    <img src="/img/books/{{ $post->book->image }}" alt="Book Image" class="book-image">
                </div>
                <div class="post-content">
                    <h2>{{ $post->title }}</h2>
                    <p>{{ $post->content }}</p>
                </div>
            </div>
        @endforeach
    @endif
@endsection
