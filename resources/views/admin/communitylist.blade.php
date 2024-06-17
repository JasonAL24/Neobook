@extends('layouts.admin')

@section('container')
    <div class="p-4 mt-4">
        <h1>Daftar Komunitas</h1>
        <div class="mt-4">
            <form action="{{ route('admin.community.search') }}" method="GET" class="mb-4">
                <div class="input-group" style="width: 35vw;">
                    <input type="text" name="query" class="form-control" placeholder="Cari komunitas...">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </form>
            @if($communities->isEmpty())
                <p>Tidak ada komunitas yang telah dibuat.</p>
            @else
                @include('admin.tables.communitylist-table')
            @endif
        </div>
    </div>
@endsection
