@extends('layouts.app')
@section('title', 'Detail KK')
@section('content')
<div class="page-header-custom"><h1><i class="bi bi-person-vcard-fill"></i> Detail Kartu Keluarga</h1><a href="{{ route('kartu-keluarga.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a></div>

<div class="section-card">
    <div class="section-card-header" style="border-left:4px solid #3b82f6;"><i class="bi bi-person-vcard-fill text-primary"></i><h5>Informasi KK</h5></div>
    <div class="section-card-body">
        <table class="table table-borderless mb-0">
            <tr><th width="200">Nomor KK</th><td><code>{{ $kartuKeluarga->nomor_keluarga }}</code></td></tr>
            <tr><th>Kepala Keluarga</th><td><strong>{{ $kartuKeluarga->kepalaKeluarga->nama ?? '-' }}</strong></td></tr>
            <tr><th>Alamat</th><td>{{ $kartuKeluarga->alamat }}</td></tr>
            <tr><th>RT / RW</th><td>{{ $kartuKeluarga->rt }} / {{ $kartuKeluarga->rw }}</td></tr>
            <tr><th>Diinput oleh</th><td>{{ $kartuKeluarga->user->nama ?? '-' }}</td></tr>
        </table>
    </div>
</div>

<div class="section-card">
    <div class="section-card-header" style="border-left:4px solid #10b981;"><i class="bi bi-people-fill text-success"></i><h5>Anggota Keluarga ({{ $kartuKeluarga->anggota->count() }})</h5></div>
    <div class="section-card-body p-0">
        <table class="table table-striped mb-0">
            <thead><tr><th>No</th><th>Nama</th><th>NIK</th><th>L/P</th><th>Usia</th></tr></thead>
            <tbody>
                @forelse($kartuKeluarga->anggota as $i => $a)
                <tr><td>{{ $i+1 }}</td><td>{{ $a->nama }}</td><td><code>{{ $a->nik }}</code></td><td>{{ $a->jenis_kelamin }}</td><td>{{ $a->usia }}</td></tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Belum ada anggota</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
