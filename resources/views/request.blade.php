@extends('layouts.main')

@section('container')
    <div class="main-bg">
        <div style="width: 80vw">
            <h2 class="fw-bold">Buat Permohonan Baru</h2>
            @if ($errors->any())
                <ul class="alert alert-danger ms-5">
                    <div class="fw-bold">Error! Mohon kirim ulang. Berikut error yang didapat:</div>
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
            <form method="POST" action="{{ route('request.upload')}}">
                @csrf
                <label for="name" class="form-label mt-3 fw-bold">Nama</label>
                <input type="text" class="form-control" name="name" value="{{ $member->name }}" placeholder="Tulis nama anda...">

                <label for="email" class="form-label mt-3 fw-bold">Email</label>
                <input type="text" class="form-control" name="email" value="{{ $member->user->email }}" placeholder="Tulis email anda...">

                <label for="tipePermohonan" class="form-label mt-3 fw-bold">Tipe Permohonan</label>
                <div class="input-group mb-3 align-items-center" style="width: 40vw">
                    <select name="tipePermohonan" class="form-select" aria-label="Type">
                        <option selected disabled>Pilih tipe permohonan</option>
                        <option value="Melaporkan Bug">Melaporkan Bug</option>
                        <option value="Saran">Saran</option>
                        <option value="Mengajukan Buku Baru">Mengajukan Buku Baru</option>
                    </select>
                </div>

                <label for="detailPermohonan" class="form-label mt-3 fw-bold">Isi Detail Permohonan</label>
                <div class="input-group mb-3">
                    <div class="position-relative input-group form-control" style="padding: 0; border: 0">
                        <textarea id="detailPermohonan" name="detailPermohonan" class="form-control" maxlength="500" placeholder="Tulis detail permohonan..." aria-label="contentRequest" style="height: 10em;"></textarea>
                        <div class="position-absolute bottom-0 end-0 me-3" style="pointer-events: none; font-size: 16px; opacity: 50%; z-index:500">
                            <span id="char-count" class="">0/500</span>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-row">
                    <div class="ms-auto mt-4">
                        <button type="submit" class="btn btn-secondary" style="width: 6vw">Kirim</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
    <script>
        $(document).ready(function() {
            $('#detailPermohonan').on('input', function() {
                var charCount = $(this).val().length;
                $('#char-count').text(charCount + '/500');
            });
        });
    </script>
@endsection
