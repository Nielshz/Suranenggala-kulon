@extends('layouts.app')
@section('title', 'Edit Pengumuman')
@section('content')
<div class="pg-header"><h1><i class="bi bi-pencil"></i> Edit Pengumuman</h1><a href="{{ route('pengumuman.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a></div>
<form action="{{ route('pengumuman.update', $pengumuman) }}" method="POST">
    @csrf @method('PUT')
    <div class="sec">
        <div class="sec-head" style="border-left:3px solid var(--primary)"><i class="bi bi-megaphone-fill" style="color:var(--primary)"></i><h5>Detail Pengumuman</h5></div>
        <div class="sec-body"><div class="row g-3">
            <div class="col-md-8"><label class="form-label">Judul *</label><input type="text" class="form-control" name="judul" required value="{{ old('judul', $pengumuman->judul) }}"></div>
            <div class="col-md-4"><label class="form-label">Kategori *</label><select class="form-select" name="kategori" required>@foreach(['Umum','Penting','Kegiatan','Layanan'] as $k)<option value="{{ $k }}" {{ old('kategori', $pengumuman->kategori)==$k?'selected':'' }}>{{ $k }}</option>@endforeach</select></div>
            <div class="col-12"><label class="form-label">Isi Pengumuman *</label><textarea class="form-control" name="isi" rows="6" required>{{ old('isi', $pengumuman->isi) }}</textarea></div>
            <div class="col-md-4"><label class="form-label">Tanggal Mulai</label><input type="date" class="form-control" name="tanggal_mulai" value="{{ old('tanggal_mulai', $pengumuman->tanggal_mulai?->format('Y-m-d')) }}"></div>
            <div class="col-md-4"><label class="form-label">Tanggal Selesai</label><input type="date" class="form-control" name="tanggal_selesai" value="{{ old('tanggal_selesai', $pengumuman->tanggal_selesai?->format('Y-m-d')) }}"></div>
            <div class="col-md-4"><label class="form-label">Status</label><div class="form-check mt-2"><input type="checkbox" class="form-check-input" name="is_active" value="1" {{ $pengumuman->is_active?'checked':'' }} id="isActive"><label class="form-check-label" for="isActive">Aktif</label></div></div>
        </div></div>
    </div>
    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Simpan</button>
</form>
@endsection
