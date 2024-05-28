@extends('layouts.main')

@section('container')
    <div class="white-container p-3">
        <div class="p-4 pb-0 pt-2">
            <h1 class="fw-bold mb-3">Komunitas</h1>
            @php $locked = !$member->premium_status @endphp
            @if(!$locked)
                <form onsubmit="return redirectToSearch()" method="GET">
                    <div class="row align-items-center mb-4">
                        <div class="col-auto p-0 ps-2">
                            <img src="/img/svg/Search_light.svg" alt="search">
                        </div>
                        <div class="col-lg-6 p-0">
                            <input class="form-control me-2 ms-2" name="query" type="search" id="searchCommunityInput" placeholder="cari nama grup..." aria-label="Search">
                        </div>
                        <div class="col">
                            <button type="submit" class="btn text-light" style="background-color: #252734; width: 6em">
                                Cari
                            </button>
                        </div>
                    </div>
                </form>
                <div class="position-absolute bottom-0 end-0 p-4">
                    <a href="/buatkomunitas" class="btn text-light rounded-circle create-button" style="background-color: #252734; width: 5em; height: 5em">
                        <img src="/img/svg/plus.svg" alt="plus" style="width: 4em; margin-left: -.3em;" class="rounded-circle">
                    </a>
                    <div class="mt-2 create-text" style="margin-left: -1em;">Buat Komunitas</div>
                </div>
                <h3 class="mb-4">Grup Terpopuler</h3>
                @php
                    $sortedCommunities = $communities->sortByDesc(function($community) {
                        return $community->communitymembers->count();
                    });
                    $count = 0;
                @endphp

                @foreach($sortedCommunities as $com)
                    @if ($count < 4)
                    <div class="row mb-3">
                        <div class="col-auto">
                            <a href="/komunitas/{{$com->id}}">
                                @if($com->profile_picture)
                                    <img src="/img/communities/profile_picture/{{$com->id}}/{{$com->profile_picture}}"
                                         alt="{{$com->name}}" style="width: 128px; height: 128px;" class="rounded">
                                @else
                                    <img src="/img/communities/profile_picture/default_profile_picture.png"
                                         alt="Default Group Picture" style="width: 128px; height: 128px;" class="rounded">
                                @endif
                            </a>
                        </div>
                        <div class="col d-flex flex-column">
                            <a href="/komunitas/{{$com->id}}" class="no-blue text-decoration-none">
                                <span class="fw-bold">{{$com->name}}</span>
                            </a>
                            <span>{{count($com->communitymembers)}} Anggota</span>
                            <span class="mt-auto mb-2">{!! $com->description !!}</span>
                        </div>
                    </div>
                    @php $count++ @endphp
                    @endif
                @endforeach
            @else
                <div class="container text-center mt-5 pb-4">
                    <h3 class="fw-bold">Ayo langganan sekarang juga untuk buka fitur ini!</h3>
                    <a href="/langganan" class="btn p-2 text-light fs-4 mt-5" style="background-color: #252734;">
                        Langganan Sekarang!
                    </a>
                </div>
            @endif
        </div>
    </div>
    @if(!$locked)
        @include('community.chat.index')
    @endif
    <script src="/js/komunitas.js"></script>

@endsection
