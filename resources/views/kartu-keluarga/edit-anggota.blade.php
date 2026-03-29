@extends('layouts.app')
@section('title', 'Kelola Anggota KK')
@section('content')
<div class="page-header-custom"><h1><i class="bi bi-people-fill"></i> Kelola Anggota KK</h1><a href="{{ route('kartu-keluarga.show', $kartuKeluarga) }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a></div>

<div class="card mb-3"><div class="card-body"><strong>KK:</strong> {{ $kartuKeluarga->nomor_keluarga }} — Kepala: {{ $kartuKeluarga->kepalaKeluarga->nama ?? '-' }}</div></div>

<form action="{{ route('kartu-keluarga.update-anggota', $kartuKeluarga) }}" method="POST">@csrf @method('PUT')
<div class="section-card"><div class="section-card-header"><i class="bi bi-check2-square text-primary"></i><h5>Pilih Anggota Keluarga</h5></div>
<div class="section-card-body">
    <p class="text-muted small mb-3">Centang warga yang menjadi anggota keluarga ini:</p>
    <div class="row g-2">
        @foreach($warga as $w)
        <div class="col-md-6">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="anggota_ids[]" value="{{ $w->id }}" id="w{{ $w->id }}" {{ $kartuKeluarga->anggota->contains($w->id) ? 'checked' : '' }}>
                <label class="form-check-label" for="w{{ $w->id }}">{{ $w->nama }} <small class="text-muted">({{ $w->nik }})</small></label>
            </div>
        </div>
        @endforeach
    </div>
</div></div>
<button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-check-lg"></i> Simpan Anggota</button>
</form>
@endsection
