@php
    $isMember = $message->member->id === auth()->user()->member->id;
@endphp
<div class="d-flex {{ $isMember ? 'justify-content-end' : 'justify-content-start' }} mb-2">
    <div class="p-2 rounded {{ $isMember ? 'bg-light' : 'bg-secondary' }}" style="max-width: 75%;">
        {{ $message->content }}
        <br>
        <small class="text-muted">{{ $message->created_at->format('h:i A') }}</small>
    </div>
</div>
