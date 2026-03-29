@extends('layouts.app')
@section('title', 'Pengumuman')
@section('content')
<div class="pg-header"><h1><i class="bi bi-megaphone-fill"></i> Pengumuman</h1><a href="{{ route('pengumuman.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah</a></div>
<div class="tbl-wrap">
    <table class="table table-hover data-table mb-0">
        <thead><tr><th width="30">#</th><th>Judul</th><th>Kategori</th><th class="hide-sm">Aktif</th><th class="hide-sm">Tanggal</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($pengumuman as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td><strong>{{ $p->judul }}</strong></td>
                <td><span class="badge bg-light text-dark border" style="font-size:10.5px">{{ $p->kategori }}</span></td>
                <td class="hide-sm">@if($p->is_active)<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">Ya</span>@else<span class="badge bg-secondary bg-opacity-10 text-secondary border">Tidak</span>@endif</td>
                <td class="hide-sm">{{ $p->created_at->format('d/m/Y') }}</td>
                <td>
                    <div class="act-group">
                        <a href="{{ route('pengumuman.edit', $p) }}" class="act-btn act-edit" title="Edit"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('pengumuman.destroy', $p) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus pengumuman?')">@csrf @method('DELETE')<button class="act-btn act-danger" title="Hapus"><i class="bi bi-trash"></i></button></form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
