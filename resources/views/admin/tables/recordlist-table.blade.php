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
        @foreach($records as $record)
            <tr style="height: 4em" class="text-align-center">
                <td class="align-middle text-center">{{ $record->book->id }}</td>
                <td class="align-middle text-center">
                    <img onerror="this.onerror=null; this.src='/img/default_book.jpg';" src="/img/books/{{$record->book->cover_image}}.jpg" alt="{{$record->book->name}}" style="width: 40px;">
                </td>
                <td class="align-middle">
                    {{$record->book->name}}
                </td>
                <td class="align-middle {{$record->status === 'Disetujui' ? 'text-success' : ($record->status === 'Ditolak' ? 'text-danger': '')}}">
                    {{$record->status}}
                </td>

                <td class="align-middle">
                    <a href="/admin/uploadedbooks/{{$record->book->id}}/view" class="btn btn-secondary">
                        Detail
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="d-flex text-center justify-content-center text-align-center">
        {{ $records instanceof \Illuminate\Pagination\LengthAwarePaginator ? $records->onEachSide(1)->links('vendor.pagination.bootstrap-4') : '' }}
    </div>
    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
</div>
