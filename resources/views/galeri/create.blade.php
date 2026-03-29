@extends('layouts.app')
@section('title', 'Tambah Foto')
@section('content')
<div class="page-header-custom"><h1><i class="bi bi-image"></i> Tambah Foto</h1><a href="{{ route('galeri.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a></div>
<form action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data">@csrf
<div class="section-card"><div class="section-card-body"><div class="row g-3">
    <div class="col-12"><label class="form-label fw-semibold">Pilih Foto *</label><input type="file" class="form-control" name="foto" accept="image/*" required></div>
    <div class="col-12"><label class="form-label fw-semibold">Caption *</label><input type="text" class="form-control" name="caption" required value="{{ old('caption') }}"></div>
    <div class="col-12"><label class="form-label fw-semibold">Tautan (opsional)</label><input type="text" class="form-control" name="tautan" value="{{ old('tautan') }}"></div>
</div></div></div>
<button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-upload"></i> Upload</button>
</form>
@endsection
