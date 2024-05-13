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

    {{--    BootStrap (5.3.3)  --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">

    <style>
        body{
            font-family: 'Inter', sans-serif;
            background-color: #272A37;
            color: white;
            background-image: url("/img/background/register_background.png");
            /*background-size: cover;*/
            /*background-repeat: no-repeat;*/
        }
    </style>
</head>
<body>

<form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="row mt-4" style="margin-right: 0; margin-left: 5vw">
        <div class="col-lg-4 ms-5 register-form">
            <div class="d-flex flex-row align-items-center register-neobook-logo">
                <img src="/img/OIG2_RemoveBG.png" alt="Logo Neobook" class="size-img-small">
                <h3 class="mt-2"><b>Neobook</b></h3>
            </div>
            <div class="d-flex flex-row mt-4">
                <p class="fs-1 fw-bold">Buat Akun Baru</p>
                <p class="text-primary fs-1">.</p>
            </div>
            <p>Sudah memiliki akun? <a href="{{route('login')}}">Log In</a></p>
            <div class="d-flex flex-column mt-5">
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}" class="input-box" placeholder="Tulis nama lengkap Anda...">
            </div>
            <div class="d-flex flex-column mt-4">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" class="input-box" placeholder="Tulis alamat email Anda...">
            </div>
            <div class="d-flex flex-column mt-4">
                <label for="phone">No Handphone</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="input-box" placeholder="Tulis nomor handphone Anda...">
            </div>
            <div class="password-container d-flex flex-column mt-4">
                <label for="password">Tulis Kata Sandi</label>
                <input type="password" id="password" name="password" class="input-box" placeholder="Tulis kata sandi Anda...">
                <button id="togglePassword" class="toggle-password" aria-label="Toggle password visibility" type="button">
                    <img src="/img/svg/eye.svg" alt="eye" class="eye-icon">
                </button>
            </div>
            @if ($errors->any())
                <div>
                    @foreach ($errors->all() as $error)
                        <div class="error-text">{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            <div class="text-end me-3">
                <button type="submit" class="register-button mt-5">Daftar</button>
            </div>
        </div>
    </div>
</form>
</body>
<script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        var passwordInput = document.getElementById('password');
        var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
    });
</script>
</html>
