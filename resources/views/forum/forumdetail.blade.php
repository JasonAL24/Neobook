@extends('layouts.main')

@section('container')
    <div>
        <h1 class="p-4 fw-bold">Forum Diskusi</h1>
    </div>

    <div class="forumContainer d-flex justify-content-center align-items-center mb-4">
        <button class="forumdiskusiButton {{ ($title === "Forum Diskusi") ? 'active' : '' }}" type="button" onclick="location.href='/forumdiskusi'"> Forum Diskusi </button>
        <button class="forumsayaButton" type="button" onclick="location.href='/forumsaya'"> Forum Saya </button>
    </div>

            <div class="row p-3 mb-3 ms-5" style="background-color: white; width: 80vw; border-radius: 10px">
                <div class="col-auto mt-3">
                    @if ($post->member->profile_picture)
                        <img src="/img/profile/{{$post->member->id}}/{{ $post->member->profile_picture }}" alt="profile picture" class="rounded-circle"  style="width: 56px; height: 56px">
                    @else
                        <img src="/img/profile/default_pp.png" alt="profile picture" class="rounded-circle" style="width: 56px; height: 56px">
                    @endif

                </div>
                {{-- POSTS --}}
                <div class="col fs-6 mt-3">
                    <div class="d-flex flex-row">
                        <div class="d-flex flex-column align-items-start">
                            <div class="user-info">
                                <span class="fw-bold">{{ $post->member->name }}</span>
                                <span class="opacity-50 ms-4">{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="post-content mt-4">
                                <p class="fw-bold">{{ $post->title }}</p>
                                <p>{{ $post->content }}</p>
                            </div>
                            <div class="mt-auto">
                                <button class="expand-comments border-0 btn p-0" data-bs-toggle="collapse" data-bs-target="#komentar-{{$post->id}}" aria-expanded="false" aria-controls="komentar">
                                    <img src="/img/svg/comment_forum.svg" alt="comment">
                                    Tulis Komentar
                                </button>
                                <a href="/forumdiskusi" class="expand-comments border-0 btn p-0 ms-5">
                                    Balik ke halaman forum diskusi
                                    <img src="/img/svg/expand.svg" alt="expand">
                                </a>
                            </div>
                        </div>
                        <div class="book-info ms-auto">
                            <img src="/img/books/{{ $post->book->filename }}.jpg" alt="Book Image" class="book-image">
                        </div>
                    </div>

                    {{--  KOMENTAR PER POST --}}
                    <form action="{{route('addComment')}}" method="POST">
                        @csrf
                        <div class="collapse mt-4 border-0" id="komentar-{{$post->id}}" style="width: 60vw;">
                            <div class="card card-body d-flex flex-row align-items-center border-0">
                                @if ($member->profile_picture)
                                    <img src="/img/profile/{{$member->id}}/{{ $member->profile_picture }}" alt="profile picture" class="rounded-circle"  style="width: 40px; height: 40px">
                                @else
                                    <img src="/img/profile/default_pp.png" alt="profile picture" class="rounded-circle" style="width: 40px; height: 40px">
                                @endif
                                <input type="text" name="commentContent" placeholder="Tulis komentar..." class="form-control ms-3 border-0 border-bottom">
                                <input type="hidden" name="forum_post_id" value="{{ $post->id }}">
                            </div>
                            <div class="d-flex justify-content-end align-items-center">
                                <button type="button" class="btn text-danger" data-bs-toggle="collapse" data-bs-target="#komentar-{{$post->id}}" aria-expanded="false">
                                    Batal
                                </button>
                                <button class="btn btn-secondary text-light me-4 ms-3" type="submit">
                                    Kirim
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                {{--  Komentar --}}
                <div class="member-reviews ms-5">
                    @foreach ($post->comments as $comment)
                        @php
                            $commentMember = $comment->member;
                        @endphp
                        <div class="row p-3 ms-2">
                            <div class="col-auto mt-3">
                                @if ($commentMember->profile_picture)
                                    <img src="/img/profile/{{$commentMember->id}}/{{ $commentMember->profile_picture }}" alt="profile picture" class="rounded-circle"  style="width: 56px; height: 56px">
                                @else
                                    <img src="/img/profile/default_pp.png" alt="profile picture" class="rounded-circle" style="width: 56px; height: 56px">
                                @endif

                            </div>
                            <div class="col fs-6 mt-3">
                                <div class="user-info">
                                    <span class="fw-bold">{{ $commentMember->name }}</span>
                                    <span class="opacity-50 ms-4">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="post-content mt-4">
                                    <p>{{ $comment->content }}</p>
                                </div>

                                <button class="expand-replies border-0 btn p-0" data-bs-toggle="collapse" data-bs-target="#balas-{{$comment->id}}" aria-expanded="false" aria-controls="komentar">
                                    <img src="/img/svg/comment_forum.svg" alt="comment" >
                                    Balas
                                </button>
                                @if (count($comment->replies) > 0)
                                <button class="expand-comments border-0 btn p-0 ms-5" onclick="toggleReply({{ $comment->id }})">
                                    Lihat Balasan
                                    <img id="expand-img-reply-{{ $comment->id }}" class="expand-img" src="/img/svg/expand.svg" alt="expand">
                                </button>
                                @endif
                                {{-- Reply Per Komentar --}}
                                <form action="{{route('addReply')}}" method="POST">
                                    @csrf
                                    <div class="collapse mt-4 border-0" id="balas-{{$comment->id}}" style="width: 60vw;">
                                        <div class="card card-body d-flex flex-row align-items-center border-0">
                                            @if ($member->profile_picture)
                                                <img src="/img/profile/{{$member->id}}/{{ $member->profile_picture }}" alt="profile picture" class="rounded-circle"  style="width: 40px; height: 40px">
                                            @else
                                                <img src="/img/profile/default_pp.png" alt="profile picture" class="rounded-circle" style="width: 40px; height: 40px">
                                            @endif
                                            <input type="text" name="replyContent" placeholder="Tulis balasan..." class="form-control ms-3 border-0 border-bottom">
                                            <input type="hidden" name="forum_comment_id" value="{{ $comment->id }}">
                                        </div>
                                        <div class="d-flex justify-content-end align-items-center">
                                            <button class="btn text-danger" type="button" data-bs-toggle="collapse" data-bs-target="#balas-{{$comment->id}}" aria-expanded="false">
                                                Batal
                                            </button>
                                            <button class="btn btn-secondary text-light me-4 ms-3" type="submit">
                                                Kirim
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{--  Reply --}}
                        <div id="member-reply-{{ $comment->id }}" class="member-reviews hidden ms-5">
                            @foreach ($comment->replies as $reply)
                                @php
                                    $replyMember = $reply->member;
                                @endphp
                                <div class="row p-3 ms-2">
                                    <div class="col-auto mt-3">
                                        @if ($replyMember->profile_picture)
                                            <img src="/img/profile/{{$replyMember->id}}/{{ $replyMember->profile_picture }}" alt="profile picture" class="rounded-circle"  style="width: 56px; height: 56px">
                                        @else
                                            <img src="/img/profile/default_pp.png" alt="profile picture" class="rounded-circle" style="width: 56px; height: 56px">
                                        @endif

                                    </div>
                                    <div class="col fs-6 mt-3">
                                        <div class="user-info">
                                            <span class="fw-bold">{{ $replyMember->name }}</span>
                                            <span class="opacity-50 ms-4">{{ $reply->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="post-content mt-4">
                                            <p>{{ $reply->content }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                </div>
            </div>
    <script>

        function toggleReply(commentId) {
            const commentsSection = document.getElementById(`member-reply-${commentId}`);
            if (commentsSection) {
                commentsSection.classList.toggle('hidden');
            }
            const expandImg = document.getElementById(`expand-img-reply-${commentId}`);
            if (expandImg) {
                expandImg.classList.toggle('expand-img');
            }
        }
    </script>
@endsection
