<div class="container">
    <div class="row justify-content-end">
        <div class="col-auto user-notification p-3 me-5">
            <div class="d-flex flex-row">
                <a href="{{route('profile')}}" class="no-blue mt-1">
                    <div class="d-flex flex-row align-items-center">
                        @if ($member->profile_picture)
                            <img src="/img/profile/{{$member->id}}/{{ $member->profile_picture }}" alt="profile picture" class="profile-picture rounded-circle">
                        @else
                            <img src="/img/profile/default_pp.png" alt="default profile picture" class="profile-picture rounded-circle">
                        @endif
                        <p class="mb-0 ms-2">{{ explode(' ', $member->name)[0] }}</p>
                        <img src="/img/svg/checkmark.svg" alt="checkmark" class="{{$member->premium_status ? 'd-block' : 'd-none'}}">
                    </div>
                </a>

                <button class="btn notification ms-3 position-relative p-0 border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#notifications" aria-controls="notifications">
                    <img src="/img/svg/Bell_light.svg" alt="Notification">
                    @php $unreadCount = $member->notifications->where('status', 'unread')->count(); @endphp
                    @if ($unreadCount > 0)
                    <span class="badge position-absolute top-0 end-0">{{$unreadCount}}</span>
                    @endif
                </button>

                <div class="offcanvas offcanvas-end" tabindex="-1" id="notifications" aria-labelledby="notificationsLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title fw-bold fs-4 p-2" id="notificationsLabel">Notifikasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div>
                        <div class="btn-group mb-3 ms-5" role="group" aria-label="Filter notifications">
                            <button type="button" class="btn btn-outline-secondary filter-button active" data-filter="all">Semua</button>
                            <button type="button" class="btn btn-outline-secondary filter-button" data-filter="unread">Belum Dibaca</button>
                            <button type="button" class="btn btn-outline-secondary filter-button" data-filter="read">Sudah Dibaca</button>
                        </div>

                        <!-- Notifications -->
                        @foreach($member->notifications as $notification)
                            <a href="{{ route('notification.read', $notification->id) }}" class="notification-item btn btn-light text-start mb-3 rounded-0" data-status="{{ $notification->status }}">
                                {{ $notification->content }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.filter-button').on('click', function() {
            // Remove the active class from all buttons
            $('.filter-button').removeClass('active');
            // Add the active class to the clicked button
            $(this).addClass('active');

            var status = $(this).data('filter');
            if (status === 'all') {
                $('.notification-item').show();
            } else {
                $('.notification-item').hide();
                $('.notification-item[data-status="' + status + '"]').show();
            }
        });
    });
</script>
