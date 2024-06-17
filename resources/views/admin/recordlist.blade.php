@extends('layouts.admin')

@section('container')
    <div class="p-4 mt-4">
        <h1>Daftar Buku yang Diunggah</h1>
        <div class="mt-4">
            @if($records->isEmpty())
                <p>Tidak ada buku yang telah diunggah.</p>
            @else
                @include('admin.tables.recordlist-table')
            @endif
        </div>
        @if (session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif
    </div>
@endsection
