@extends('layouts.main')

@section('container')
    <div class="main-bg">
        <div>
            <div class="container">
                <div class="d-flex flex-column align-items-center">
                    <div class="profile-form text-center">
                        @php
                            $profile_picture = $member->profile_picture;
                            if ($profile_picture == null){
                                $profile_picture = 'default_pp.png';
                            }
                        @endphp
                        <img src="/img/profile/{{$member->id}}/{{$profile_picture}}" alt="profile picture" style="width: 200px; height: 200px" class="rounded-circle">
                    </div>
                    <button id="uploadButton" class="btn text-light" style="width: 6vw; background-color: #252734; margin-top:-2em;">Ubah</button>
                    <form id="uploadForm" action="{{ route('upload.profile.picture') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" class="btn text-light" id="fileInput" name="profile_picture" accept=".png" style="display: none;">
                    </form>

                    <div class="profile-form align-items-center">
                        <form method="POST" action="{{ route('members.update', $member->id) }}">
                            @csrf
                            @method('PUT')
                            <label for="name" class="form-label mt-3">Nama</label>
                            <input type="text" class="form-control" name="name" value="{{ $member->name }}">

                            <label for="email" class="form-label mt-3">Email</label>
                            <input type="text" class="form-control" name="email" value="{{ $member->user->email }}">

                            <label for="phone" class="form-label mt-3">Nomor Handphone</label>
                            <input type="text" class="form-control" name="phone" value="{{ $member->phone }}">

                            <label for="address" class="form-label mt-3">Alamat</label>
                            <input type="text" class="form-control" name="address" value="{{ $member->address }}">
                            <div class="d-flex flex-row">
                                <div class="ms-auto mt-4">
                                    <button type="submit" class="btn btn-secondary" style="width: 6vw">Simpan</button>
                                </div>
                            </div>
                        </form>
                        @if (session('success'))
                            <div class="alert alert-success mt-3">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger mt-3">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-light text-danger mt-4" style="width: 40vw">Logout</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        document.getElementById('uploadButton').addEventListener('click', function() {
            document.getElementById('fileInput').click();
        });

        document.getElementById('fileInput').addEventListener('change', function() {
            document.getElementById('uploadForm').submit();
        });
    </script>
@endsection
