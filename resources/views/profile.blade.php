@extends('layouts.main')

@section('container')
    <div class="main-bg">
        <div>
            <h1>Halaman Profile</h1>
            <form method="POST" action="{{ route('members.update', $member->id) }}">
                @csrf
                @method('PUT')
                <!-- Input fields for updating member details -->
                <label for="name">Nama</label>
                <input type="text" name="name" value="{{ $member->name }}">
                <label for="phone">Email</label>
                <input type="text" name="email" value="{{ $member->user->email }}">
                <label for="phone">Nomor Handphone</label>
                <input type="text" name="phone" value="{{ $member->phone }}">
                <label for="address">Address</label>
                <input type="text" name="address" value="{{ $member->address }}">
                <button type="submit">Simpan</button>
            </form>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <div>
                    <button type="submit">Logout</button>
                </div>
            </form>
        </div>
    </div>
@endsection
