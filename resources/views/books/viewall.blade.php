@extends('layouts.main')

@section('container')
    <div class="main-bg">
        <h2>Ayo lanjutkan ceritamu!</h2>
        <h3 class="fw-bold mt-3">Terpopuler</h3>
        <div class="row">
            @foreach($books as $book)
                <div class="col-auto me-auto">
                    <div class="text-center">
                        <a class="no-blue" href="/books/{{$book->id}}">
                            <div class="book-container">
                                <img src="/img/books/{{ $book->filename}}.png" alt="{{ $book->name }}" class="mb-3 book-image-lg">
                                <div class="overlay d-flex flex-column book-image-lg">
                                    <img src="img/svg/look.svg" alt="look">
                                    <span class="text-overlay">Lihat</span>
                                </div>
                            </div>
                        </a>
                        <p class="book-name-lg">{{ $book->name }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
