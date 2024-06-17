<div class="container">
    <table class="table">
        <thead>
        <tr class="table-dark">
            <th scope="col" class="text-center">ID</th>
            <th scope="col" class="text-center">Komunitas</th>
            <th scope="col">Moderator</th>
            <th scope="col">Jumlah Member</th>
            <th scope="col">Status</th>
            <th scope="col" style="width: 10em"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($communities as $community)
            @php
                $moderators = $community->communityMembers()
                                ->where('membership_status', 'moderator')
                                ->with('member')
                                ->get();
            @endphp
            <tr style="height: 4em" class="text-align-center">
                <td class="align-middle text-center">{{ $community->id }}</td>
                <td class="align-middle text-center">
                    {{$community->name}}
                </td>
                <td class="align-middle">
                    @foreach($moderators as $moderator)
                        {{$moderator->member->name}}
                    @endforeach
                </td>
                <td class="align-middle">
                    {{count($community->communitymembers)}}
                </td>
                <td class="align-middle {{$community->active ? "text-success" : "text-danger"}}">
                    {{$community->active ? "Aktif" : "Non Aktif"}}
                </td>
                <td class="align-middle">
                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#changeStatusModal{{$community->id}}">
                        Ubah
                    </button>
                </td>
                <div class="modal fade" id="changeStatusModal{{$community->id}}" tabindex="-1" aria-labelledby="changeStatusModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header d-flex flex-row" style="border-bottom: 0;">
                                <h5 class="modal-title" id="changeStatusModalLabel">Konfirmasi Perubahan Status</h5>
                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Ubah Status Komunitas Menjadi <span class="{{$community->active ? 'text-danger' : 'text-success'}}">{{$community->active ? "Non-Aktif" : "Aktif"}}</span>?</p>
                            </div>
                            <div class="modal-footer" style="border-top: 0;">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <form action="{{route('admin.community.change-status')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="community_status" value="{{ $community->active ? 0 : 1 }}">
                                    <input type="hidden" name="community_id" value="{{ $community->id }}">
                                    <button type="submit" class="btn btn-primary btn-confirm-status-change"
                                            data-member-id="{{ $community->id }}">
                                        Ya, Ubah Status
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
        {{ $communities instanceof \Illuminate\Pagination\LengthAwarePaginator ? $communities->onEachSide(1)->links('vendor.pagination.bootstrap-4') : '' }}
    </div>
    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
</div>
