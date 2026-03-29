@extends('layouts.app')
@section('title', 'Tambah Mutasi')
@section('content')
<div class="page-header-custom"><h1><i class="bi bi-arrow-left-right"></i> Tambah Mutasi</h1><a href="{{ route('mutasi.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a></div>
<form action="{{ route('mutasi.store') }}" method="POST">@csrf
@if($warga)<input type="hidden" name="from_warga_id" value="{{ $warga->id }}">@endif
<div class="section-card"><div class="section-card-header" style="border-left:4px solid #f59e0b;"><i class="bi bi-arrow-left-right text-warning"></i><h5>Data Mutasi</h5></div>
<div class="section-card-body"><div class="row g-3">
    <div class="col-md-6"><label class="form-label fw-semibold">NIK *</label><input type="text" class="form-control" name="nik" maxlength="16" required value="{{ old('nik', $warga->nik ?? '') }}"></div>
    <div class="col-md-6"><label class="form-label fw-semibold">Nama *</label><input type="text" class="form-control" name="nama" required value="{{ old('nama', $warga->nama ?? '') }}"></div>
    <div class="col-md-4"><label class="form-label fw-semibold">Tempat Lahir</label><input type="text" class="form-control" name="tempat_lahir" value="{{ old('tempat_lahir', $warga->tempat_lahir ?? '') }}"></div>
    <div class="col-md-4"><label class="form-label fw-semibold">Tanggal Lahir</label><input type="date" class="form-control" name="tanggal_lahir" value="{{ old('tanggal_lahir', $warga->tanggal_lahir ?? '') }}"></div>
    <div class="col-md-4"><label class="form-label fw-semibold">Jenis Kelamin *</label><select class="form-select" name="jenis_kelamin" required><option value="L" {{ old('jenis_kelamin', $warga->jenis_kelamin ?? '')=='L'?'selected':'' }}>Laki-laki</option><option value="P" {{ old('jenis_kelamin', $warga->jenis_kelamin ?? '')=='P'?'selected':'' }}>Perempuan</option></select></div>
    <div class="col-12"><label class="form-label fw-semibold">Alamat</label><textarea class="form-control" name="alamat" rows="2">{{ old('alamat', $warga->alamat ?? '') }}</textarea></div>
    <div class="col-md-3"><label class="form-label fw-semibold">RT</label><input type="text" class="form-control" name="rt" value="{{ old('rt', $warga->rt ?? '') }}"></div>
    <div class="col-md-3"><label class="form-label fw-semibold">RW</label><input type="text" class="form-control" name="rw" value="{{ old('rw', $warga->rw ?? '') }}"></div>
    <div class="col-md-3"><label class="form-label fw-semibold">Pendidikan</label><input type="text" class="form-control" name="pendidikan_terakhir" value="{{ old('pendidikan_terakhir', $warga->pendidikan_terakhir ?? '') }}"></div>
    <div class="col-md-3"><label class="form-label fw-semibold">Pekerjaan</label><input type="text" class="form-control" name="pekerjaan" value="{{ old('pekerjaan', $warga->pekerjaan ?? '') }}"></div>
    <div class="col-md-4"><label class="form-label fw-semibold">Status Perkawinan</label><select class="form-select" name="status_perkawinan"><option value="">— Pilih —</option><option value="Kawin" {{ old('status_perkawinan', $warga->status_perkawinan ?? '')=='Kawin'?'selected':'' }}>Kawin</option><option value="Tidak Kawin" {{ old('status_perkawinan', $warga->status_perkawinan ?? '')=='Tidak Kawin'?'selected':'' }}>Tidak Kawin</option></select></div>
    <div class="col-md-4"><label class="form-label fw-semibold">Status</label><select class="form-select" name="status"><option value="Tetap">Tetap</option><option value="Kontrak">Kontrak</option></select></div>
</div></div></div>
<button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-check-lg"></i> Simpan Mutasi</button>
</form>
@endsection
