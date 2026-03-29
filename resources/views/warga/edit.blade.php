@extends('layouts.app')
@section('title', 'Edit Warga')

@section('content')
<div class="pg-header">
    <h1><i class="bi bi-pencil-fill"></i> Edit Warga</h1>
    <a href="{{ route('warga.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<form action="{{ route('warga.update', $warga) }}" method="POST">
    @csrf @method('PUT')
    <div class="sec">
        <div class="sec-head" style="border-left:3px solid var(--primary);"><i class="bi bi-person-fill" style="color:var(--primary)"></i><h5>Data Pribadi</h5></div>
        <div class="sec-body"><div class="row g-3">
            <div class="col-md-6"><label class="form-label">NIK *</label><input type="text" class="form-control" name="nik" maxlength="16" required value="{{ old('nik', $warga->nik) }}"></div>
            <div class="col-md-6"><label class="form-label">Nama *</label><input type="text" class="form-control" name="nama" required value="{{ old('nama', $warga->nama) }}"></div>
            <div class="col-md-4"><label class="form-label">Tempat Lahir</label><input type="text" class="form-control" name="tempat_lahir" value="{{ old('tempat_lahir', $warga->tempat_lahir) }}"></div>
            <div class="col-md-4"><label class="form-label">Tanggal Lahir</label><input type="date" class="form-control" name="tanggal_lahir" value="{{ old('tanggal_lahir', $warga->tanggal_lahir) }}"></div>
            <div class="col-md-4"><label class="form-label">Jenis Kelamin</label><select class="form-select" name="jenis_kelamin" required><option value="L" {{ old('jenis_kelamin', $warga->jenis_kelamin)=='L'?'selected':'' }}>Laki-laki</option><option value="P" {{ old('jenis_kelamin', $warga->jenis_kelamin)=='P'?'selected':'' }}>Perempuan</option></select></div>
        </div></div>
    </div>

    <div class="sec">
        <div class="sec-head" style="border-left:3px solid var(--success);"><i class="bi bi-geo-alt-fill" style="color:var(--success)"></i><h5>Data Alamat</h5></div>
        <div class="sec-body"><div class="row g-3">
            <div class="col-12"><label class="form-label">Alamat KTP</label><textarea class="form-control" name="alamat_ktp" rows="2">{{ old('alamat_ktp', $warga->alamat_ktp) }}</textarea></div>
            <div class="col-12"><label class="form-label">Alamat Domisili</label><textarea class="form-control" name="alamat" rows="2">{{ old('alamat', $warga->alamat) }}</textarea></div>
            <div class="col-md-4"><label class="form-label">Desa/Kelurahan</label><input type="text" class="form-control" name="desa_kelurahan" value="{{ old('desa_kelurahan', $warga->desa_kelurahan) }}"></div>
            <div class="col-md-4"><label class="form-label">Kecamatan</label><input type="text" class="form-control" name="kecamatan" value="{{ old('kecamatan', $warga->kecamatan) }}"></div>
            <div class="col-md-4"><label class="form-label">Kabupaten/Kota</label><input type="text" class="form-control" name="kabupaten_kota" value="{{ old('kabupaten_kota', $warga->kabupaten_kota) }}"></div>
            <div class="col-md-4"><label class="form-label">Provinsi</label><input type="text" class="form-control" name="provinsi" value="{{ old('provinsi', $warga->provinsi) }}"></div>
            <div class="col-md-4"><label class="form-label">Negara</label><input type="text" class="form-control" name="negara" value="{{ old('negara', $warga->negara) }}"></div>
            <div class="col-md-2"><label class="form-label">RT</label><input type="text" class="form-control" name="rt" value="{{ old('rt', $warga->rt) }}"></div>
            <div class="col-md-2"><label class="form-label">RW</label><input type="text" class="form-control" name="rw" value="{{ old('rw', $warga->rw) }}"></div>
        </div></div>
    </div>

    <div class="sec">
        <div class="sec-head" style="border-left:3px solid var(--warning);"><i class="bi bi-info-circle-fill" style="color:var(--warning)"></i><h5>Data Lainnya</h5></div>
        <div class="sec-body"><div class="row g-3">
            <div class="col-md-4"><label class="form-label">Agama</label><select class="form-select" name="agama"><option value="">— Pilih —</option>@foreach(['Islam','Kristen','Katholik','Hindu','Budha','Konghucu'] as $a)<option value="{{ $a }}" {{ old('agama', $warga->agama)==$a?'selected':'' }}>{{ $a }}</option>@endforeach</select></div>
            <div class="col-md-4"><label class="form-label">Pendidikan</label><select class="form-select" name="pendidikan_terakhir"><option value="">— Pilih —</option>@foreach(['Tidak Sekolah','Tidak Tamat SD','SD','SMP','SMA','D1','D2','D3','S1','S2','S3'] as $p)<option value="{{ $p }}" {{ old('pendidikan_terakhir', $warga->pendidikan_terakhir)==$p?'selected':'' }}>{{ $p }}</option>@endforeach</select></div>
            <div class="col-md-4"><label class="form-label">Pekerjaan</label><input type="text" class="form-control" name="pekerjaan" value="{{ old('pekerjaan', $warga->pekerjaan) }}"></div>
            <div class="col-md-4"><label class="form-label">Status Perkawinan</label><select class="form-select" name="status_perkawinan"><option value="">— Pilih —</option><option value="Kawin" {{ old('status_perkawinan', $warga->status_perkawinan)=='Kawin'?'selected':'' }}>Kawin</option><option value="Tidak Kawin" {{ old('status_perkawinan', $warga->status_perkawinan)=='Tidak Kawin'?'selected':'' }}>Tidak Kawin</option></select></div>
            <div class="col-md-4"><label class="form-label">Status Tinggal</label><select class="form-select" name="status"><option value="Tetap" {{ old('status', $warga->status)=='Tetap'?'selected':'' }}>Tetap</option><option value="Kontrak" {{ old('status', $warga->status)=='Kontrak'?'selected':'' }}>Kontrak</option></select></div>
        </div></div>
    </div>

    <div class="d-flex gap-2 flex-wrap">
        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Simpan Perubahan</button>
        <a href="{{ route('warga.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection
