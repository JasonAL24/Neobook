@extends('layouts.main')

@section('container')
    <div class="white-container p-3">
        <div class="p-4">
            <h1 class="fw-bold mb-3">Komunitas</h1>
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
            <h3 class="mb-4"><a href="{{route('viewAllCommunity')}}" class="btn btn-secondary me-2">&#8592; Balik</a>Hasil pencarian untuk "{{$query}}"</h3>
            @foreach($results as $com)
                <div class="row mb-3">
                    <div class="col-auto">
                        <a href="/komunitas/{{$com->id}}">
                            @if($com->profile_picture)
                                <img src="/img/communities/profile_picture/{{$com->id}}/{{$com->profile_picture}}"
                                     alt="{{$com->name}}" style="width: 128px; height: 128px;">
                            @else
                                <img src="/img/communities/profile_picture/default_profile_picture.png"
                                     alt="Default Group Picture" style="width: 128px; height: 128px;">
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
            @endforeach
        </div>
    </div>
    @include('community.chat.index')
    <script src="/js/komunitas.js"></script>
@endsection
