@extends('layouts.app')
@section('title', 'Detail Warga')

@section('content')
<div class="pg-header">
    <h1><i class="bi bi-person-fill"></i> Detail Warga</h1>
    <div class="d-flex gap-2">
        @if(auth()->user()->status !== 'RW')
        <a href="{{ route('warga.edit', $warga) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil"></i> Edit</a>
        @endif
        <a href="{{ route('warga.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>
</div>

<div class="mb-3">
    @if($isVerified)
        <span class="badge badge-verified"><i class="bi bi-patch-check-fill"></i> Dokumen Terverifikasi SHA-256</span>
    @else
        <span class="badge badge-unverified"><i class="bi bi-exclamation-triangle-fill"></i> Tidak Terverifikasi</span>
    @endif
</div>

<div class="sec">
    <div class="sec-head" style="border-left:3px solid var(--primary);"><i class="bi bi-person-fill" style="color:var(--primary)"></i><h5>Data Pribadi</h5></div>
    <div class="sec-body">
        <div class="row g-2">
            <div class="col-sm-4"><small class="text-muted d-block">NIK</small><span class="nik-code">{{ $w->nik ?? $warga->nik }}</span> <span class="badge bg-light text-secondary border" style="font-size:9px"><i class="bi bi-lock-fill"></i> Encrypted</span></div>
            <div class="col-sm-4"><small class="text-muted d-block">Nama</small><strong>{{ $warga->nama }}</strong></div>
            <div class="col-sm-4"><small class="text-muted d-block">Jenis Kelamin</small>@if($warga->jenis_kelamin=='L')<span class="pill pill-m"><i class="bi bi-gender-male"></i> Laki-laki</span>@else<span class="pill pill-f"><i class="bi bi-gender-female"></i> Perempuan</span>@endif</div>
            <div class="col-sm-4"><small class="text-muted d-block">Tempat Lahir</small>{{ $warga->tempat_lahir }}</div>
            <div class="col-sm-4"><small class="text-muted d-block">Tanggal Lahir</small>{{ $warga->tanggal_lahir ? \Carbon\Carbon::parse($warga->tanggal_lahir)->format('d M Y') : '—' }}</div>
            <div class="col-sm-4"><small class="text-muted d-block">Usia</small>{{ $warga->usia }} tahun</div>
        </div>
    </div>
</div>

<div class="sec">
    <div class="sec-head" style="border-left:3px solid var(--success);"><i class="bi bi-geo-alt-fill" style="color:var(--success)"></i><h5>Data Alamat</h5></div>
    <div class="sec-body">
        <div class="row g-2">
            <div class="col-sm-6"><small class="text-muted d-block">Alamat KTP</small>{{ $warga->alamat_ktp ?? '—' }}</div>
            <div class="col-sm-6"><small class="text-muted d-block">Alamat Domisili</small>{{ $warga->alamat ?? '—' }}</div>
            <div class="col-sm-3"><small class="text-muted d-block">Desa/Kelurahan</small>{{ $warga->desa_kelurahan }}</div>
            <div class="col-sm-3"><small class="text-muted d-block">Kecamatan</small>{{ $warga->kecamatan }}</div>
            <div class="col-sm-3"><small class="text-muted d-block">Kabupaten/Kota</small>{{ $warga->kabupaten_kota }}</div>
            <div class="col-sm-3"><small class="text-muted d-block">Provinsi</small>{{ $warga->provinsi }}</div>
            <div class="col-sm-2"><small class="text-muted d-block">RT/RW</small>{{ $warga->rt }}/{{ $warga->rw }}</div>
            <div class="col-sm-2"><small class="text-muted d-block">Negara</small>{{ $warga->negara }}</div>
        </div>
    </div>
</div>

<div class="sec">
    <div class="sec-head" style="border-left:3px solid var(--warning);"><i class="bi bi-info-circle-fill" style="color:var(--warning)"></i><h5>Data Lainnya</h5></div>
    <div class="sec-body">
        <div class="row g-2">
            <div class="col-sm-3"><small class="text-muted d-block">Agama</small>{{ $warga->agama ?? '—' }}</div>
            <div class="col-sm-3"><small class="text-muted d-block">Pendidikan</small>{{ $warga->pendidikan_terakhir ?? '—' }}</div>
            <div class="col-sm-3"><small class="text-muted d-block">Pekerjaan</small>{{ $warga->pekerjaan ?? '—' }}</div>
            <div class="col-sm-3"><small class="text-muted d-block">Status Perkawinan</small>{{ $warga->status_perkawinan ?? '—' }}</div>
            <div class="col-sm-3"><small class="text-muted d-block">Status Tinggal</small>@if($warga->status=='Tetap')<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">Tetap</span>@else<span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25">Kontrak</span>@endif</div>
        </div>
    </div>
</div>

<div class="sec">
    <div class="sec-head" style="border-left:3px solid var(--text-3);"><i class="bi bi-database-fill" style="color:var(--text-3)"></i><h5>Sistem & Audit Trail</h5></div>
    <div class="sec-body">
        <div class="row g-2">
            <div class="col-sm-4"><small class="text-muted d-block">Diinput oleh</small><strong>{{ $warga->user->nama ?? '—' }}</strong> <span class="badge bg-light text-secondary border" style="font-size:9px">{{ $warga->user->status ?? '' }}</span></div>
            <div class="col-sm-4"><small class="text-muted d-block">Dibuat</small>{{ $warga->created_at?->format('d M Y, H:i') }}</div>
            <div class="col-sm-4"><small class="text-muted d-block">Terakhir diubah</small>{{ $warga->updated_at?->format('d M Y, H:i') }}</div>
            @if($warga->updater)
            <div class="col-12" style="margin-top:8px; padding-top:10px; border-top:1px solid var(--border-light)">
                <small class="text-muted d-block mb-1">Terakhir diubah oleh</small>
                <div class="d-flex align-items-center gap-2">
                    <div class="avatar" style="width:28px;height:28px;font-size:10px">{{ strtoupper(substr($warga->updater->nama, 0, 1)) }}</div>
                    <div>
                        <strong style="font-size:13px">{{ $warga->updater->nama }}</strong>
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25" style="font-size:9px;margin-left:4px">{{ $warga->updater->status }}</span>
                    </div>
                </div>
            </div>
            @endif
            @if($warga->keterangan_perubahan)
            <div class="col-12" style="margin-top:6px">
                <small class="text-muted d-block">Keterangan</small>
                <span style="font-size:12.5px; color:var(--text-2); background:var(--bg); padding:4px 10px; border-radius:6px; display:inline-block; margin-top:2px">
                    <i class="bi bi-pencil-square"></i> {{ $warga->keterangan_perubahan }}
                </span>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
