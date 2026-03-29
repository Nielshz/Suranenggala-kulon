@extends('layouts.app')
@section('title', 'Tambah User')
@section('content')
<div class="page-header-custom"><h1><i class="bi bi-person-plus-fill"></i> Tambah User</h1><a href="{{ route('user.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a></div>
<form action="{{ route('user.store') }}" method="POST">@csrf
<div class="section-card"><div class="section-card-header" style="border-left:4px solid #3b82f6;"><i class="bi bi-person-fill text-primary"></i><h5>Data User</h5></div>
<div class="section-card-body"><div class="row g-3">
    <div class="col-md-6"><label class="form-label fw-semibold">Nama *</label><input type="text" class="form-control" name="nama" required value="{{ old('nama') }}"></div>
    <div class="col-md-6"><label class="form-label fw-semibold">Username *</label><input type="text" class="form-control" name="username" required value="{{ old('username') }}"></div>
    <div class="col-md-6"><label class="form-label fw-semibold">Password *</label><input type="password" class="form-control" name="password" required><small class="text-muted"><i class="bi bi-shield-lock"></i> Dienkripsi dengan Argon2id</small></div>
    <div class="col-md-6"><label class="form-label fw-semibold">Status *</label><select class="form-select" name="status" required><option value="RT">RT</option><option value="RW">RW</option><option value="Admin">Admin</option></select></div>
    <div class="col-12"><label class="form-label fw-semibold">Keterangan</label><input type="text" class="form-control" name="keterangan" value="{{ old('keterangan') }}"></div>
    <div class="col-md-3"><label class="form-label fw-semibold">Desa/Kelurahan</label><input type="text" class="form-control" name="desa_kelurahan" value="{{ old('desa_kelurahan') }}"></div>
    <div class="col-md-3"><label class="form-label fw-semibold">Kecamatan</label><input type="text" class="form-control" name="kecamatan" value="{{ old('kecamatan') }}"></div>
    <div class="col-md-3"><label class="form-label fw-semibold">Kabupaten/Kota</label><input type="text" class="form-control" name="kabupaten_kota" value="{{ old('kabupaten_kota') }}"></div>
    <div class="col-md-3"><label class="form-label fw-semibold">Provinsi</label><input type="text" class="form-control" name="provinsi" value="{{ old('provinsi') }}"></div>
    <div class="col-md-2"><label class="form-label fw-semibold">RT</label><input type="text" class="form-control" name="rt" value="{{ old('rt') }}"></div>
    <div class="col-md-2"><label class="form-label fw-semibold">RW</label><input type="text" class="form-control" name="rw" value="{{ old('rw') }}"></div>
</div></div></div>
<button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-check-lg"></i> Simpan User</button>
</form>
@endsection
