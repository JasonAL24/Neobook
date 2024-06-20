@extends('layouts.admin')

@section('container')
    @php
        $admin = auth()->guard('admin')->user();
    @endphp
    @if ($admin->role != 'admin')
    <div class="main-bg">
        <div class="white-container p-3">
            <h2 class="fw-bold p-3 mb-4">Daftar Admin</h2>
            @if ($errors->any())
                <ul class="alert alert-danger ms-5">
                    <div class="fw-bold">Error! Mohon daftar ulang. Berikut error yang didapat:</div>
                    @foreach ($errors->all() as $error)
                        <li class="ms-3">{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            @if (session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif
            <form id="adminForm" method="POST" action="{{ route('admin.add') }}">
                @csrf
                <div class="ms-5" style="width: 90%">
                    <div class="input-group mb-3 align-items-center">
                        <span class="input-label">Nama Admin</span>
                        <input type="text" name="nama" class="form-control" placeholder="Tulis nama admin..." aria-label="Nama">
                    </div>
                    <div class="input-group mb-3 align-items-center">
                        <span class="input-label">Email Admin</span>
                        <input type="email" name="email" class="form-control" placeholder="Tulis email admin..." aria-label="Email">
                    </div>
                    <div class="input-group mb-3 align-items-center">
                        <span class="input-label">Tulis Kata Sandi</span>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Tulis kata sandi admin..." aria-label="Password">
                        <button id="togglePassword" class="toggle-password btn" aria-label="Toggle password visibility" type="button">
                            <img src="/img/svg/eye.svg" alt="eye" class="eye-icon">
                        </button>
                    </div>
                    <div class="input-group mb-3 align-items-center">
                        <span class="input-label">Konfirmasi Kata Sandi</span>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Tulis ulang kata sandi admin..." aria-label="Password">
                        <button id="toggleConfirmPassword" class="toggle-password btn" aria-label="Toggle password visibility" type="button">
                            <img src="/img/svg/eye.svg" alt="eye" class="eye-icon">
                        </button>
                    </div>
                    <div class="d-flex flex-row">
                        <div class="ms-auto mt-4">
                            <a href="/admin/adminlist" class="btn btn-secondary fw-bold fs-5 me-3" style="width: 6vw">Batal</a>
                            <button type="button" class="btn btn-primary fw-bold fs-5" style="width: 6vw" data-bs-toggle="modal" data-bs-target="#confirmModal">Simpan</button>
                        </div>
                    </div>
                    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header d-flex flex-row" style="border-bottom: 0;">
                                    <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Penambahan Admin</h5>
                                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah anda yakin untuk menambah Admin?</p>
                                    <span class="input-label fw-bold">Ketik kata sandi anda</span>
                                    <div class="input-group">
                                        <input type="password" id="confirmation_password" name="confirmation_password" class="form-control" placeholder="Tulis kata sandi Anda..." aria-label="Password" required>
                                        <button id="toggleConfirmationPassword" class="toggle-password btn" aria-label="Toggle password visibility" type="button">
                                            <img src="/img/svg/eye.svg" alt="eye" class="eye-icon">
                                        </button>
                                    </div>
                                </div>
                                <div class="modal-footer" style="border-top: 0;">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="button" class="btn btn-primary" id="confirmAddAdmin">Ya, Tambahkan Admin</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @else
        <div class="p-4 mt-4">
            <p>Maaf, role anda tidak bisa mengakses link ini</p>
        </div>
    @endif
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

        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            togglePassword('password_confirmation')
        });

        document.getElementById('toggleConfirmationPassword').addEventListener('click', function() {
            togglePassword('confirmation_password')
        });

        document.getElementById('confirmAddAdmin').addEventListener('click', function() {
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
