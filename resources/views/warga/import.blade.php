@extends('layouts.app')
@section('title', 'Import Data Warga')

@section('content')
<div class="pg-header">
    <h1><i class="bi bi-upload"></i> Import Data Warga</h1>
    <a href="{{ route('warga.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<div class="row g-4">
    {{-- Left: Upload Form --}}
    <div class="col-lg-7">
        <div class="sec">
            <div class="sec-head" style="border-left:3px solid var(--primary);">
                <i class="bi bi-file-earmark-spreadsheet" style="color:var(--primary)"></i>
                <h5>Upload File</h5>
            </div>
            <div class="sec-body">
                <form action="{{ route('warga.import.process') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Pilih File Excel / CSV <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="file" accept=".csv,.xls,.xlsx,.txt" required id="fileInput">
                        <small class="text-muted">Format: <code>.csv</code>, <code>.xls</code>, <code>.xlsx</code> — Maks 5MB</small>
                    </div>

                    {{-- File preview info --}}
                    <div id="filePreview" style="display:none;" class="mb-3">
                        <div style="background:var(--bg); border:1px solid var(--border); border-radius:8px; padding:12px;">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-file-earmark-check" style="font-size:24px; color:var(--success)"></i>
                                <div>
                                    <strong id="fileName" style="font-size:13px"></strong>
                                    <small class="text-muted d-block" id="fileSize"></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert" style="background:var(--warning-bg); border:1px solid #fde68a; color:#92400e; font-size:12.5px;">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div>
                            <strong>Perhatian:</strong>
                            <ul class="mb-0 mt-1" style="padding-left:18px">
                                <li>Baris pertama file harus berisi <strong>header kolom</strong></li>
                                <li>NIK yang sudah terdaftar akan otomatis <strong>dilewati</strong> (tidak di-overwrite)</li>
                                <li>Field wajib: <strong>NIK</strong> (16 digit) dan <strong>Nama</strong></li>
                                <li>Semua NIK akan dienkripsi otomatis (HMAC-SHA256 + AES-256-CBC)</li>
                            </ul>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" id="btnImport">
                        <i class="bi bi-upload"></i> Import Data
                    </button>
                </form>
            </div>
        </div>

        {{-- Import errors display --}}
        @if(session('import_errors') && count(session('import_errors')) > 0)
        <div class="sec">
            <div class="sec-head" style="border-left:3px solid var(--warning);">
                <i class="bi bi-exclamation-circle" style="color:var(--warning)"></i>
                <h5>Detail Baris Dilewati</h5>
            </div>
            <div class="sec-body" style="max-height:200px; overflow-y:auto;">
                @foreach(session('import_errors') as $err)
                <div style="font-size:12px; padding:4px 0; color:var(--text-2); border-bottom:1px solid var(--border-light);">
                    <i class="bi bi-dash"></i> {{ $err }}
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    {{-- Right: Template & Instructions --}}
    <div class="col-lg-5">
        <div class="sec">
            <div class="sec-head" style="border-left:3px solid var(--success);">
                <i class="bi bi-download" style="color:var(--success)"></i>
                <h5>Download Template</h5>
            </div>
            <div class="sec-body">
                <p class="text-muted small mb-3">Download template Excel yang sudah berisi format kolom yang benar, contoh data, dan keterangan pengisian.</p>
                <a href="{{ route('warga.template') }}" class="btn btn-success w-100">
                    <i class="bi bi-file-earmark-excel"></i> Download Template Excel
                </a>
            </div>
        </div>

        <div class="sec">
            <div class="sec-head" style="border-left:3px solid var(--info);">
                <i class="bi bi-list-columns-reverse" style="color:var(--info)"></i>
                <h5>Format Kolom</h5>
            </div>
            <div class="sec-body p-0">
                <table class="table table-sm mb-0" style="font-size:12px;">
                    <thead>
                        <tr><th style="padding:8px 14px;">Kolom</th><th style="padding:8px 14px;">Wajib</th><th style="padding:8px 14px;">Keterangan</th></tr>
                    </thead>
                    <tbody>
                        <tr><td style="padding:6px 14px;"><code>NIK</code></td><td><span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">Ya</span></td><td>16 digit angka</td></tr>
                        <tr><td style="padding:6px 14px;"><code>Nama</code></td><td><span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">Ya</span></td><td>Nama lengkap</td></tr>
                        <tr><td style="padding:6px 14px;"><code>Tempat Lahir</code></td><td>—</td><td>Kota lahir</td></tr>
                        <tr><td style="padding:6px 14px;"><code>Tanggal Lahir</code></td><td>—</td><td>YYYY-MM-DD</td></tr>
                        <tr><td style="padding:6px 14px;"><code>Jenis Kelamin</code></td><td>—</td><td>L / P</td></tr>
                        <tr><td style="padding:6px 14px;"><code>Alamat KTP</code></td><td>—</td><td></td></tr>
                        <tr><td style="padding:6px 14px;"><code>Alamat Domisili</code></td><td>—</td><td></td></tr>
                        <tr><td style="padding:6px 14px;"><code>Desa/Kelurahan</code></td><td>—</td><td></td></tr>
                        <tr><td style="padding:6px 14px;"><code>Kecamatan</code></td><td>—</td><td></td></tr>
                        <tr><td style="padding:6px 14px;"><code>Kabupaten/Kota</code></td><td>—</td><td></td></tr>
                        <tr><td style="padding:6px 14px;"><code>Provinsi</code></td><td>—</td><td></td></tr>
                        <tr><td style="padding:6px 14px;"><code>Agama</code></td><td>—</td><td></td></tr>
                        <tr><td style="padding:6px 14px;"><code>Pendidikan</code></td><td>—</td><td>SD–S3</td></tr>
                        <tr><td style="padding:6px 14px;"><code>Pekerjaan</code></td><td>—</td><td></td></tr>
                        <tr><td style="padding:6px 14px;"><code>Status Perkawinan</code></td><td>—</td><td>Kawin/Tidak Kawin</td></tr>
                        <tr><td style="padding:6px 14px;"><code>Status Tinggal</code></td><td>—</td><td>Tetap/Kontrak</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('fileInput').addEventListener('change', function(e) {
    const preview = document.getElementById('filePreview');
    if (this.files.length > 0) {
        const file = this.files[0];
        document.getElementById('fileName').textContent = file.name;
        document.getElementById('fileSize').textContent = (file.size / 1024).toFixed(1) + ' KB';
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }
});
</script>
@endpush
