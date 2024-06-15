@extends('layouts.admin')

@section('container')
    <div class="p-4 mt-4">
        <h1>Daftar Pengguna</h1>
        <div class="mt-4">
            <form action="{{ route('admin.member.search') }}" method="GET" class="mb-4">
                <div class="input-group" style="width: 35vw;">
                    <input type="text" name="query" class="form-control" placeholder="Cari pengguna...">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </form>
            @if($members->isEmpty())
                <p>Tidak ada user tersedia.</p>
            @else
                @include('admin.tables.userlist-table')
            @endif
        </div>
    </div>
@endsection
