<div class="d-flex flex-column position-absolute end-0" style="top: 20%">
    <button id="chatButton" type="button" class="btn" style="background-color: #252734;" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
        <img src="/img/svg/chat_message.svg" alt="Chat">
    </button>
    <div class="offcanvas offcanvas-end rounded" tabindex="-1" id="offcanvasRight"
         aria-labelledby="offcanvasRightLabel" style="top: 10%; width: 40vw">
        <div class="offcanvas-header">
            <h4 class="offcanvas-title fw-bold" id="offcanvasRightLabel">Pesan Masuk</h4>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body" id="chatContent" style="padding-bottom: 0">
            <div id="community-list">
                @foreach($communitiesWithLastMessage as $communityChat)
                    <a href="#" class="community-link text-decoration-none text-black" data-id="{{ $communityChat->id }}" id="community-link">
                        <div class="row align-items-center mb-4">
                            <div class="col-auto ms-5">
                                @if($communityChat->profile_picture)
                                    <img src="/img/communities/profile_picture/{{$communityChat->id}}/{{$communityChat->profile_picture}}"
                                         alt="{{$communityChat->name}}" class="pp-chat">
                                @else
                                    <img src="/img/communities/profile_picture/default_profile_picture.png"
                                         alt="Default Group Picture" class="pp-chat">
                                @endif
                            </div>
                            <div class="col">
                                <div class="fw-bold fs-5">{{ $communityChat->name }}</div>
                                <div>
                                    @if($communityChat->lastMessage)
                                        <small><strong>{{$communityChat->lastMessage->member->name}}
                                                :</strong> {{ $communityChat->lastMessage->content }}</small>
                                    @else
                                        <small>No messages yet.</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div id="chat-content" style="display: none;">
                <div class="d-flex flex-row">
                    <button id="back-button" class="btn">
                        <img src="/img/svg/arrow_blue.svg" alt="Back" style="transform: scaleX(-1);">
                    </button>
                </div>
                <div id="chat-area">

                </div>
            </div>
        </div>
    </div>
</div>
<script src="/js/chat.js"></script>

