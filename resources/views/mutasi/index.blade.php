@extends('layouts.app')
@section('title', 'Data Mutasi')

@section('content')
<div class="pg-header">
    <h1><i class="bi bi-arrow-left-right"></i> Data Mutasi</h1>
    <a href="{{ route('mutasi.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Mutasi</a>
</div>

<div class="tbl-wrap">
    <table class="table table-hover data-table mb-0">
        <thead>
            <tr><th width="36">No</th><th>NIK</th><th>Nama</th><th>L/P</th><th class="hide-sm">Usia</th><th class="hide-sm">Pendidikan</th><th class="hide-sm">Pekerjaan</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @foreach($mutasi as $i => $m)
            <tr>
                <td>{{ $i+1 }}</td>
                <td><span class="nik-code">{{ $m->nik }}</span></td>
                <td><strong>{{ $m->nama }}</strong></td>
                <td>@if($m->jenis_kelamin=='L')<span class="pill pill-m"><i class="bi bi-gender-male"></i> L</span>@else<span class="pill pill-f"><i class="bi bi-gender-female"></i> P</span>@endif</td>
                <td class="hide-sm">{{ $m->usia }}</td>
                <td class="hide-sm">{{ $m->pendidikan_terakhir ?? '—' }}</td>
                <td class="hide-sm">{{ $m->pekerjaan ?? '—' }}</td>
                <td>@if($m->status=='Tetap')<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">Tetap</span>@else<span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25">Kontrak</span>@endif</td>
                <td>
                    <div class="act-group">
                        <a href="{{ route('mutasi.show', $m) }}" class="act-btn act-view" title="Detail"><i class="bi bi-eye"></i></a>
                        @if(auth()->user()->status !== 'RW')
                        <form action="{{ route('mutasi.destroy', $m) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin hapus?')">
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
