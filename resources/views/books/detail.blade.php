@extends('layouts.main')

@section('container')
    <div class="main-bg">
        <div class="ms-5">
            <div class="container">
                <div class="row" style="height: 300px">
                    <div class="col-lg-4 offset-md-1" style="height: 115%">
                        <img onerror="this.onerror=null; this.src='/img/default_book.jpg';" src="/img/books/{{$book->cover_image}}.jpg" alt="Book Image" class="book-detail-image">
                    </div>
                    <div class="col-lg-7 justify-content-between" style="width: 50%">
                        <h1><strong>{{ $book->name }}</strong></h1>
                        <h2 class="mt-5">{{ $book->author }}</h2>
                    </div>
                    @php
                        $lastPage = $member->books->find($book->id)->pivot->last_page ?? 1;
                        $collected = $member->books()->where('book_id', $book->id)->exists();
                        $locked = !$member->premium_status && $book->category == 'novel'
                    @endphp
                    <div class="col offset-md-5">
                        <form action="{{ route('add-to-collection') }}" method="POST" style="display: inline;">
                            @csrf
                            @if ($locked)
                                <p>Ayo bergabung ke Neobook premium dan dapatkan akses ke seluruh buku!</p>
                            @else
                                @if ($collected)
                                    <p>Buku ini sudah ditambahkan ke koleksi.</p>
                                @else
                                    <button type="submit" class="border border-1 rounded-4 border-custom text-center button-shadow">
                                        Tambahkan
                                        <img src="/img/svg/plus.svg" alt="arrow">
                                    </button>
                                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                                @endif
                            @endif
                        </form>
                        @if($locked)
                            <span class="border border-1 rounded-4 border-custom mt-4 text-center mb-5 button-shadow opacity-50">
                                Mulai Baca
                                <img src="/img/svg/lock_light.svg" alt="arrow">
                            </span>
                        @else
                            <span class="border border-1 rounded-4 border-custom mt-4 text-center mb-5 button-shadow">
                                <a href="/books/{{$book->id}}/read?startPage={{$lastPage}}" class="no-blue">
                                    Mulai Baca
                                    <img src="/img/svg/read_arrow.svg" alt="arrow">
                                </a>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row p-5" style="height: 25vh; background-color: #FDFCF7">
            </div>
            <div class="row" style="background-color: #FDFCF7">
                <div class="col-lg-5">
                    <b>Deskripsi</b>
                    <p>{!! ($book->description) !!}</p>
                </div>
                <div class="col-lg-5 offset-md-2" style="width: 30%">
                    <div>
                        <b>Editor</b>
                        <p>{{$book->editor}}</p>
                    </div>
                    <div class="mt-5">
                        <b>Bahasa</b>
                        <p>{{$book->language}}</p>
                    </div>
                    <div class="mt-5">
                        <b>ISBN</b>
                        <p>{{$book->ISBN}}</p>
                    </div>
                    <div class="mt-5">
                        <b>Penerbit</b>
                        <p>{{$book->publisher}}</p>
                    </div>

                </div>
            </div>
        </div>
    </div>


@endsection
