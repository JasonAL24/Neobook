@extends('layouts.admin')

@section('container')
    <div class="p-4 mt-4">
        <h1>Daftar Buku</h1>
        <div class="mt-4">
            <!-- Search Form -->
            <div class="d-flex mb-4" style="width: 78.9vw">
                <form action="{{ route('admin.books.search') }}" method="GET">
                    <div class="input-group" style="width: 35vw;">
                        <input type="text" name="query" class="form-control" placeholder="Cari buku...">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </form>

                <a href="{{route('admin.books.upload')}}" class="btn btn-secondary ms-auto" style="background-color: #222222">
                    Unggah Buku <img src="/img/svg/plus_round.svg" alt="+">
                </a>
            </div>

            @if($books->isEmpty())
                <p>Tidak ada buku '{{$query}}' tersedia.</p>
            @else
                <h3><a href="{{route('admin.booklist')}}" class="btn btn-secondary me-2">&#8592; Balik</a>Berikut hasil pencarian buku '{{$query}}'</h3>
                @include('admin.tables.booklist-table')
            @endif
        </div>
    </div>
@endsection
