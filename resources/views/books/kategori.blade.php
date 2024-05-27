@extends('layouts.main')

@section('container')
    <div class="main-bg">
        <div class="white-container p-3">
            <h2 class="fw-bold p-3">Buku berdasarkan kategori '{{ ucfirst($query) }}'</h2>
            <div class="row p-3">
                @foreach ($books as $book)
                    <div class="col-auto me-2 mb-3">
                        <div class="card" style="width: 15rem;">
                            <img onerror="this.onerror=null; this.src='/img/default_book.jpg';" src="/img/books/{{ $book->filename }}.jpg" class="card-img-top" alt="{{ $book->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $book->name }}</h5>
                                <a href="/books/{{ $book->id }}" class="btn btn-primary">Lihat Detail Buku</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

