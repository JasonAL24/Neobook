<div class="container">
    <table class="table text-center">
        <thead>
        <tr class="table-dark">
            <th scope="col">ID</th>
            <th scope="col">Nama</th>
            <th scope="col">Status</th>
            <th scope="col" style="width: 10em"></th>
            <th scope="col" style="width: 10em"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($members as $member)
            <tr style="height: 4em" class="text-align-center">
                <td class="align-middle">{{ $member->id }}</td>
                <td class="align-middle">
                    {{$member->name}}
                </td>
                <td class="{{$member->premium_status ? "text-success" : ""}} align-middle">
                    {{$member->premium_status ? "Premium" : "Member"}}
                </td>

                <td class="align-middle">
                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#confirmModal{{$member->id}}">
                        Ubah Status
                    </button>
                </td>

                {{--                                Modal untuk ganti status--}}
                <div class="modal fade" id="confirmModal{{ $member->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmModalLabel">Ubah Status Member</h5>
                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                Apakah Anda yakin ingin mengubah status member menjadi <span class="{{ $member->premium_status ? '' : 'text-success' }}">{{$member->premium_status ? 'Member' : 'Premium' }}</span>?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <form action="{{route('admin.members.change-status')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="premium_status" value="{{ $member->premium_status ? 0 : 1 }}">
                                    <input type="hidden" name="member_id" value="{{ $member->id }}">
                                    <button type="submit" class="btn btn-primary btn-confirm-status-change"
                                            data-member-id="{{ $member->id }}">
                                        Ya, Ubah Status
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <td class="align-middle">
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{$member->id}}">
                        Hapus
                    </button>
                </td>
                <div class="modal fade" id="deleteModal{{ $member->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmModalLabel">Hapus Pengguna</h5>
                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                Apakah Anda yakin untuk menghapus pengguna {{$member->name}}?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <form action="{{route('admin.member.delete')}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="member_id" value="{{ $member->id }}">
                                    <button type="submit" class="btn btn-danger btn-confirm-status-change"
                                            data-member-id="{{ $member->id }}">
                                        Ya, Hapus Pengguna
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="d-flex text-center justify-content-center text-align-center">
        {{ $members instanceof \Illuminate\Pagination\LengthAwarePaginator ? $members->onEachSide(1)->links('vendor.pagination.bootstrap-4') : '' }}
    </div>
    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
</div>
