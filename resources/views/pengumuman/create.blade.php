@extends('layouts.app')
@section('title', 'Tambah Pengumuman')
@section('content')
<div class="pg-header"><h1><i class="bi bi-megaphone"></i> Tambah Pengumuman</h1><a href="{{ route('pengumuman.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a></div>
<form action="{{ route('pengumuman.store') }}" method="POST">
    @csrf
    <div class="sec">
        <div class="sec-head" style="border-left:3px solid var(--primary)"><i class="bi bi-megaphone-fill" style="color:var(--primary)"></i><h5>Detail Pengumuman</h5></div>
        <div class="sec-body"><div class="row g-3">
            <div class="col-md-8"><label class="form-label">Judul *</label><input type="text" class="form-control" name="judul" required value="{{ old('judul') }}"></div>
            <div class="col-md-4"><label class="form-label">Kategori *</label><select class="form-select" name="kategori" required><option value="Umum">Umum</option><option value="Penting">Penting</option><option value="Kegiatan">Kegiatan</option><option value="Layanan">Layanan</option></select></div>
            <div class="col-12"><label class="form-label">Isi Pengumuman *</label><textarea class="form-control" name="isi" rows="6" required>{{ old('isi') }}</textarea></div>
            <div class="col-md-4"><label class="form-label">Tanggal Mulai</label><input type="date" class="form-control" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}"></div>
            <div class="col-md-4"><label class="form-label">Tanggal Selesai</label><input type="date" class="form-control" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}"></div>
            <div class="col-md-4"><label class="form-label">Status</label><div class="form-check mt-2"><input type="checkbox" class="form-check-input" name="is_active" value="1" checked id="isActive"><label class="form-check-label" for="isActive">Aktif</label></div></div>
        </div></div>
    </div>
    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Simpan</button>
</form>
@endsection
