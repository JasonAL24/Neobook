@extends('layouts.main')

@section('container')
    <div>
        <h1 class="p-4 fw-bold">Forum Diskusi</h1>
    </div>

    <div class="forumContainer d-flex justify-content-center align-items-center mb-4">
        <button class="forumdiskusiButton {{ ($title === "Forum Diskusi") ? 'active' : '' }}" type="button" onclick="location.href='/forumdiskusi'"> Forum Diskusi </button>
        <button class="forumsayaButton" type="button" onclick="location.href='/forumsaya'"> Forum Saya </button>
    </div>
    <form class="d-flex ms-5" role="search" id="searchBookForum" style="background-color: white; width: 80vw; border-radius: 10px; height: 2vw">
        <img src="/img/svg/Search_light.svg" alt="search">
        <input class="custom-input me-2 ms-2" type="search" id="searchBookForumInput" placeholder="Cari forum berdasarkan nama buku..." aria-label="Search">
        <input type="hidden" id="selectedBookId" name="book_id">
    </form>
    <div class="dropdown-menu ms-5 border border-dark" id="searchBookForumResultsDropdown" aria-labelledby="searchBookForumInput">
        <!-- Dropdown items will be populated here -->
    </div>
    @if($feedbackMessage)
        <h4 class="ms-5"><button type="button" class="btn btn-secondary me-2" onclick="location.href='/forumdiskusi'">&#8592; Balik</button>{{ $feedbackMessage }}</h4>
    @endif
    @if($posts->isEmpty())
        <div class="imageWhat d-flex justify-content-center align-items-center"> <img src="/img/what1.png" alt=""> </div>
        <div class="text-center mt-3">
            <h2 class="fw-bold"> Forum Diskusi Kosong</h2>
        </div>
    @else

        <div class="custom-overflow overflow-y-auto" style="max-height: 55vh; width:83.5vw;">
            @foreach($posts as $post)
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
                                <div class="user-info d-flex flex-row align-items-center">
                                    <span class="fw-bold">{{ $post->member->name }}</span>
                                    <img src="/img/svg/checkmark.svg" alt="checkmark" class="{{$post->member->premium_status ? 'd-block' : 'd-none'}} ms-2">
                                    <span class="opacity-50 ms-4">{{ $post->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="post-content mt-3">
                                    <p class="fw-bold">{{ $post->title }}</p>
                                    <p style="margin-top:-0.5em; max-width: 60vw; word-wrap: break-word">{{ $post->content }}</p>
                                </div>
                                <div class="mt-auto">
                                    <button class="expand-comments border-0 btn p-0" data-bs-toggle="collapse" data-bs-target="#komentar-{{$post->id}}" aria-expanded="false" aria-controls="komentar">
                                        <img src="/img/svg/comment_forum.svg" alt="comment">
                                        Tulis Komentar
                                    </button>
                                    <a href="forumdiskusi/{{$post->id}}" class="expand-comments border-0 btn p-0 ms-5" onclick="toggleComments({{ $post->id }})">
                                        Lihat Komentar Selengkapnya
                                        <img id="expand-img-{{ $post->id }}" class="expand-img" src="/img/svg/expand.svg" alt="expand">
                                    </a>
                                </div>
                            </div>
                            <div class="book-info ms-auto">
                                <img src="/img/books/{{ $post->book->cover_image }}.jpg" alt="Book Image" class="book-image">
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
                                    <input type="text" name="commentContent" placeholder="Tulis komentar..." class="form-control ms-3 border-0 border-bottom" maxlength="300">
                                    <input type="hidden" name="forum_post_id" value="{{ $post->id }}">
                                    <input type="hidden" name="forum_member_id" value="{{ $post->member->id }}">
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
                </div>
            @endforeach
        </div>

        {{-- Button Buat Forum--}}
        <div class="position-absolute bottom-0 end-0 p-4">
            <a href="/buatforum" class="btn text-light rounded-circle create-button" style="background-color: #252734; width: 5em; height: 5em">
                <img src="/img/svg/plus.svg" alt="plus" style="width: 4em; margin-left: -.3em;" class="rounded-circle">
            </a>
            <div class="mt-2 create-text">Buat Forum</div>
        </div>
    @endif
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchBookForumInput');
        const searchResultsDropdown = document.getElementById('searchBookForumResultsDropdown');
        const selectedBookIdInput = document.getElementById('selectedBookId');
        let count = 0;

        searchInput.addEventListener('input', function () {
            const query = searchInput.value;

            if (query.length > 0) {
                fetch(`/search-books?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        searchResultsDropdown.innerHTML = '';
                        searchResultsDropdown.classList.add('show');
                        count = 0;

                        data.forEach(book => {
                            if (count < 2) {
                                const bookItem = document.createElement('div');
                                bookItem.classList.add('mb-3');

                                bookItem.innerHTML = `
                                <a href="#" class="d-flex align-items-center no-blue ms-2 book-selection" data-book-id="${book.id}">
                                    <img onerror="this.onerror=null; this.src='/img/default_book.jpg';" src="/img/books/${book.cover_image}.jpg" alt="${book.name}" class="me-3 book-image" style="width: 73px; height: 98px; object-fit: cover; border-radius: 5px;">
                                    <div>
                                        <h6 class="mb-1">${book.name}</h6>
                                        <p class="mb-0 text-muted">Penulis: ${book.author}</p>
                                    </div>
                                </a>
                            `;
                                searchResultsDropdown.appendChild(bookItem);
                                count++;
                            }
                        });
                    });
            } else {
                searchResultsDropdown.innerHTML = '';
                searchResultsDropdown.classList.remove('show');
            }
        });

        searchResultsDropdown.addEventListener('click', function (event) {
            const bookSelection = event.target.closest('.book-selection');
            if (bookSelection) {
                const selectedBookId = bookSelection.dataset.bookId;
                const selectedBookName = bookSelection.querySelector('h6').textContent;

                searchInput.value = selectedBookName;
                selectedBookIdInput.value = selectedBookId;
                searchResultsDropdown.classList.remove('show');

                document.getElementById('searchBookForum').submit();
            }
        });
    });
</script>
