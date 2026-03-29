@extends('layouts.app')
@section('title', 'Data Warga')

@section('content')
<div class="pg-header">
    <h1><i class="bi bi-people-fill"></i> Data Warga</h1>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('warga.export') }}" class="btn btn-success btn-sm"><i class="bi bi-file-earmark-arrow-down"></i> Export Excel</a>
        @if(auth()->user()->status !== 'RW')
        <a href="{{ route('warga.import') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-file-earmark-arrow-up"></i> Import</a>
        <a href="{{ route('warga.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Tambah Warga</a>
        @endif
    </div>
</div>

<div class="tbl-wrap">
    <table class="table table-hover data-table mb-0">
        <thead>
            <tr>
                <th width="36">No</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>L/P</th>
                <th class="hide-sm">Usia</th>
                <th class="hide-sm">Pendidikan</th>
                <th class="hide-sm">Pekerjaan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($warga as $i => $w)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td><span class="nik-code">{{ $w->nik }}</span></td>
                <td><strong>{{ $w->nama }}</strong></td>
                <td>
                    @if($w->jenis_kelamin == 'L')
                        <span class="pill pill-m"><i class="bi bi-gender-male"></i> L</span>
                    @else
                        <span class="pill pill-f"><i class="bi bi-gender-female"></i> P</span>
                    @endif
                </td>
                <td class="hide-sm">{{ $w->usia }}</td>
                <td class="hide-sm">{{ $w->pendidikan_terakhir ?? '—' }}</td>
                <td class="hide-sm">{{ $w->pekerjaan ?? '—' }}</td>
                <td>
                    @if($w->status == 'Tetap')
                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">Tetap</span>
                    @else
                        <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25">Kontrak</span>
                    @endif
                </td>
                <td>
                    <div class="act-group">
                        <a href="{{ route('warga.show', $w) }}" class="act-btn act-view" title="Detail"><i class="bi bi-eye"></i></a>
                        @if(auth()->user()->status !== 'RW')
                        <a href="{{ route('warga.edit', $w) }}" class="act-btn act-edit" title="Ubah"><i class="bi bi-pencil"></i></a>
                        <a href="{{ route('mutasi.create', ['warga_id' => $w->id]) }}" class="act-btn act-warn" title="Mutasi"><i class="bi bi-arrow-left-right"></i></a>
                        <form action="{{ route('warga.destroy', $w) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin hapus data ini?')">
                            @csrf @method('DELETE')
                            <button class="act-btn act-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
