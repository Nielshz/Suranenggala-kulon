@extends('layouts.app')
@section('title', 'Data Kartu Keluarga')

@section('content')
<div class="pg-header">
    <h1><i class="bi bi-person-vcard-fill"></i> Data Kartu Keluarga</h1>
    @if(auth()->user()->status !== 'RW')
    <a href="{{ route('kartu-keluarga.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah KK</a>
    @endif
</div>

<div class="tbl-wrap">
    <table class="table table-hover data-table mb-0">
        <thead>
            <tr><th width="36">No</th><th>No. KK</th><th>Kepala Keluarga</th><th>Anggota</th><th class="hide-sm">Alamat</th><th class="hide-sm">RT/RW</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @foreach($kartuKeluarga as $i => $kk)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td><span class="nik-code">{{ $kk->nomor_keluarga }}</span></td>
                <td><strong>{{ $kk->kepalaKeluarga->nama ?? '—' }}</strong></td>
                <td><span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">{{ $kk->anggota->count() }} orang</span></td>
                <td class="hide-sm">{{ $kk->alamat ?? '—' }}</td>
                <td class="hide-sm">{{ $kk->rt }}/{{ $kk->rw }}</td>
                <td>
                    <div class="act-group">
                        <a href="{{ route('kartu-keluarga.show', $kk) }}" class="act-btn act-view" title="Detail"><i class="bi bi-eye"></i></a>
                        @if(auth()->user()->status !== 'RW')
                        <a href="{{ route('kartu-keluarga.edit', $kk) }}" class="act-btn act-edit" title="Ubah"><i class="bi bi-pencil"></i></a>
                        <a href="{{ route('kartu-keluarga.edit-anggota', $kk) }}" class="act-btn" title="Anggota"><i class="bi bi-people"></i></a>
                        <form action="{{ route('kartu-keluarga.destroy', $kk) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin hapus?')">
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
