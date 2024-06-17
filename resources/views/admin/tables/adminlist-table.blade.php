<div class="container">
    <table class="table text-center">
        <thead>
        <tr class="table-dark">
            <th scope="col">ID</th>
            <th scope="col">Nama</th>
            <th scope="col">Email</th>
            <th scope="col">Status</th>
{{--            <th scope="col" style="width: 10em"></th>--}}
        </tr>
        </thead>
        <tbody>
        @foreach($admins as $admin)
            <tr style="height: 4em" class="text-align-center">
                <td class="align-middle">{{ $admin->id }}</td>
                <td class="align-middle">
                    {{$admin->name}}
                </td>
                <td class="align-middle">
                    {{$admin->email}}
                </td>
                <td class="align-middle">
                    {{ucfirst($admin->role)}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="d-flex text-center justify-content-center text-align-center">
        {{ $admins instanceof \Illuminate\Pagination\LengthAwarePaginator ? $admins->onEachSide(1)->links('vendor.pagination.bootstrap-4') : '' }}
    </div>
    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
</div>
