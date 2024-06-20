@component('mail::message')
Berikut link untuk me-reset password Anda.

@component('mail::button', ['url' => $resetUrl])
Klik link ini untuk reset password Anda.
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
