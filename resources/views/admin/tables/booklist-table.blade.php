<div class="container">
    <table class="table">
        <thead>
        <tr class="table-dark">
            <th scope="col" class="text-center" style="width: 1em">ID</th>
            <th scope="col" class="text-center" style="width: 8em">Cover</th>
            <th scope="col">Judul</th>
            <th scope="col">Status</th>
            <th scope="col" style="width: 10em"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($books as $book)
            <tr style="height: 4em" class="text-align-center">
                <td class="align-middle text-center">{{ $book->id }}</td>
                <td class="align-middle text-center">
                    <img onerror="this.onerror=null; this.src='/img/default_book.jpg';" src="/img/books/{{$book->filename}}.jpg" alt="{{$book->name}}" style="width: 40px;">
                </td>
                <td class="align-middle">
                    {{$book->name}}
                </td>
                <td class="align-middle {{$book->active ? "text-success" : "text-danger"}}">
                    {{$book->active ? "Aktif" : "Non Aktif"}}
                </td>
                <td class="align-middle">
                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#confirmModal{{$book->id}}">
                        Ubah
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="d-flex text-center justify-content-center text-align-center">
        {{ $books instanceof \Illuminate\Pagination\LengthAwarePaginator ? $books->onEachSide(1)->links('vendor.pagination.bootstrap-4') : '' }}
    </div>
    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
</div>
