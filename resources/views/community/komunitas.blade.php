@extends('layouts.main')

@section('container')
    <div class="white-container p-3">
        <div class="p-4">
            <h1 class="fw-bold mb-3">Komunitas</h1>
            {{-- Search for Groups --}}
            <h3 class="mb-4">Grup Terpopuler</h3>
            @foreach($communities as $com)
                <div class="row mb-3">
                    <div class="col-auto">
                        <a href="/komunitas/{{$com->id}}">
                            @if($com->profile_picture)
                                <img src="/img/communities/profile_picture/{{$com->profile_picture}}"
                                     alt="{{$com->title}}" style="width: 128px; height: 128px;">
                            @else
                                <img src="/img/communities/profile_picture/default_profile_picture.png"
                                     alt="Default Group Picture" style="width: 128px; height: 128px;">
                            @endif
                        </a>
                    </div>
                    <div class="col d-flex flex-column">
                        <a href="/komunitas/{{$com->id}}" class="no-blue text-decoration-none">
                            <span class="fw-bold">{{$com->title}}</span>
                        </a>
                        <span>{{count($com->communitymembers)}} Anggota</span>
                        <span class="mt-auto mb-2">{{$com->description}}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @include('community.chat.index')
@endsection
