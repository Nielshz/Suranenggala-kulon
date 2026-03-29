@extends('layouts.app')
@section('title', 'Galeri')
@section('content')
<div class="pg-header"><h1><i class="bi bi-images"></i> Galeri</h1><a href="{{ route('galeri.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Foto</a></div>
<div class="row g-3">
    @forelse($galeri as $g)
    <div class="col-6 col-md-4 col-lg-3">
        <div class="card h-100">
            <img src="{{ asset('uploads/' . $g->path) }}" class="card-img-top" style="height:160px;object-fit:cover;" alt="{{ $g->caption }}">
            <div class="card-body py-2 px-3">
                <p class="fw-semibold mb-0" style="font-size:12.5px">{{ $g->caption }}</p>
                @if($g->tautan)<small class="text-muted d-block" style="font-size:11px">{{ $g->tautan }}</small>@endif
            </div>
            <div class="card-footer bg-transparent border-0 py-2 px-3 d-flex gap-2">
                <a href="{{ asset('uploads/' . $g->path) }}" target="_blank" class="act-btn act-view" style="font-size:10px"><i class="bi bi-zoom-in"></i></a>
                <form action="{{ route('galeri.destroy', $g) }}" method="POST" onsubmit="return confirm('Yakin?')">@csrf @method('DELETE')<button class="act-btn act-danger" style="font-size:10px"><i class="bi bi-trash"></i></button></form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="sec"><div class="sec-body text-center py-5">
            <i class="bi bi-images" style="font-size:40px;color:var(--text-3)"></i>
            <h6 class="text-muted mt-2">Belum ada foto</h6>
            <p class="text-muted small">Klik "Tambah Foto" untuk upload.</p>
        </div></div>
    </div>
    @endforelse
</div>
@endsection
