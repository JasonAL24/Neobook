@extends('layouts.admin')

@section('container')
    <div class="p-4 mt-4">
        <h1>Daftar Permohonan</h1>
        <div class="mt-4">
            <form method="GET" action="{{ route('admin.requestlist') }}" class="mb-3">
                <div class="row">
                    <div class="col-md-3">
                        <label for="tipePermohonan" class="form-label mt-3 fw-bold">Pilih tipe permohonan</label>
                        <div class="input-group mb-3 align-items-center" style="width: 40vw">
                            <select name="tipePermohonan" class="form-select" aria-label="Type" onchange="this.form.submit()">
                                <option value="" {{ request('tipePermohonan') == '' ? 'selected' : '' }}>Semua</option>
                                <option value="Melaporkan Bug" {{ request('tipePermohonan') == 'Melaporkan Bug' ? 'selected' : '' }}>Melaporkan Bug</option>
                                <option value="Saran" {{ request('tipePermohonan') == 'Saran' ? 'selected' : '' }}>Saran</option>
                                <option value="Mengajukan Buku Baru" {{ request('tipePermohonan') == 'Mengajukan Buku Baru' ? 'selected' : '' }}>Mengajukan Buku Baru</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="mt-4">
            @if($requests->isEmpty())
                <p>Tidak ada permohonan yang telah dibuat.</p>
            @else
                @include('admin.tables.requestlist-table')
            @endif
        </div>
    </div>
@endsection
