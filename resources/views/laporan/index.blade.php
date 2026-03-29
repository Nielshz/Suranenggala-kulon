@extends('layouts.app')
@section('title', 'Laporan Warga')
@section('content')
<div class="pg-header">
    <h1><i class="bi bi-chat-square-text-fill"></i> Laporan Warga</h1>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-sm-4">
        <div class="stat-card" style="border-left:3px solid var(--warning)">
            <div class="stat-icon" style="background:#fef3c7;color:#d97706"><i class="bi bi-inbox"></i></div>
            <div><div class="stat-num">{{ $stats['masuk'] }}</div><div class="stat-label">Masuk</div></div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="stat-card" style="border-left:3px solid var(--info)">
            <div class="stat-icon" style="background:#dbeafe;color:#2563eb"><i class="bi bi-gear"></i></div>
            <div><div class="stat-num">{{ $stats['proses'] }}</div><div class="stat-label">Diproses</div></div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="stat-card" style="border-left:3px solid var(--success)">
            <div class="stat-icon" style="background:#dcfce7;color:#16a34a"><i class="bi bi-check-circle"></i></div>
            <div><div class="stat-num">{{ $stats['selesai'] }}</div><div class="stat-label">Selesai</div></div>
        </div>
    </div>
</div>

<div class="tbl-wrap">
    <table class="table table-hover data-table mb-0">
        <thead>
            <tr>
                <th width="30">#</th>
                <th>Pelapor</th>
                <th>Subjek</th>
                <th class="hide-sm">Kategori</th>
                <th>Status</th>
                <th class="hide-sm">Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $i => $l)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>
                    <strong>{{ $l->nama_pelapor }}</strong>
                    <small class="text-muted d-block">{{ $l->no_hp }}</small>
                </td>
                <td>{{ Str::limit($l->subjek, 40) }}</td>
                <td class="hide-sm"><span class="badge bg-light text-dark border" style="font-size:10.5px">{{ $l->kategori }}</span></td>
                <td>
                    @php $sc = match($l->status) { 'Masuk' => 'warning', 'Dibaca' => 'info', 'Diproses' => 'primary', 'Selesai' => 'success', 'Ditolak' => 'danger', default => 'secondary' }; @endphp
                    <span class="badge bg-{{ $sc }} bg-opacity-10 text-{{ $sc }} border border-{{ $sc }} border-opacity-25" style="font-size:10.5px">{{ $l->status }}</span>
                </td>
                <td class="hide-sm">{{ $l->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <div class="act-group">
                        <a href="{{ route('laporan.show', $l) }}" class="act-btn act-view" title="Detail"><i class="bi bi-eye"></i></a>
                        <a href="{{ $l->wa_reply_link }}" target="_blank" class="act-btn act-edit" title="Balas WA" style="background:#dcfce7;color:#16a34a;border-color:#86efac"><i class="bi bi-whatsapp"></i></a>
                        <form action="{{ route('laporan.destroy', $l) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus laporan ini?')">@csrf @method('DELETE')
                            <button class="act-btn act-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
