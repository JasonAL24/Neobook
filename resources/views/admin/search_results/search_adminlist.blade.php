@extends('layouts.admin')

@section('container')
    <div class="p-4 mt-4">
        <h1>Daftar Admin</h1>
        <div class="mt-4">
            <!-- Search Form -->
            <div class="d-flex mb-4" style="width: 78.9vw">
                <form action="{{ route('admin.admins.search') }}" method="GET">
                    <div class="input-group" style="width: 35vw;">
                        <input type="text" name="query" class="form-control" placeholder="Cari admin...">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </form>

                <a href="{{route('admin.admins.add')}}" class="btn btn-secondary ms-auto" style="background-color: #222222">
                    Tambah Admin <img src="/img/svg/plus_round.svg" alt="+">
                </a>
            </div>


            @if($admins->isEmpty())
                <h3><a href="{{route('admin.adminlist')}}" class="btn btn-secondary me-2">&#8592; Balik</a>Tidak ada admin '{{$query}}' tersedia.</h3>
            @else
                <h3><a href="{{route('admin.adminlist')}}" class="btn btn-secondary me-2">&#8592; Balik</a>Berikut hasil pencarian admin '{{$query}}'</h3>
                @include('admin.tables.adminlist-table')
            @endif
        </div>
    </div>
@endsection
