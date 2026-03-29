@extends('layouts.app')
@section('title', 'Kelola User')

@section('content')
<div class="pg-header">
    <h1><i class="bi bi-person-gear"></i> Kelola User</h1>
    <a href="{{ route('user.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah User</a>
</div>

<div class="tbl-wrap">
    <table class="table table-hover data-table mb-0">
        <thead>
            <tr><th width="36">No</th><th>Nama</th><th>Username</th><th class="hide-sm">Keterangan</th><th>Role</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @foreach($users as $i => $u)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <div class="avatar" style="width:28px;height:28px;font-size:11px;">{{ strtoupper(substr($u->nama,0,1)) }}</div>
                        <strong>{{ $u->nama }}</strong>
                    </div>
                </td>
                <td><span class="nik-code">{{ $u->username }}</span></td>
                <td class="hide-sm">{{ $u->keterangan ?? '—' }}</td>
                <td>
                    @if($u->status=='Admin')<span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">Admin</span>
                    @elseif($u->status=='RT')<span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">RT</span>
                    @else<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">RW</span>@endif
                </td>
                <td>
                    <div class="act-group">
                        <a href="{{ route('user.show', $u) }}" class="act-btn act-view" title="Detail"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('user.edit', $u) }}" class="act-btn act-edit" title="Ubah"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('user.destroy', $u) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin hapus user ini?')">
                            @csrf @method('DELETE')
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
