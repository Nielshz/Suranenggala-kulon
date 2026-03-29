@extends('layouts.app')
@section('title', 'Detail Mutasi')
@section('content')
<div class="page-header-custom"><h1><i class="bi bi-arrow-left-right"></i> Detail Mutasi</h1><a href="{{ route('mutasi.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a></div>
<div class="section-card"><div class="section-card-header" style="border-left:4px solid #f59e0b;"><i class="bi bi-arrow-left-right text-warning"></i><h5>Data Mutasi</h5></div>
<div class="section-card-body">
<table class="table table-borderless mb-0">
    <tr><th width="200">NIK</th><td><code>{{ $mutasi->nik }}</code> <span class="badge bg-light text-secondary" style="font-size:10px;"><i class="bi bi-lock-fill"></i> Encrypted</span></td></tr>
    <tr><th>Nama</th><td><strong>{{ $mutasi->nama }}</strong></td></tr>
    <tr><th>Tempat, Tanggal Lahir</th><td>{{ $mutasi->tempat_lahir }}, {{ $mutasi->tanggal_lahir ? \Carbon\Carbon::parse($mutasi->tanggal_lahir)->format('d-m-Y') : '-' }}</td></tr>
    <tr><th>Jenis Kelamin</th><td>@if($mutasi->jenis_kelamin=='L')<span class="stat-badge male"><i class="bi bi-gender-male"></i> Laki-laki</span>@else<span class="stat-badge female"><i class="bi bi-gender-female"></i> Perempuan</span>@endif</td></tr>
    <tr><th>Usia</th><td>{{ $mutasi->usia }} tahun</td></tr>
    <tr><th>Alamat</th><td>{{ $mutasi->alamat }}</td></tr>
    <tr><th>RT / RW</th><td>{{ $mutasi->rt }} / {{ $mutasi->rw }}</td></tr>
    <tr><th>Pendidikan</th><td>{{ $mutasi->pendidikan_terakhir }}</td></tr>
    <tr><th>Pekerjaan</th><td>{{ $mutasi->pekerjaan }}</td></tr>
    <tr><th>Status Perkawinan</th><td>{{ $mutasi->status_perkawinan }}</td></tr>
    <tr><th>Status</th><td>@if($mutasi->status=='Tetap')<span class="badge bg-success">Tetap</span>@else<span class="badge bg-warning text-dark">Kontrak</span>@endif</td></tr>
    <tr><th>Diinput oleh</th><td>{{ $mutasi->user->nama ?? '-' }}</td></tr>
    <tr><th>Tanggal</th><td>{{ $mutasi->created_at?->format('d-m-Y H:i') }}</td></tr>
</table>
</div></div>
@endsection
