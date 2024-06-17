@extends('layouts.admin')

@section('container')
    <div class="p-4 mt-4">
        <div class="row">
            <div class="col">
                <h1>Selamat Datang, {{$admin->name}}</h1>
                <h4>Role: {{$admin->role}}</h4>
            </div>
            {{--            <div class="w-100"></div>--}}
            {{--            <div class="col">--}}
            {{--                <div class="card">--}}
            {{--                    <div class="card-header">--}}
            {{--                        <h2>{{ $admin->name }}</h2>--}}
            {{--                    </div>--}}
            {{--                    <div class="card-body">--}}
            {{--                        <p>Email: {{ $admin->email }}</p>--}}
            {{--                        <p>Role: {{ $admin->role }}</p>--}}
            {{--                        <p>Status: {{ $admin->status ? 'Active' : 'Inactive' }}</p>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
        </div>
        <div class="row mt-3">
            <div class="col-auto me-auto">
                <a href="/admin/uploadedbooks" class="card p-3 text-decoration-none" style="width: 15em; height: 17em;">
                    <div class="card-body text-center d-flex flex-column">
                        <div>
                            <h5>Buku yang diunggah</h5>
                        </div>
                        <div class="mt-auto">
                            <h4>{{count($records)}}</h4>
                        </div>
                        <div class="mt-auto">
                            <img src="/img/svg/book_uploaded.svg" alt="buku yang diunggah" style="width: 48px">
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-auto me-auto">
                <a href="/admin/userlist" class="card p-3 text-decoration-none" style="width: 15em; height: 17em;">
                    <div class="card-body text-center d-flex flex-column">
                        <div>
                            <h5>Daftar Pengguna</h5>
                        </div>
                        <div class="mt-auto">
                            <h4>{{count($members)}}</h4>
                        </div>
                        <div class="mt-auto">
                            <img src="/img/svg/user_lists.svg" alt="daftar pengguna" style="width: 48px">
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-auto me-auto">
                <a href="/admin/communitylist" class="card p-3 text-decoration-none" style="width: 15em; height: 17em;">
                    <div class="card-body text-center d-flex flex-column">
                        <div>
                            <h5>Daftar Komunitas</h5>
                        </div>
                        <div class="mt-auto">
                            <h4>{{count($communities)}}</h4>
                        </div>
                        <div class="mt-auto">
                            <img src="/img/svg/community_lists.svg" alt="daftar komunitas" style="width: 48px">
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-auto me-auto">
                <a href="/admin/booklist" class="card p-3 text-decoration-none" style="width: 15em; height: 17em;">
                    <div class="card-body text-center d-flex flex-column">
                        <div>
                            <h5>Daftar Buku</h5>
                        </div>
                        <div class="mt-auto">
                            <h4>{{count($books)}}</h4>
                        </div>
                        <div class="mt-auto">
                            <img src="/img/svg/book_lists.svg" alt="daftar buku" style="width: 48px">
                        </div>
                    </div>
                </a>
            </div>
            @if($admin->role === 'superadmin')
                <div class="col-auto me-auto">
                    <a href="/admin/adminlist" class="card p-3 text-decoration-none" style="width: 15em; height: 17em;">
                        <div class="card-body text-center d-flex flex-column">
                            <div>
                                <h5>Daftar Admin</h5>
                            </div>
                            <div class="mt-auto">
                                <h4>{{count($admins)}}</h4>
                            </div>
                            <div class="mt-auto">
                                <img src="/img/svg/admin_lists.svg" alt="daftar admin" style="width: 48px">
                            </div>
                        </div>
                    </a>
                </div>
            @endif
        </div>

        <h3 class="mt-4">Audit Logs</h3>
        @if($audits->isEmpty())
            <p>Tidak ada audit logs.</p>
        @else
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col" class="fs-5">Waktu</th>
                    <th scope="col" class="fs-5">Nama Admin</th>
                    <th scope="col" class="fs-5">Aksi</th>
                    <th scope="col" class="fs-5">Perubahan</th>
                </tr>
                </thead>
                <tbody>
                @php $count = 0 @endphp
{{--                {{dd($audits)}}--}}
                @foreach($audits as $audit)
                    @if ($count < 3)
                        @php
                                $oldValues = $audit->old_values;
                                $newValues = $audit->new_values;
                                $oldStatus = isset($oldValues['old_status']) ? $oldValues['old_status'] : 'N/A';
                                $newStatus = isset($newValues['new_status']) ? $newValues['new_status'] : 'N/A';
                        @endphp


                        @if (!isset($oldValues['remember_token']))
                            <tr>
                                <td>{{ $audit->created_at }}</td>
                                <td>{{ $audit->auditable ? $audit->auditable->name : 'N/A' }}</td>
                                <td>{{ $audit->event }}</td>
                                <td>

                                    <div class="d-flex flex-column">
                                        <span>Status Lama: {{ $oldStatus }}</span>
                                        <span>Status Baru: {{ $newStatus }}</span>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endif
                    @php $count++ @endphp
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
