@extends('layouts.admin')

@section('container')
    <div class="p-4 mt-4">
        <h1>Pengaturan</h1>
        <div>
            <div class="align-items-center">
                <form id="adminForm" method="POST" action="{{ route('admin.update', $admin->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="input-group mb-3 align-items-center">
                        <span class="input-label">Nama Admin</span>
                        <input type="text" name="nama" class="form-control" placeholder="Tulis nama..." aria-label="Nama" value="{{$admin->name}}" required>
                    </div>
                    <div class="input-group mb-3 align-items-center">
                        <span class="input-label">Email Admin</span>
                        <input type="email" name="email" class="form-control" placeholder="Tulis email..." aria-label="Email" value="{{$admin->email}}" required>
                    </div>
                    <div class="input-group mb-3 align-items-center">
                        <span class="input-label">Kata Sandi Baru</span>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Tulis kata sandi baru..." aria-label="Password">
                        <button id="togglePassword" class="toggle-password btn" aria-label="Toggle password visibility" type="button">
                            <img src="/img/svg/eye.svg" alt="eye" class="eye-icon">
                        </button>
                    </div>
                    <div class="input-group mb-3 align-items-center">
                        <span class="input-label">Konfirmasi Kata Sandi Baru</span>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Konfirmasi kata sandi baru..." aria-label="Password">
                        <button id="toggleConfirmPassword" class="toggle-password btn" aria-label="Toggle password visibility" type="button">
                            <img src="/img/svg/eye.svg" alt="eye" class="eye-icon">
                        </button>
                    </div>
                    <div class="d-flex flex-row">
                        <div class="ms-auto mt-4">
                            <button type="button" class="btn btn-secondary" style="width: 6vw" data-bs-toggle="modal" data-bs-target="#confirmModal">Simpan</button>
                        </div>
                    </div>
                    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header d-flex flex-row" style="border-bottom: 0;">
                                    <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Update Admin</h5>
                                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah anda yakin untuk update Admin?</p>
                                    <span class="input-label fw-bold">Ketik kata sandi Anda</span>
                                    <div class="input-group">
                                        <input type="password" id="confirmation_password" name="confirmation_password" class="form-control" placeholder="Tulis kata sandi Anda..." aria-label="Password" required>
                                        <button id="toggleConfirmationPassword" class="toggle-password btn" aria-label="Toggle password visibility" type="button">
                                            <img src="/img/svg/eye.svg" alt="eye" class="eye-icon">
                                        </button>
                                    </div>
                                </div>
                                <div class="modal-footer" style="border-top: 0;">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="button" class="btn btn-primary" id="confirmUpdateAdmin">Ya, Update Admin</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                @if (session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <ul class="alert alert-danger">
                        <div class="fw-bold">Error! Mohon update pengaturan ulang. Berikut error yang didapat:</div>
                        @foreach ($errors->all() as $error)
                            <li class="ms-3">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
    <script>
        function togglePassword(elementPassword)
        {
            var passwordInput = document.getElementById(elementPassword);
            var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        }

        document.getElementById('togglePassword').addEventListener('click', function() {
            togglePassword('password')
        });

        document.getElementById('toggleConfirmationPassword').addEventListener('click', function() {
            togglePassword('confirmation_password')
        });

        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            togglePassword('password_confirmation')
        });

        document.getElementById('confirmUpdateAdmin').addEventListener('click', function() {
            var confirmationPassword = document.getElementById('confirmation_password').value;
            if (confirmationPassword) {
                // Append confirmation password to the main form and submit
                var form = document.getElementById('adminForm');
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'confirmation_password';
                input.value = confirmationPassword;
                form.appendChild(input);
                form.submit();
            } else {
                alert('Kata sandi konfirmasi diperlukan.');
            }
        });
    </script>
@endsection
