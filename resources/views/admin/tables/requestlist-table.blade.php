<div class="container">
    <table class="table">
        <thead>
        <tr class="table-dark">
            <th scope="col">Nama</th>
            <th scope="col">Email</th>
            <th scope="col">Tipe Permohonan</th>
            <th scope="col">Isi Permohonan</th>
        </tr>
        </thead>
        <tbody>
        @foreach($requests as $request)
            <tr style="height: 4em" class="text-align-center">
                <td class="align-middle">
                    {{$request->name}}
                </td>
                <td class="align-middle">
                    {{$request->email}}
                </td>
                <td class="align-middle">
                    {{$request->type}}
                </td>
                <td class="align-middle" style="max-width: 30vw">
                    {{$request->content}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="d-flex text-center justify-content-center text-align-center">
        {{ $requests instanceof \Illuminate\Pagination\LengthAwarePaginator ? $requests->onEachSide(1)->links('vendor.pagination.bootstrap-4') : '' }}
    </div>
</div>
