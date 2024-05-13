<div class="container">
    <div class="row justify-content-end">
        <div class="col-auto user-notification p-3 me-5">
            <div class="d-flex flex-row">
                <a href="{{route('profile')}}" class="no-blue mt-1">
                    <div class="d-flex flex-row align-items-center">
                        @if ($member->profile_picture)
                            <img src="/img/{{ $member->profile_picture }}" alt="profile picture" class="profile-picture rounded-circle">
                        @else
                            <img src="/img/default_pp.png" alt="default profile picture" class="profile-picture rounded-circle">
                        @endif
                        <p class="mb-0 ms-2">{{ explode(' ', $member->name)[0] }}</p>
                        <img src="/img/svg/checkmark.svg" alt="checkmark">
                    </div>
                </a>

                <a href="#" class="notification ms-4">
                    <img src="/img/svg/Bell_light.svg" alt="Notification">
                    <span class="badge">3</span>
                </a>
            </div>
        </div>
    </div>
</div>
