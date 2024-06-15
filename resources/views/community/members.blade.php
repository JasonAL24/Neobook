@extends('layouts.main')

@section('container')
    <div class="main-bg">
        <div class="white-container ms-4" style="width: 87vw">
            @if($community->background_cover)
                <img src="/img/communities/background_cover/{{$community->id}}/{{$community->background_cover}}"
                     alt="{{$community->name}}" style="width: 100%; height: 200px">
            @else
                <img src="/img/communities/background_cover/default_background_cover.png" alt="Default Background Cover"
                     style="width: 100%; height: 200px">
            @endif
            <div class="row">
                <div class="col pb-3 mt-3 text-center d-flex flex-column align-items-center">
                    @if($community->profile_picture)
                        <img src="/img/communities/profile_picture/{{$community->id}}/{{$community->profile_picture}}"
                             alt="{{$community->name}}" class="pp-komunitas-detail">
                    @else
                        <img src="/img/communities/profile_picture/default_profile_picture.png"
                             alt="Default Group Picture" class="pp-komunitas-detail">
                    @endif
                    <span class="fw-bold fs-4">Anggota {{$community->name}}</span>
                    <ul>
                        <li>{{count($members)}} Anggota</li>
                    </ul>

                </div>
            </div>
            <div class="container mt-3 p-3">
                @foreach($communityMembers as $communityMember)
                    <div class="row align-items-center p-3 mb-4 border-1" style="box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);">
                        <div class="col-auto">
                            @if ($communityMember->member->profile_picture)
                                <img src="/img/profile/{{$communityMember->member->id}}/{{$communityMember->member->profile_picture}}"
                                     alt="profile picture" style="width: 56px; height: 56px;"
                                     class="rounded-circle">
                            @else
                                <img src="/img/profile/default_pp.png" alt="profile picture"
                                     style="width: 56px; height: 56px;" class="rounded-circle">
                            @endif
                        </div>
                        <div class="col-lg-5 d-flex flex-row align-items-center">
                            {{$communityMember->member->name}}
                            <img src="/img/svg/checkmark.svg" alt="checkmark" class="{{$communityMember->member->premium_status ? 'd-block' : 'd-none'}} ms-2">
                        </div>
                        <div class="col">
                            {{ucfirst($communityMember->membership_status)}}
                        </div>
                        @if($communityMember->membership_status != 'moderator' && $isModerator)
                            <div class="col">
                                <div class="d-flex">
                                    <button class="btn ms-auto delete-member" data-member-id="{{ $communityMember->member->id }}" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal">
                                        <img src="/img/svg/trash_grey.svg" alt="Kick Anggota">
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header d-flex flex-row" style="border-bottom: 0;">
                            <h5 class="modal-title" id="deleteConfirmationModalLabel">Konfirmasi Penghapusan</h5>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">
                            Apakah kamu yakin untuk menghapus anggota ini dari grup?
                        </div>
                        <div class="modal-footer" style="border-top: 0;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteButton">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#isi').on('input', function () {
                var charCount = $(this).val().length;
                $('#char-count').text(charCount + '/100');
            });
        });

        document.querySelectorAll('.delete-member').forEach(button => {
            button.addEventListener('click', function() {
                const memberId = this.getAttribute('data-member-id');
                document.getElementById('confirmDeleteButton').setAttribute('data-member-id', memberId);
            });
        });

        document.getElementById('confirmDeleteButton').addEventListener('click', function() {
            const memberId = this.getAttribute('data-member-id');
            const url = `/community/{{ $community->id }}/member/${memberId}`;

            $.ajax({
                url: url,
                type: 'DELETE',
                ``headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },``
                success: function(response) {
                    console.log(response.message);
                    const row = document.querySelector(`button[data-member-id="${memberId}"]`).closest('.row');
                    $(row).fadeOut(500, function() {
                        row.remove();
                    });
                    $('#deleteConfirmationModal').modal('hide');
                },
                error: function(xhr, status, error) {
                    console.error('Error removing member:', error);
                    $('#deleteConfirmationModal').modal('hide');
                }
            });
        });
    </script>
@endsection
