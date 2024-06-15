@extends('layouts.admin')

@section('container')
    <div class="main-bg">
        <div class="white-container p-3">
            <h2 class="fw-bold p-3 mb-4">Unggah Buku</h2>
            @if ($errors->any())
                <ul class="alert alert-danger ms-5">
                    <div class="fw-bold">Error! Mohon unggah ulang. Berikut error yang didapat:</div>
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
            <form method="POST" action="{{ route('admin.create.book') }}" enctype="multipart/form-data">
                @csrf
                <div class="ms-5" style="width: 90%">
                    <div class="input-group mb-3 align-items-center">
                        <span class="input-label">Judul Buku</span>
                        <input type="text" name="judul" class="form-control" placeholder="Tulis judul buku..." aria-label="Judul">
                    </div>
                    <div class="input-group mb-3 align-items-center">
                        <span class="input-label">Penulis</span>
                        <input type="text" name="penulis" class="form-control" placeholder="Tulis nama penulis buku..." aria-label="Penulis">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-label">Deskripsi Buku</span>
                        <div class="position-relative input-group form-control" style="padding: 0; border: 0">
                            <textarea id="deskripsi" name="deskripsi" class="form-control" maxlength="500" placeholder="Tulis deskripsi buku..." aria-label="Deskripsi" style="height: 10em;"></textarea>
                            <div class="position-absolute bottom-0 end-0 me-3" style="pointer-events: none; font-size: 16px; opacity: 50%; z-index:500">
                                <span id="char-count" class="">0/500</span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3 align-items-center">
                        <span class="input-label">Editor</span>
                        <input type="text" name="editor" class="form-control" placeholder="Tulis editor buku..." aria-label="Editor">
                    </div>
                    <div class="input-group mb-3 align-items-center">
                        <span class="input-label">Bahasa</span>
                        <select name="bahasa" class="form-select" aria-label="Bahasa">
                            <option selected disabled>Pilih Bahasa</option>
                            <option value="Inggris (USA)">Inggris (USA)</option>
                            <option value="Inggris (UK)">Inggris (UK)</option>
                            <option value="Mandarin (Aks. Sederhana)">Mandarin (Aks. Sederhana)</option>
                            <option value="Mandarin (Aks. Tradisional)">Mandarin (Aks. Tradisional)</option>
                            <option value="Spanyol">Spanyol</option>
                            <option value="Bahasa Indonesia">Bahasa Indonesia</option>
                            <option value="Bahasa Jepang">Bahasa Jepang</option>
                            <option value="Rusia">Rusia</option>
                        </select>
                    </div>
                    <div class="input-group mb-3 align-items-center">
                        <span class="input-label">Kategori</span>
                        <select name="kategori" class="form-select" aria-label="Kategori">
                            <option selected disabled>Pilih Kategori</option>
                            <option value="aksi">Aksi</option>
                            <option value="komedi">Komedi</option>
                            <option value="pertualangan">Pertualangan</option>
                            <option value="biografi">Biografi</option>
                            <option value="fiksi ilmiah">Fiksi Ilmiah</option>
                            <option value="romantis">Romantis</option>
                            <option value="misteri">Misteri</option>
                            <option value="horror">Horror</option>
                            <option value="sejarah">Sejarah</option>
                            <option value="cerpen">Cerpen</option>
                            <option value="anak-anak">Anak-anak</option>
                            <option value="pembelajaran">Pembelajaran</option>
                            <option value="filosofi">Filosofi</option>
                            <option value="novel">Novel</option>
                            <option value="drama">Drama</option>
                        </select>
                    </div>
                    <div class="input-group mb-3 align-items-center">
                        <span class="input-label">ISBN</span>
                        <input type="text" name="ISBN" class="form-control" placeholder="Tulis ISBN buku..." aria-label="ISBN">
                    </div>
                    <div class="input-group mb-3 align-items-center">
                        <span class="input-label">Penerbit</span>
                        <input type="text" name="penerbit" class="form-control" placeholder="Tulis penerbit buku..." aria-label="ISBN" >
                    </div>
                    <div class="input-group mb-3 align-items-center" style="background-color: white; height: 5em;">
                        <div class="d-flex flex-column p-2">
                            <span class="input-label fw-bold">Unggah File Buku</span>
                            <span class="opacity-50">*File buku musti berupa file PDF dan ukuran maksimal 50 MB</span>
                        </div>

                        <div class="ms-auto">
                            <span id="pdfName" class="me-2"></span>
                            <button type="button" id="pdfUploadBtn" class="btn text-light fw-bold me-3" style="background-color: #252734; border-radius: 10px">
                                Unggah File Buku
                                <img src="/img/svg/upload_book.svg" alt="upload" style="width: 23px">
                            </button>
                        </div>
                        <input type="file" name="pdf_file" class="form-control d-none" accept=".pdf" aria-label="File PDF" id="pdfInput">
                    </div>

                    <div class="input-group mb-3" style="background-color: white;">
                        <div class="input-group-prepend">
                            <div class="mb-3" id="coverPreviewContainer">
                                <img src="/img/default_preview.png" alt="Cover Preview" id="coverPreview" style="max-width: 200px; max-height: 200px;">
                            </div>

                        </div>
                        <div class="p-3 d-flex flex-column">
                            <span class="fs-5 fw-bold">Unggah Cover Buku</span>
                            <span class="opacity-50">*Cover buku musti berupa file JPG</span>
                            <button type="button" class="btn text-light fw-bold me-3 mt-auto mb-4" id="coverUploadBtn" style="background-color: #252734; border-radius: 10px; width: 12em;">
                                Unggah Cover Buku
                                <img src="/img/svg/upload_book.svg" alt="upload" style="width: 23px">
                            </button>
                        </div>
                        <input type="file" name="cover_image" class="form-control d-none" accept=".jpg" aria-label="Cover Buku" id="coverInput">
                    </div>


                    <div class="d-flex flex-row">
                        <div class="ms-auto mt-4">
                            <button type="submit" class="btn btn-secondary fw-bold fs-5" style="width: 6vw">Unggah</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#deskripsi').on('input', function() {
                var charCount = $(this).val().length;
                $('#char-count').text(charCount + '/500');
            });
        });
        document.getElementById('pdfUploadBtn').addEventListener('click', function() {
            document.getElementById('pdfInput').click();
        });

        document.getElementById('pdfInput').addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                document.getElementById('pdfName').innerText = file.name;
            } else {
                document.getElementById('pdfName').innerText = '';
            }
        });

        document.getElementById('coverUploadBtn').addEventListener('click', function() {
            document.getElementById('coverInput').click();
        });

        document.getElementById('coverInput').addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('coverPreview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                document.getElementById('coverPreview').src = '/img/default_preview.png';
            }
        });
    </script>
@endsection
