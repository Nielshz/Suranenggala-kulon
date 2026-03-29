@extends('layouts.app')
@section('title', 'Edit User')
@section('content')
<div class="page-header-custom"><h1><i class="bi bi-pencil"></i> Edit User</h1><a href="{{ route('user.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a></div>
<form action="{{ route('user.update', $user) }}" method="POST">@csrf @method('PUT')
<div class="section-card"><div class="section-card-body"><div class="row g-3">
    <div class="col-md-6"><label class="form-label fw-semibold">Nama *</label><input type="text" class="form-control" name="nama" required value="{{ old('nama', $user->nama) }}"></div>
    <div class="col-md-6"><label class="form-label fw-semibold">Username *</label><input type="text" class="form-control" name="username" required value="{{ old('username', $user->username) }}"></div>
    <div class="col-md-6"><label class="form-label fw-semibold">Password <small>(kosongkan jika tidak diubah)</small></label><input type="password" class="form-control" name="password"></div>
    <div class="col-md-6"><label class="form-label fw-semibold">Status *</label><select class="form-select" name="status" required><option value="RT" {{ $user->status=='RT'?'selected':'' }}>RT</option><option value="RW" {{ $user->status=='RW'?'selected':'' }}>RW</option><option value="Admin" {{ $user->status=='Admin'?'selected':'' }}>Admin</option></select></div>
    <div class="col-12"><label class="form-label fw-semibold">Keterangan</label><input type="text" class="form-control" name="keterangan" value="{{ old('keterangan', $user->keterangan) }}"></div>
    <div class="col-md-3"><label class="form-label fw-semibold">Desa/Kelurahan</label><input type="text" class="form-control" name="desa_kelurahan" value="{{ old('desa_kelurahan', $user->desa_kelurahan) }}"></div>
    <div class="col-md-3"><label class="form-label fw-semibold">Kecamatan</label><input type="text" class="form-control" name="kecamatan" value="{{ old('kecamatan', $user->kecamatan) }}"></div>
    <div class="col-md-3"><label class="form-label fw-semibold">Kabupaten/Kota</label><input type="text" class="form-control" name="kabupaten_kota" value="{{ old('kabupaten_kota', $user->kabupaten_kota) }}"></div>
    <div class="col-md-3"><label class="form-label fw-semibold">Provinsi</label><input type="text" class="form-control" name="provinsi" value="{{ old('provinsi', $user->provinsi) }}"></div>
    <div class="col-md-2"><label class="form-label fw-semibold">RT</label><input type="text" class="form-control" name="rt" value="{{ old('rt', $user->rt) }}"></div>
    <div class="col-md-2"><label class="form-label fw-semibold">RW</label><input type="text" class="form-control" name="rw" value="{{ old('rw', $user->rw) }}"></div>
</div></div></div>
<button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-check-lg"></i> Simpan Perubahan</button>
</form>
@endsection
