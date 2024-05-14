<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neobook | {{$title}}</title>
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

<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="row align-items-center justify-content-center" style="margin-right: 0;">
        <div class="col-lg-6">
            <img src="/img/background/login_background.png" alt="login background" style="height: 100vh; width: 800px">
        </div>
        <div class="col align-items-center justify-content-center mb-5 me-5">
            <h1><b>Selamat Datang</b></h1>
            <div class="d-flex flex-column mt-4">
                <label for="email">Email</label>
                <div class="input-group">
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="input-box" placeholder="Tulis nama alamat email Anda...">
                </div>
            </div>
            <div class="password-container d-flex flex-column mt-4">
                <label for="password">Kata Sandi</label>
                <input type="password" id="password" name="password" class="input-box" placeholder="Tulis kata sandi Anda...">
                <button id="togglePassword" class="toggle-password" aria-label="Toggle password visibility" type="button">
                    <img src="/img/svg/eye.svg" alt="eye" class="eye-icon">
                </button>
            </div>
            <div>
                <button type="submit" class="submit-button mt-5">Masuk</button>
            </div>
            <div class="mb-5 mt-2">
                Belom punya akun? <a href="{{route('register')}}"> Daftar Sekarang </a>
            </div>
            @if ($errors->any())
                <div>
                    @foreach ($errors->all() as $error)
                        <div class="error-text">{{ $error }}</div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <div class="row fixed-bottom justify-content-end mr-3 mb-3">
        <div class="col-auto d-flex flex-row align-items-center me-5">
            <img src="/img/OIG2_RemoveBG.png" alt="Logo Neobook" class="size-img">
            <h3 class="mt-2" style="margin-left: -.5em;"><b>Neobook</b></h3>
        </div>
    </div>
</form>
</body>
<script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        var passwordField = document.getElementById('password');
        var fieldType = passwordField.getAttribute('type');

        // Toggle password visibility
        if (fieldType === 'password') {
            passwordField.setAttribute('type', 'text');
        } else {
            passwordField.setAttribute('type', 'password');
        }
    });
</script>
</html>
