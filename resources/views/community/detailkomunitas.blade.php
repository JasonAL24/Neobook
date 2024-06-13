@extends('layouts.main')

@section('container')
    <div class="main-bg">
        <div class="white-container ms-4" style="width: 87vw">
            <button class="btn p-0" id="uploadBackgroundCoverButton" style="pointer-events: {{$isModerator ? 'auto' : 'none'}}">
                <div class="book-container">
                    @if($community->background_cover)
                        <img src="/img/communities/background_cover/{{$community->id}}/{{$community->background_cover}}"
                             alt="{{$community->name}}" style="width: 87vw; height: 200px; border-radius: 10px 10px 0 0">
                    @else
                        <img src="/img/communities/background_cover/default_background_cover.png" alt="Default Background Cover"
                             style="width: 100%; height: 200px">
                    @endif
                    <div class="overlay d-flex flex-column" style="width: 100%; height: 200px">
                        <img src="/img/svg/trash.svg" alt="Ubah" style="width: 3em">
                        <span class="text-overlay">Ubah</span>
                    </div>
                </div>
            </button>
            <form id="uploadBackgroundCover" action="{{ route('community.upload.background', ['community' => $community->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" class="btn text-light" id="backgroundInput" name="background_cover" accept="image/*" style="display: none;">
            </form>
            <div class="row">
                <div class="col-lg-3 p-3 text-center d-flex flex-column align-items-center">
                    <button class="btn p-0" id="uploadPPButton" style="pointer-events: {{$isModerator ? 'auto' : 'none'}}">
                        <div class="book-container">
                            @if($community->profile_picture)
                                <img src="/img/communities/profile_picture/{{$community->id}}/{{$community->profile_picture}}"
                                     alt="{{$community->name}}" class="pp-komunitas-detail">
                            @else
                                <img src="/img/communities/profile_picture/default_profile_picture.png"
                                     alt="Default Group Picture" class="pp-komunitas-detail">
                            @endif
                            <div class="overlay d-flex flex-column pp-komunitas-detail">
                                <img src="/img/svg/trash.svg" alt="Ubah">
                                <span class="text-overlay">Ubah</span>
                            </div>
                        </div>
                    </button>
                    <form id="uploadPP" action="{{ route('community.upload.pp', ['community' => $community->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" class="btn text-light" id="ppInput" name="profile_picture" accept="image/*" style="display: none;">
                    </form>
                    @if(!$isMember)
                        <form action="{{ route('community.join', ['community' => $community->id]) }}" method="POST"
                              style="width: 100%;">
                            @csrf
                            <button type="submit" class="btn text-light fw-bold fs-5"
                                    style="background-color: #252734; width: 40%">
                                <img src="/img/svg/plus.svg" alt="+" style="width: 24px; height: 24px">
                                Ikuti
                            </button>
                        </form>
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
                    <span class="fw-bold mt-5">Anggota</span>
                    <div class="d-flex flex-row ms-3 mt-3">
                        @php $count = 0 @endphp
                        @foreach($members as $member)
                            @if ($count < 3)
                                @if ($member->profile_picture)
                                    <img src="/img/profile/{{$member->id}}/{{$member->profile_picture}}"
                                         alt="profile picture" style="width: 56px; height: 56px; margin-left: -1em;"
                                         class="rounded-circle">
                                @else
                                    <img src="/img/profile/default_pp.png" alt="profile picture"
                                         style="width: 56px; height: 56px; margin-left: -1em;" class="rounded-circle">
                                @endif
                            @endif
                            @php $count++ @endphp
                        @endforeach
                    </div>
                    <a href="{{route('community.members', ['community' => $community->id])}}" class="mt-5">Lihat lebih
                        banyak</a>

                    <span class="fw-bold mt-5 mb-3">Moderator</span>
                    @foreach($moderators as $moderator)
                        <div class="row align-items-center mb-2">
                            <div class="col-auto">
                                @if ($moderator->member->profile_picture)
                                    <img
                                        src="/img/profile/{{$moderator->member->id}}/{{$moderator->member->profile_picture}}"
                                        alt="profile picture" style="width: 56px; height: 56px;" class="rounded-circle">
                                @else
                                    <img src="/img/profile/default_pp.png" alt="profile picture"
                                         style="width: 56px; height: 56px;" class="rounded-circle">
                                @endif
                            </div>
                            <div class="col p-0">
                                <span>{{ $moderator->member->name }}</span>
                            </div>
                        </div>
                    @endforeach

                    @if($community->social_media)
                        <span class="fw-bold mt-5 mb-3">Media Sosial</span>
                        <div class="row align-items-center mb-2">
                            <div class="col p-0">
                                <span>{{$community->social_media}}</span>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col d-flex flex-column">
                    <div class="small-white-container p-3" style="margin-top: -3em; z-index: 500">
                        <div class="fw-bold fs-4">{{$community->name}}</div>
                        <div>{{count($community->communitymembers)}} Anggota</div>
                        <div class="fw-bold mt-3">Tentang Kami</div>
                        <div>{!! $community->description !!}</div>
                    </div>

                    <div class="small-white-container p-3">
                        <div class="d-flex flex-row">
                            <div class="fw-bold fs-4">Pengumuman</div>
                            @if($isModerator)
                                <button type="button" class="btn text-light fw-bold ms-auto"
                                        style="background-color: #252734;" data-bs-toggle="collapse"
                                        data-bs-target="#announcementForm" aria-expanded="false"
                                        aria-controls="announcementForm">
                                    <img src="/img/svg/plus.svg" alt="+" style="width: 20px; height: 20px">
                                    Tambah
                                </button>
                            @endif
                        </div>
                        <div class="collapse mt-4" id="announcementForm">
                            <form method="POST"
                                  action="{{ route('community.createAnnouncement', ['community' => $community->id])}}">
                                @csrf
                                <div class="input-group mb-3 align-items-center">
                                    <span class="input-label">Judul Pengumuman</span>
                                    <input type="text" name="judul" class="form-control"
                                           placeholder="Tulis judul pengumuman..." aria-label="Judul">
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-label">Isi Pengumuman</span>
                                    <div class="position-relative input-group form-control"
                                         style="padding: 0; outline: 0; border: 0">
                                        <textarea id="isi" name="isi" class="form-control" maxlength="100"
                                                  placeholder="Tulis isi pengumuman..." aria-label="Pengumuman"
                                                  style="height: 10em;"></textarea>
                                        <div class="position-absolute bottom-0 end-0 me-3"
                                             style="pointer-events: none; font-size: 16px; opacity: 50%; z-index:500">
                                            <span id="char-count" class="">0/100</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-row">
                                    <div class="ms-auto mt-3">
                                        <button type="submit" class="btn btn-secondary fw-bold" style="width: 6vw">
                                            Kirim
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div>
                            @foreach($announcements as $announcement)
                                <div class="d-flex flex-row mt-4">
                                    <div class="fw-bold">{{$announcement->title}}</div>
                                    <div class="ms-auto"> {{$announcement->created_at->format('d-m-Y')}}</div>
                                </div>
                                <div>{{$announcement->content}}</div>

                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('community.chat.index')

    <script>
        $(document).ready(function () {
            $('#isi').on('input', function () {
                var charCount = $(this).val().length;
                $('#char-count').text(charCount + '/100');
            });
        });

        document.getElementById('uploadBackgroundCoverButton').addEventListener('click', function() {
            document.getElementById('backgroundInput').click();
        });

        document.getElementById('backgroundInput').addEventListener('change', function() {
            document.getElementById('uploadBackgroundCover').submit();
        });

        document.getElementById('uploadPPButton').addEventListener('click', function() {
            document.getElementById('ppInput').click();
        });

        document.getElementById('ppInput').addEventListener('change', function() {
            document.getElementById('uploadPP').submit();
        });
    </script>
@endsection
