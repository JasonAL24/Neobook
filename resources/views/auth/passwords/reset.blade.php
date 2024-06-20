<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neobook | Reset Password</title>
    <link rel="icon" href="/img/Neobook.png" type="image/png">
    <link rel="stylesheet" href="{{ asset('/css/user.css') }}" type="text/css">

    {{--    BootStrap (5.3.3)  --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">

    <style>
        body{
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body>
@if (session('status'))
    <div>
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <div class="row position-relative" style="margin-right: 0;">
        <div class="col-auto d-none d-lg-block">
            <img src="/img/background/login_background.png" alt="login background" style="height: 100vh; width: 800px">
        </div>
        <div class="col-auto align-items-center justify-content-center" style="max-width: 32vw; margin-left: 6vw; margin-top: 21vh;">
            <h1><b>Reset Password Anda</b></h1>
            <div class="d-flex flex-column mt-4">
                <label for="email" class="form-label">Email Anda</label>
                <input class="form-control" type="email" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" placeholder="Masukan email Anda...">

                <label for="password" class="form-label mt-3">Masukan Password Baru Anda</label>
                <input class="form-control" type="password" name="password" required autocomplete="new-password" placeholder="Masukan password baru...">

                <label for="password" class="form-label mt-3">Konfirmasi Password Baru Anda</label>
                <input class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Konfirmasi password baru...">
            </div>
            <div>
                <button type="submit" class="submit-button mt-5">Reset Password</button>
            </div>
            @if ($errors->any())
                <div>
                    @foreach ($errors->all() as $error)
                        <div class="error-text">{{ $error }}</div>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="row position-absolute bottom-0 end-0 justify-content-end p-0 d-lg-flex d-none mb-2 me-2">
            <div class="col-auto d-flex flex-row align-items-center me-5 p-0">
                <img src="/img/OIG2_RemoveBG.png" alt="Logo Neobook" class="size-img">
                <h3 class="mt-2" style="margin-left: -.5em;"><b>Neobook</b></h3>
            </div>
        </div>
    </div>
</form>
</body>
</html>

