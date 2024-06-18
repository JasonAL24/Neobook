@extends('layouts.admin')

@section('container')
    <div class="main-bg">
        <div class="white-container p-3">
            <h2 class="fw-bold p-3 mb-4">Buku yang diunggah</h2>
            @if ($errors->any())
                <ul class="alert alert-danger ms-5">
                    @foreach ($errors->all() as $error)
                        <li class="ms-3">{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            @if (session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif
            <div class="ms-5" style="width: 90%">
                <div class="input-group mb-3 align-items-center">
                    <span class="input-label">Judul Buku</span>
                    <input type="text" name="judul" class="form-control" placeholder="Tulis judul buku..." aria-label="Judul" value="{{ $book->name }}" disabled>
                </div>
                <div class="input-group mb-3 align-items-center">
                    <span class="input-label">Penulis</span>
                    <input type="text" name="penulis" class="form-control" placeholder="Tulis nama penulis buku..." aria-label="Penulis" value="{{ $book->author }}" disabled>
                </div>
                <div class="input-group mb-3">
                    <span class="input-label">Deskripsi Buku</span>
                    <div class="position-relative input-group form-control" style="padding: 0; border: 0">
                        <textarea id="deskripsi" name="deskripsi" class="form-control" maxlength="500" placeholder="Tulis deskripsi buku..." aria-label="Deskripsi" style="height: 10em;" disabled>{{ strip_tags($book->description) }}</textarea>
                        <div class="position-absolute bottom-0 end-0 me-3" style="pointer-events: none; font-size: 16px; opacity: 50%; z-index:500">
                            <span id="char-count" class="">{{ strlen(strip_tags($book->description)) }}/500</span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3 align-items-center">
                    <span class="input-label">Editor</span>
                    <input type="text" name="editor" class="form-control" placeholder="Tulis editor buku..." aria-label="Editor" value="{{ $book->editor }}" disabled>
                </div>
                <div class="input-group mb-3 align-items-center">
                    <span class="input-label">Bahasa</span>
                    <input type="text" name="bahasa" class="form-control" placeholder="Tulis editor buku..." aria-label="Editor" value="{{$book->language}}" disabled>
                </div>
                <div class="input-group mb-3 align-items-center">
                    <span class="input-label">Kategori</span>
                    <input type="text" name="Kategori" class="form-control" placeholder="Tulis editor buku..." aria-label="Editor" value="{{ucfirst($book->category)}}" disabled>
                </div>
                <div class="input-group mb-3 align-items-center">
                    <span class="input-label">ISBN</span>
                    <input type="text" name="ISBN" class="form-control" placeholder="Tulis ISBN buku..." aria-label="ISBN" value="{{ $book->ISBN }}" disabled>
                </div>
                <div class="input-group mb-3 align-items-center">
                    <span class="input-label">Penerbit</span>
                    <input type="text" name="penerbit" class="form-control" placeholder="Tulis penerbit buku..." aria-label="ISBN" value="{{ $book->publisher }}" disabled>
                </div>
                @if($record->status !== 'Ditolak')
                <div class="input-group mb-3 align-items-center" style="background-color: white; height: 5em;">
                    <div class="d-flex flex-column p-2">
                        <span class="input-label fw-bold">File Buku</span>
                    </div>
                    <div class="ms-auto">
                        <span id="pdfName" class="me-2">{{ $book->pdf_file }}.pdf</span>
                        <a href="/books/{{ $book->pdf_file }}.pdf" download="{{ $book->pdf_file }}.pdf">
                            <button type="button" id="pdfUploadBtn" class="btn text-light fw-bold me-3" style="background-color: #252734; border-radius: 10px">
                                Download Buku
                                <img src="/img/svg/download.svg" alt="upload" style="width: 23px">
                            </button>
                        </a>
                    </div>
                </div>

                <div class="input-group mb-3 p-3" style="background-color: white;">
                    <div class="input-group-prepend">
                        <span class="fs-5 fw-bold">Cover Buku</span>
                        <div class="mb-3 mt-3" id="coverPreviewContainer">
                            <img src="/img/books/{{ $book->cover_image }}.jpg" alt="Cover Preview" id="coverPreview" style="max-width: 200px; max-height: 200px;">
                        </div>
                    </div>
                </div>
                @endif
                @if($record->status === 'Disetujui')
                    <div class="d-flex">
                        <p class="fs-4 text-success ms-auto">Buku ini sudah disetujui.</p>
                    </div>
                @elseif($record->status === 'Ditolak')
                    <div class="d-flex">
                        <p class="fs-4 text-danger ms-auto">Buku ini sudah ditolak.</p>
                    </div>
                @else
                <div class="d-flex flex-row">
                    <div class="ms-auto mt-4">
                        <button type="submit" class="btn btn-danger fs-5 me-3" data-bs-toggle="modal" data-bs-target="#rejectModal">Tolak</button>
{{--                        Modal untuk konfirmasi tolak --}}
                        <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header d-flex flex-row" style="border-bottom: 0;">
                                        <h5 class="modal-title" id="rejectModalLabel">Konfirmasi Penolakan</h5>
                                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close">
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Apakah anda yakin untuk menghapus buku ini?</p>
                                        <p>Catatan Penting: Buku ini akan dihapus dari storage</p>
                                    </div>
                                    <div class="modal-footer" style="border-top: 0;">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <form action="{{route('admin.book.reject', $record->id)}}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Ya, Hapuskan buku</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success fs-5" style="width: 6vw" data-bs-toggle="modal" data-bs-target="#confirmModal">Setuju</button>
{{--                        Modal untuk konfirmasi setuju --}}
                        <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header d-flex flex-row" style="border-bottom: 0;">
                                        <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Persetujuan</h5>
                                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close">
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah anda yakin untuk menambah buku ini?
                                    </div>
                                    <div class="modal-footer" style="border-top: 0;">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <form action="{{route('admin.book.approve', $record->id)}}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Ya, Tambahkan buku</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
