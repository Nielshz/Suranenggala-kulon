@extends('layouts.app')
@section('title', 'Edit KK')
@section('content')
<div class="page-header-custom"><h1><i class="bi bi-pencil"></i> Edit KK</h1><a href="{{ route('kartu-keluarga.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a></div>
<form action="{{ route('kartu-keluarga.update', $kartuKeluarga) }}" method="POST">@csrf @method('PUT')
<div class="section-card"><div class="section-card-body"><div class="row g-3">
    <div class="col-md-6"><label class="form-label fw-semibold">Nomor KK *</label><input type="text" class="form-control" name="nomor_keluarga" required value="{{ old('nomor_keluarga', $kartuKeluarga->nomor_keluarga) }}"></div>
    <div class="col-md-6"><label class="form-label fw-semibold">Kepala Keluarga *</label><select class="form-select" name="kepala_keluarga_id" required>@foreach($warga as $w)<option value="{{ $w->id }}" {{ old('kepala_keluarga_id', $kartuKeluarga->kepala_keluarga_id)==$w->id?'selected':'' }}>{{ $w->nama }}</option>@endforeach</select></div>
    <div class="col-12"><label class="form-label fw-semibold">Alamat</label><textarea class="form-control" name="alamat" rows="2">{{ old('alamat', $kartuKeluarga->alamat) }}</textarea></div>
    <div class="col-md-3"><label class="form-label fw-semibold">Desa/Kelurahan</label><input type="text" class="form-control" name="desa_kelurahan" value="{{ old('desa_kelurahan', $kartuKeluarga->desa_kelurahan) }}"></div>
    <div class="col-md-3"><label class="form-label fw-semibold">Kecamatan</label><input type="text" class="form-control" name="kecamatan" value="{{ old('kecamatan', $kartuKeluarga->kecamatan) }}"></div>
    <div class="col-md-3"><label class="form-label fw-semibold">Kabupaten/Kota</label><input type="text" class="form-control" name="kabupaten_kota" value="{{ old('kabupaten_kota', $kartuKeluarga->kabupaten_kota) }}"></div>
    <div class="col-md-3"><label class="form-label fw-semibold">Provinsi</label><input type="text" class="form-control" name="provinsi" value="{{ old('provinsi', $kartuKeluarga->provinsi) }}"></div>
    <div class="col-md-2"><label class="form-label fw-semibold">RT</label><input type="text" class="form-control" name="rt" value="{{ old('rt', $kartuKeluarga->rt) }}"></div>
    <div class="col-md-2"><label class="form-label fw-semibold">RW</label><input type="text" class="form-control" name="rw" value="{{ old('rw', $kartuKeluarga->rw) }}"></div>
    <div class="col-md-2"><label class="form-label fw-semibold">Kode Pos</label><input type="text" class="form-control" name="kode_pos" value="{{ old('kode_pos', $kartuKeluarga->kode_pos) }}"></div>
</div></div></div>
<button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-check-lg"></i> Simpan</button>
</form>
@endsection
