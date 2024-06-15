@extends('layouts.admin')

@section('container')
    <div class="p-4 mt-4">
        <h1>Daftar Pengguna</h1>
        <form action="{{ route('admin.member.search') }}" method="GET" class="mb-4">
            <div class="input-group" style="width: 35vw;">
                <input type="text" name="query" class="form-control" placeholder="Cari pengguna...">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>
        <div class="mt-4">
            @if($members->isEmpty())
                <h3><a href="{{route('admin.userlist')}}" class="btn btn-secondary me-2">&#8592; Balik</a>Tidak ada pengguna '{{$query}}' tersedia.</h3>
            @else
                <h3><a href="{{route('admin.userlist')}}" class="btn btn-secondary me-2">&#8592; Balik</a>Berikut hasil pencarian user '{{$query}}'</h3>
                @include('admin.tables.userlist-table')
            @endif
        </div>
    </div>
@endsection
