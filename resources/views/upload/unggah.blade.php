@extends('layouts.main')

@section('container')
    <div class="main-bg">
        <div class="white-container p-3">
            <h2 class="fw-bold p-3">List buku yang sudah di unggah</h2>
            @if($records->isEmpty())
                <div class="text-center mt-5">
                    <img src="/img/upload_not_found.png" alt="Upload Not Found">
                    <h3 class="fw-bold mt-5">Anda Belum Memiliki Buku Yang Telah Diunggah</h3>
                    <a href="{{route('viewBookUpload')}}" class="btn text-light fw-bold fs-5 mt-4" style="background-color: #252734">
                        Unggah
                        <img src="/img/svg/upload_book.svg" alt="upload" style="width: 27px">
                    </a>
                </div>
            @else
                <div class="align-items-center mb-4">
                    <span class="ms-3">Unggah buku anda disini</span>
                    <a href="{{route('viewBookUpload')}}" class="btn text-light fw-bold ms-4" style="background-color: #252734;">
                        Unggah
                        <img src="/img/svg/upload_book.svg" alt="upload" style="width: 25px">
                    </a>
                </div>
                <div class="row ms-5 mb-4">
                    <div class="col fw-bold fs-3">
                        Cover
                    </div>
                    <div class="col fw-bold fs-3">
                        Judul
                    </div>
                    <div class="col fw-bold fs-3">
                        Status
                    </div>
                </div>
                @foreach($records as $record)
                    <div class="row ms-5 mb-4 align-items-center">
                        <div class="col">
                            <img onerror="this.onerror=null; this.src='/img/default_book.jpg';" src="/img/books/{{$record->book->cover_image}}.jpg" alt="{{$record->book->name}}" style="width: 70px; height: 101px;">
                        </div>
                        <div class="col fs-5">
                            {{$record->book->name}}
                        </div>
                        <div class="col fs-5">
                            {{ucfirst($record->status)}}
                            <p>Alasan:
                                @if ($record->status = 'ditolak')
                                    {{$record->rejectReason}}
                                @endif
                            </p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
