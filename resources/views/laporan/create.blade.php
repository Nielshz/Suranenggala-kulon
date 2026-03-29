<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirim Laporan — Desa Suranenggala Kulon</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root { --pri:#1e3a5f; --accent:#e8b931; --bg:#f1f5f9; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); min-height: 100vh; -webkit-font-smoothing: antialiased; }

        .topbar { background: var(--pri); padding: 14px 0; }
        .topbar-inner { max-width: 800px; margin: 0 auto; padding: 0 20px; display: flex; align-items: center; justify-content: space-between; }
        .topbar-brand { display: flex; align-items: center; gap: 10px; color: #fff; text-decoration: none; }
        .topbar-logo { width: 32px; height: 32px; background: var(--accent); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 900; color: var(--pri); font-size: 13px; }
        .topbar-title { font-size: 14px; font-weight: 700; }
        .topbar-back { color: rgba(255,255,255,.7); font-size: 13px; font-weight: 500; text-decoration: none; }
        .topbar-back:hover { color: #fff; }

        .container { max-width: 800px; margin: 0 auto; padding: 32px 20px; }

        .page-head { margin-bottom: 28px; }
        .page-head h1 { font-size: 24px; font-weight: 800; color: var(--pri); display: flex; align-items: center; gap: 10px; }
        .page-head p { color: #64748b; font-size: 13.5px; margin-top: 4px; }

        .card { background: #fff; border-radius: 14px; border: 1px solid #e2e8f0; margin-bottom: 20px; overflow: hidden; }
        .card-head { padding: 16px 22px; border-bottom: 1px solid #f1f5f9; font-size: 14px; font-weight: 700; display: flex; align-items: center; gap: 8px; }
        .card-body { padding: 22px; }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .form-grid .full { grid-column: 1 / -1; }
        label { display: block; font-size: 12.5px; font-weight: 600; color: #334155; margin-bottom: 5px; }
        input, select, textarea {
            width: 100%; padding: 10px 14px; font-size: 13px; border: 1.5px solid #e2e8f0;
            border-radius: 8px; background: #f8fafc; font-family: inherit; outline: none; transition: all .2s;
        }
        input:focus, select:focus, textarea:focus { border-color: var(--pri); background: #fff; box-shadow: 0 0 0 3px rgba(30,58,95,.06); }
        textarea { resize: vertical; min-height: 100px; }

        .btn-submit {
            width: 100%; padding: 13px; font-size: 14px; font-weight: 700; border: none;
            background: #25d366; color: #fff; border-radius: 10px; cursor: pointer;
            font-family: inherit; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all .2s;
        }
        .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(37,211,102,.3); }

        .alert-ok { background: #f0fdf4; border: 1px solid #86efac; color: #166534; padding: 14px 18px; border-radius: 10px; font-size: 13px; margin-bottom: 20px; display: flex; align-items: flex-start; gap: 10px; }
        .alert-ok i { font-size: 18px; margin-top: 1px; }
        .alert-err { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 14px 18px; border-radius: 10px; font-size: 13px; margin-bottom: 20px; }

        .wa-link { display: inline-flex; align-items: center; gap: 8px; background: #25d366; color: #fff; padding: 8px 18px; border-radius: 8px; font-size: 13px; font-weight: 700; margin-top: 8px; text-decoration: none; transition: all .2s; }
        .wa-link:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(37,211,102,.3); }

        .info-box { background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 14px 18px; font-size: 12.5px; color: #1e40af; margin-bottom: 16px; display: flex; gap: 10px; }
        .info-box i { font-size: 16px; margin-top: 1px; }

        @media(max-width:600px) { .form-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

<div class="topbar">
    <div class="topbar-inner">
        <a href="/" class="topbar-brand">
            <div class="topbar-logo">SK</div>
            <span class="topbar-title">Desa Suranenggala Kulon</span>
        </a>
        <a href="/" class="topbar-back"><i class="bi bi-arrow-left"></i> Beranda</a>
    </div>
</div>

<div class="container">
    <div class="page-head">
        <h1><i class="bi bi-chat-square-text-fill" style="color:var(--accent)"></i> Kirim Laporan Warga</h1>
        <p>Sampaikan aspirasi, keluhan, atau laporan ke Perangkat Desa Suranenggala Kulon. Laporan akan diteruskan via WhatsApp.</p>
    </div>

    @if(session('success'))
    <div class="alert-ok">
        <i class="bi bi-check-circle-fill"></i>
        <div>
            <strong>{{ session('success') }}</strong>
            <p style="margin-top:4px;font-size:12px">Laporan Anda telah tercatat di sistem. Klik tombol di bawah untuk mengirimkan juga via WhatsApp ke perangkat desa:</p>
            @if(session('wa_link'))
            <a href="{{ session('wa_link') }}" target="_blank" class="wa-link"><i class="bi bi-whatsapp"></i> Kirim via WhatsApp</a>
            @endif
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="alert-err"><i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}</div>
    @endif

    <form action="{{ route('laporan.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-head"><i class="bi bi-person-fill" style="color:var(--pri)"></i> Data Pelapor</div>
            <div class="card-body">
                <div class="form-grid">
                    <div>
                        <label>Nama Lengkap *</label>
                        <input type="text" name="nama_pelapor" required value="{{ old('nama_pelapor') }}" placeholder="Nama Anda">
                    </div>
                    <div>
                        <label>No. HP / WhatsApp *</label>
                        <input type="text" name="no_hp" required value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx">
                    </div>
                    <div class="full">
                        <label>Alamat</label>
                        <input type="text" name="alamat_pelapor" value="{{ old('alamat_pelapor') }}" placeholder="RT/RW, Dusun, dll.">
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-head"><i class="bi bi-chat-dots-fill" style="color:#d97706"></i> Detail Laporan</div>
            <div class="card-body">
                <div class="info-box">
                    <i class="bi bi-info-circle-fill"></i>
                    <div>Laporan Anda akan masuk ke sistem admin desa. Setelah mengirim formulir, Anda bisa meneruskan laporan langsung ke WhatsApp perangkat desa untuk respon lebih cepat.</div>
                </div>
                <div class="form-grid">
                    <div>
                        <label>Kategori *</label>
                        <select name="kategori" required>
                            <option value="">— Pilih Kategori —</option>
                            <option value="Administrasi" {{ old('kategori')=='Administrasi'?'selected':'' }}>📋 Administrasi</option>
                            <option value="Infrastruktur" {{ old('kategori')=='Infrastruktur'?'selected':'' }}>🏗️ Infrastruktur</option>
                            <option value="Keamanan" {{ old('kategori')=='Keamanan'?'selected':'' }}>🛡️ Keamanan</option>
                            <option value="Kebersihan" {{ old('kategori')=='Kebersihan'?'selected':'' }}>🧹 Kebersihan</option>
                            <option value="Sosial" {{ old('kategori')=='Sosial'?'selected':'' }}>🤝 Sosial</option>
                            <option value="Lainnya" {{ old('kategori')=='Lainnya'?'selected':'' }}>📌 Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label>Subjek Laporan *</label>
                        <input type="text" name="subjek" required value="{{ old('subjek') }}" placeholder="Ringkasan singkat">
                    </div>
                    <div class="full">
                        <label>Isi Laporan *</label>
                        <textarea name="isi_laporan" required placeholder="Jelaskan detail laporan Anda...">{{ old('isi_laporan') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn-submit"><i class="bi bi-whatsapp"></i> Kirim Laporan</button>
    </form>
</div>
</body>
</html>
