@extends('layouts.main')

@section('container')
    <div class="main-bg">
        <div class="white-container p-3">
            <h2 class="fw-bold p-3 mb-4">Buat Komunitas</h2>
            <form method="POST" action="{{ route('community.create') }}" enctype="multipart/form-data">
                @csrf
                <div class="ms-5 fw-bold" style="width: 90%">
                    <div class="input-group mb-3 align-items-center">
                        <span class="input-label">Nama Komunitas</span>
                        <input type="text" name="nama" class="form-control" placeholder="Tulis nama komunitas..." aria-label="Judul">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-label">Deskripsi Komunitas</span>
                        <div class="position-relative input-group form-control" style="padding: 0; border: 0">
                            <textarea id="deskripsi" name="deskripsi" class="form-control" maxlength="100" placeholder="Tulis deskripsi komunitas..." aria-label="Deskripsi" style="height: 10em;"></textarea>
                            <div class="position-absolute bottom-0 end-0 me-3" style="pointer-events: none; font-size: 16px; opacity: 50%; z-index:500">
                                <span id="char-count" class="">0/100</span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3 align-items-center">
                        <span class="input-label">Media Sosial</span>
                        <input type="text" name="social_media" class="form-control" placeholder="Tulis media sosial..." aria-label="Social Media">
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="input-group mb-3" style="background-color: white;">
                                <div class="input-group-prepend">
                                    <div class="mb-3" id="profilePreviewContainer">
                                        <img src="/img/default_preview.png" alt="Profile Preview" id="profilePreview" style="max-width: 200px; max-height: 200px;">
                                    </div>
                                </div>

                                <div class="p-3 d-flex flex-column">
                                    <span class="fs-5 fw-bold">Unggah Profil Komunitas</span>
                                    <span class="opacity-50">*Ukuran maksimal profil komunitas sebesar 2 MB</span>
                                    <button type="button" class="btn text-light fw-bold me-3 mt-auto mb-4" id="profileUploadBtn" style="background-color: #252734; border-radius: 10px; width: 14em;">
                                        Unggah Profil Komunitas
                                        <img src="/img/svg/upload_book.svg" alt="upload" style="width: 23px">
                                    </button>
                                </div>

                                <input type="file" name="profile_picture" class="form-control d-none" accept="image/*" aria-label="Profil" id="profileInput">
                            </div>
                        </div>
                        <div class="col">
                            <div class="col">
                                <div class="input-group mb-3" style="background-color: white;">
                                    <div class="input-group-prepend">
                                        <div class="mb-3" id="coverPreviewContainer">
                                            <img src="/img/default_preview.png" alt="Cover Preview" id="coverPreview" style="max-width: 200px; max-height: 200px;">
                                        </div>
                                    </div>

                                    <div class="p-3 d-flex flex-column">
                                        <span class="fs-5 fw-bold">Unggah Cover</span>
                                        <span class="opacity-50">*Ukuran maksimal cover komunitas sebesar 2 MB</span>
                                        <button type="button" class="btn text-light fw-bold me-3 mt-auto mb-4" id="coverUploadBtn" style="background-color: #252734; border-radius: 10px; width: 14em;">
                                            Unggah Cover Komunitas
                                            <img src="/img/svg/upload_book.svg" alt="upload" style="width: 23px">
                                        </button>
                                    </div>

                                    <input type="file" name="background_cover" class="form-control d-none" accept="image/*" aria-label="Cover" id="coverInput">
                                </div>
                            </div>
                        </div>
                    </div>


                    @if ($errors->any())
                        <div>
                            @foreach ($errors->all() as $error)
                                <div class="text-danger">{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success mt-3">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger mt-3">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="d-flex flex-row">
                        <div class="ms-auto mt-4">
                            <button type="submit" class="btn btn-secondary fw-bold" style="width: 6vw">Kirim</button>
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
                $('#char-count').text(charCount + '/100');
            });
        });

        document.getElementById('profileUploadBtn').addEventListener('click', function() {
            document.getElementById('profileInput').click();
        });

        document.getElementById('profileInput').addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profilePreview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                document.getElementById('profilePreview').src = '/img/default_preview.png';
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
