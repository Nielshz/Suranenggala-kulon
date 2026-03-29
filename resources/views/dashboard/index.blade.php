@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="welcome anim">
    <h2>👋 Selamat Datang, {{ auth()->user()->nama }}</h2>
    <p>Login sebagai <strong>{{ auth()->user()->status }}</strong> · {{ auth()->user()->keterangan }}</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat anim d1">
            <div class="stat-icon i1"><i class="bi bi-people-fill"></i></div>
            <div class="stat-val">{{ $stats['total_warga'] }}</div>
            <div class="stat-lbl">Total Warga</div>
            <div class="stat-extra">
                <span class="pill pill-m"><i class="bi bi-gender-male"></i> {{ $stats['warga_l'] }}</span>
                <span class="pill pill-f"><i class="bi bi-gender-female"></i> {{ $stats['warga_p'] }}</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat anim d2">
            <div class="stat-icon i2"><i class="bi bi-person-vcard-fill"></i></div>
            <div class="stat-val">{{ $stats['total_kk'] }}</div>
            <div class="stat-lbl">Kartu Keluarga</div>
            <div class="stat-extra"><i class="bi bi-database"></i> Data KK tercatat</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat anim d3">
            <div class="stat-icon i3"><i class="bi bi-arrow-left-right"></i></div>
            <div class="stat-val">{{ $stats['total_mutasi'] }}</div>
            <div class="stat-lbl">Data Mutasi</div>
            <div class="stat-extra">
                <span class="pill pill-m"><i class="bi bi-gender-male"></i> {{ $stats['mutasi_l'] }}</span>
                <span class="pill pill-f"><i class="bi bi-gender-female"></i> {{ $stats['mutasi_p'] }}</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat anim d4">
            <div class="stat-icon i4"><i class="bi bi-bar-chart-fill"></i></div>
            <div class="stat-val">{{ $stats['warga_gte17'] }}</div>
            <div class="stat-lbl">Warga ≥ 17 Th</div>
            <div class="stat-extra"><i class="bi bi-person"></i> {{ $stats['warga_lt17'] }} warga &lt; 17 tahun</div>
        </div>
    </div>
</div>

<div class="pg-header"><h1><i class="bi bi-lightning-fill"></i> Akses Cepat</h1></div>
<div class="row g-3">
    <div class="col-md-4">
        <div class="card h-100"><div class="card-body">
            <h6 class="fw-bold mb-1"><i class="bi bi-people-fill text-primary me-1"></i> Data Warga</h6>
            <p class="text-muted small mb-3">{{ $stats['total_warga'] }} data terdaftar</p>
            <a href="{{ route('warga.index') }}" class="btn btn-primary btn-sm w-100"><i class="bi bi-arrow-right"></i> Lihat</a>
        </div></div>
    </div>
    <div class="col-md-4">
        <div class="card h-100"><div class="card-body">
            <h6 class="fw-bold mb-1"><i class="bi bi-person-vcard-fill text-success me-1"></i> Kartu Keluarga</h6>
            <p class="text-muted small mb-3">{{ $stats['total_kk'] }} data tercatat</p>
            <a href="{{ route('kartu-keluarga.index') }}" class="btn btn-primary btn-sm w-100"><i class="bi bi-arrow-right"></i> Lihat</a>
        </div></div>
    </div>
    <div class="col-md-4">
        <div class="card h-100"><div class="card-body">
            <h6 class="fw-bold mb-1"><i class="bi bi-arrow-left-right text-warning me-1"></i> Data Mutasi</h6>
            <p class="text-muted small mb-3">{{ $stats['total_mutasi'] }} data tercatat</p>
            <a href="{{ route('mutasi.index') }}" class="btn btn-primary btn-sm w-100"><i class="bi bi-arrow-right"></i> Lihat</a>
        </div></div>
    </div>
</div>
@endsection
