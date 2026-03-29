@extends('layouts.app')
@section('title', 'Detail User')
@section('content')
<div class="page-header-custom"><h1><i class="bi bi-person-gear"></i> Detail User</h1><a href="{{ route('user.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a></div>
<div class="section-card"><div class="section-card-body">
<table class="table table-borderless mb-0">
    <tr><th width="200">Nama</th><td><strong>{{ $user->nama }}</strong></td></tr>
    <tr><th>Username</th><td><code>{{ $user->username }}</code></td></tr>
    <tr><th>Status</th><td>@if($user->status=='Admin')<span class="badge bg-danger">Admin</span>@elseif($user->status=='RT')<span class="badge bg-primary">RT</span>@else<span class="badge bg-success">RW</span>@endif</td></tr>
    <tr><th>Keterangan</th><td>{{ $user->keterangan }}</td></tr>
    <tr><th>Desa/Kelurahan</th><td>{{ $user->desa_kelurahan }}</td></tr>
    <tr><th>Kecamatan</th><td>{{ $user->kecamatan }}</td></tr>
    <tr><th>Kabupaten/Kota</th><td>{{ $user->kabupaten_kota }}</td></tr>
    <tr><th>Provinsi</th><td>{{ $user->provinsi }}</td></tr>
    <tr><th>RT / RW</th><td>{{ $user->rt }} / {{ $user->rw }}</td></tr>
    <tr><th>Dibuat</th><td>{{ $user->created_at?->format('d-m-Y H:i') }}</td></tr>
</table>
</div></div>
@endsection
