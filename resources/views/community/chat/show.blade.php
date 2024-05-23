<div class="ms-5 d-flex flex-row" style="margin-top:-2.5em">
    @if($community->profile_picture)
        <img src="/img/communities/profile_picture/{{$community->id}}/{{$community->profile_picture}}"
             alt="{{$community->name}}" class="rounded-circle" style="width: 42px; height: 42px">
    @else
        <img src="/img/communities/profile_picture/default_profile_picture.png"
             alt="Default Group Picture" class="rounded-circle" style="width: 42px; height: 42px">
    @endif
    <div class="ms-3">
        <div class="fw-bold">{{ $community->name }}</div>
        <div class="opacity-50">{{count($community->members)}} Anggota</div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="card" style="border:0">
            <div class="card-body" id="chat-messages" style="height: 34vw; overflow-y: auto;">
                @foreach($messages->sortBy('created_at') as $key => $message)
                    @php
                        $isMember = $message->member->id === auth()->user()->member->id;
                        $showProfilePicture = true;

                        if ($key > 0 && $message->member->id === $messages[$key - 1]->member->id) {
                            $showProfilePicture = false;
                        }
                    @endphp

                    <div class="d-flex {{ $isMember ? 'justify-content-end' : 'justify-content-start' }} mb-2">
                        <div class="p-2 rounded {{ $isMember ? 'bg-light' : 'bg-body-secondary' }}" style="max-width: 75%;">
                            {{ $message->content }}
                            <br>
                            <small class="text-muted">{{ $message->created_at->format('h:i A') }}</small>
                        </div>
                    </div>
                    @if ($showProfilePicture)
                        <div class="d-flex {{ $isMember ? 'justify-content-end' : 'justify-content-start' }} mb-2">
                            @if (!$isMember)
                                @php
                                    $profile_picture = $message->member->profile_picture;
                                @endphp
                                @if ($profile_picture)
                                    <img src="/img/profile/{{$message->member->id}}/{{$profile_picture}}" alt="profile picture" style="width: 20px; height: 20px" class="rounded-circle">
                                @else
                                    <img src="/img/profile/default_pp.png" alt="profile picture" style="width: 20px; height: 20px" class="rounded-circle">
                                @endif
                                <div class="ms-2">{{$message->member->name}}</div>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="card-footer" style="border: 0; background-color: white">
                <form id="messageForm" action="{{ route('community.chat.store', $community) }}" method="POST" class="d-flex">
                    @csrf
                    <input name="content" id="content" class="form-control me-2" placeholder="Ketik pesanmu..." required>
                    <button type="submit" class="btn">
                        <img src="/img/svg/send.svg" alt="Kirim">
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
