<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Warga Desa Suranenggala Kulon</title>
    <meta name="description" content="Sistem informasi data warga dan layanan publik Desa Suranenggala Kulon, Kecamatan Suranenggala, Kabupaten Cirebon.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        :root {
            --pri: #1e3a5f; --pri-light: #2d5a8e; --accent: #e8b931;
            --dark: #0d1117; --text: #1e293b; --text-2: #64748b;
            --bg: #f8fafc; --white: #ffffff;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; color: var(--text); -webkit-font-smoothing: antialiased; }
        a { text-decoration: none; color: inherit; }

        /* ─── NAVBAR ─── */
        .nav { position: fixed; top: 0; left: 0; right: 0; z-index: 100; padding: 14px 0; transition: all .3s; }
        .nav.scrolled { background: rgba(255,255,255,.95); backdrop-filter: blur(12px); box-shadow: 0 1px 20px rgba(0,0,0,.08); padding: 10px 0; }
        .nav-inner { max-width: 1200px; margin: 0 auto; padding: 0 24px; display: flex; align-items: center; justify-content: space-between; }
        .nav-brand { display: flex; align-items: center; gap: 10px; }
        .nav-logo { width: 36px; height: 36px; background: var(--accent); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 900; color: var(--pri); font-size: 16px; }
        .nav-title { font-size: 14px; font-weight: 700; color: #fff; line-height: 1.2; }
        .nav.scrolled .nav-title { color: var(--pri); }
        .nav-sub { font-size: 10.5px; font-weight: 400; opacity: .8; }
        .nav-links { display: flex; align-items: center; gap: 6px; }
        .nav-link { padding: 7px 14px; border-radius: 8px; font-size: 13px; font-weight: 500; color: rgba(255,255,255,.85); transition: all .2s; }
        .nav.scrolled .nav-link { color: var(--text-2); }
        .nav-link:hover { background: rgba(255,255,255,.12); }
        .nav.scrolled .nav-link:hover { background: rgba(30,58,95,.06); }
        .nav-cta { background: var(--accent) !important; color: var(--dark) !important; font-weight: 700; border-radius: 8px !important; }
        .nav-cta:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(232,185,49,.3); }

        /* ─── HERO ─── */
        .hero { position: relative; min-height: 92vh; display: flex; align-items: center; overflow: hidden;
            background: linear-gradient(135deg, rgba(13,17,23,.72), rgba(30,58,95,.65)), url('/img/hero-bg.png') center/cover no-repeat; }
        .hero-inner { max-width: 1200px; margin: 0 auto; padding: 0 24px; width: 100%; position: relative; z-index: 1; }
        .hero-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(232,185,49,.15); border: 1px solid rgba(232,185,49,.3); color: var(--accent); padding: 5px 14px; border-radius: 50px; font-size: 11.5px; font-weight: 600; margin-bottom: 20px; backdrop-filter: blur(4px); }
        .hero h1 { font-size: clamp(32px, 5vw, 54px); font-weight: 900; color: #fff; line-height: 1.1; margin-bottom: 16px; max-width: 650px; }
        .hero h1 span { color: var(--accent); }
        .hero p { font-size: 16px; color: rgba(255,255,255,.75); max-width: 500px; line-height: 1.7; margin-bottom: 28px; }
        .hero-actions { display: flex; gap: 12px; flex-wrap: wrap; align-items: center; }
        .btn-hero { padding: 12px 28px; border-radius: 10px; font-size: 14px; font-weight: 700; transition: all .2s; display: inline-flex; align-items: center; gap: 8px; font-family: inherit; border: none; cursor: pointer; }
        .btn-fill { background: var(--accent); color: var(--dark); }
        .btn-fill:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(232,185,49,.3); }
        /* Login link - subtle text style, not a prominent button */
        .login-subtle { color: rgba(255,255,255,.45); font-size: 12px; font-weight: 500; padding: 8px 0; transition: color .2s; border: none; background: none; }
        .login-subtle:hover { color: rgba(255,255,255,.8); }
        .login-subtle i { font-size: 11px; }
        .hero-stats { display: flex; gap: 40px; margin-top: 48px; padding-top: 32px; border-top: 1px solid rgba(255,255,255,.12); }
        .hero-stat h3 { font-size: 28px; font-weight: 800; color: var(--accent); }
        .hero-stat p { font-size: 12px; color: rgba(255,255,255,.6); margin-top: 2px; }

        /* ─── SECTION ─── */
        .section { padding: 80px 0; }
        .section-inner { max-width: 1200px; margin: 0 auto; padding: 0 24px; }
        .section-title { text-align: center; margin-bottom: 48px; }
        .section-title h2 { font-size: 28px; font-weight: 800; color: var(--pri); }
        .section-title p { font-size: 14px; color: var(--text-2); margin-top: 8px; }
        .section-tag { display: inline-block; background: rgba(30,58,95,.06); color: var(--pri); padding: 4px 14px; border-radius: 50px; font-size: 11px; font-weight: 700; letter-spacing: .5px; text-transform: uppercase; margin-bottom: 12px; }

        /* ─── ABOUT ─── */
        .about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 48px; align-items: center; }
        .about-img { border-radius: 16px; overflow: hidden; position: relative; }
        .about-img img { width: 100%; height: 360px; object-fit: cover; border-radius: 16px; }
        .about-text h3 { font-size: 24px; font-weight: 800; color: var(--pri); margin-bottom: 14px; }
        .about-text p { font-size: 14px; line-height: 1.8; color: var(--text-2); margin-bottom: 12px; }
        .about-features { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 20px; }
        .about-feat { display: flex; align-items: center; gap: 8px; padding: 10px 14px; background: var(--bg); border-radius: 10px; font-size: 13px; font-weight: 500; }
        .about-feat i { color: var(--accent); font-size: 16px; }

        /* ─── MAP ─── */
        .map-section { background: var(--white); }
        .map-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0; border-radius: 16px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 4px 20px rgba(0,0,0,.06); }
        .map-container { height: 420px; min-height: 360px; }
        .map-info { padding: 36px; display: flex; flex-direction: column; justify-content: center; background: #fff; }
        .map-info h3 { font-size: 22px; font-weight: 800; color: var(--pri); margin-bottom: 16px; display: flex; align-items: center; gap: 10px; }
        .map-info h3 i { color: var(--accent); }
        .map-detail { list-style: none; padding: 0; }
        .map-detail li { display: flex; align-items: flex-start; gap: 12px; padding: 10px 0; border-bottom: 1px solid #f1f5f9; font-size: 13.5px; }
        .map-detail li:last-child { border-bottom: none; }
        .map-detail .dt-icon { width: 34px; height: 34px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0; }
        .map-detail .dt-label { font-size: 11px; color: var(--text-2); font-weight: 600; text-transform: uppercase; letter-spacing: .3px; }
        .map-detail .dt-value { font-weight: 600; color: var(--text); margin-top: 1px; }
        .map-btn { display: inline-flex; align-items: center; gap: 8px; margin-top: 18px; padding: 10px 20px; background: var(--pri); color: #fff; border-radius: 8px; font-size: 13px; font-weight: 700; transition: all .2s; }
        .map-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(30,58,95,.25); }

        /* ─── ANNOUNCEMENTS ─── */
        .section-alt { background: var(--bg); }
        .ann-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 20px; }
        .ann-card { background: #fff; border-radius: 14px; padding: 24px; border: 1px solid #e2e8f0; transition: all .2s; }
        .ann-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,.06); }
        .ann-badge { display: inline-block; padding: 3px 10px; border-radius: 6px; font-size: 10.5px; font-weight: 700; margin-bottom: 10px; }
        .ann-badge.penting { background: #fef2f2; color: #dc2626; }
        .ann-badge.umum { background: #eff6ff; color: #2563eb; }
        .ann-badge.kegiatan { background: #f0fdf4; color: #16a34a; }
        .ann-badge.layanan { background: #fefce8; color: #ca8a04; }
        .ann-card h4 { font-size: 15px; font-weight: 700; margin-bottom: 8px; color: var(--text); line-height: 1.4; }
        .ann-card p { font-size: 13px; color: var(--text-2); line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        .ann-meta { display: flex; align-items: center; gap: 6px; margin-top: 12px; font-size: 11.5px; color: var(--text-2); }
        .ann-empty { text-align: center; padding: 48px; color: var(--text-2); }

        /* ─── SERVICES ─── */
        .svc-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 20px; }
        .svc-card { background: #fff; border-radius: 14px; padding: 28px; text-align: center; border: 1px solid #e2e8f0; transition: all .3s; }
        .svc-card:hover { transform: translateY(-4px); box-shadow: 0 12px 28px rgba(0,0,0,.06); }
        .svc-icon { width: 56px; height: 56px; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 24px; }
        .svc-card h4 { font-size: 15px; font-weight: 700; margin-bottom: 6px; }
        .svc-card p { font-size: 12.5px; color: var(--text-2); line-height: 1.5; }

        /* ─── CTA ─── */
        .cta-section { background: linear-gradient(135deg, var(--pri), var(--pri-light)); padding: 64px 0; }
        .cta-inner { max-width: 700px; margin: 0 auto; text-align: center; padding: 0 24px; }
        .cta-inner h2 { font-size: 28px; font-weight: 800; color: #fff; margin-bottom: 12px; }
        .cta-inner p { font-size: 14px; color: rgba(255,255,255,.7); margin-bottom: 24px; }
        .cta-btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
        .btn-wa { background: #25d366; color: #fff; padding: 12px 28px; border-radius: 10px; font-size: 14px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; transition: all .2s; }
        .btn-wa:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(37,211,102,.3); }

        /* ─── FOOTER ─── */
        .footer { background: var(--dark); color: rgba(255,255,255,.5); padding: 40px 0 24px; }
        .footer-inner { max-width: 1200px; margin: 0 auto; padding: 0 24px; }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 40px; margin-bottom: 32px; }
        .footer-brand h4 { color: #fff; font-size: 16px; font-weight: 800; margin-bottom: 8px; }
        .footer-brand p { font-size: 12.5px; line-height: 1.6; }
        .footer h5 { color: #fff; font-size: 13px; font-weight: 700; margin-bottom: 12px; }
        .footer-links a { display: block; font-size: 12.5px; padding: 3px 0; transition: color .2s; }
        .footer-links a:hover { color: var(--accent); }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,.08); padding-top: 20px; display: flex; align-items: center; justify-content: space-between; font-size: 11.5px; }
        .footer-login { color: rgba(255,255,255,.35); font-size: 11px; transition: color .2s; }
        .footer-login:hover { color: rgba(255,255,255,.7); }

        /* ─── RESPONSIVE ─── */
        @media(max-width:768px) {
            .hero { min-height: 85vh; }
            .hero-stats { gap: 24px; flex-wrap: wrap; }
            .about-grid { grid-template-columns: 1fr; gap: 28px; }
            .about-img img { height: 240px; }
            .map-grid { grid-template-columns: 1fr; }
            .map-container { height: 280px; }
            .map-info { padding: 24px; }
            .footer-grid { grid-template-columns: 1fr; gap: 24px; }
            .nav-links .nav-link:not(.nav-cta) { display: none; }
            .ann-grid { grid-template-columns: 1fr; }
            .footer-bottom { flex-direction: column; gap: 8px; text-align: center; }
        }
        @media(max-width:480px) {
            .hero h1 { font-size: 28px; }
            .hero p { font-size: 14px; }
            .about-features { grid-template-columns: 1fr; }
        }

        /* ─── ANIMATIONS ─── */
        .fade-up { opacity: 0; transform: translateY(24px); transition: opacity .6s, transform .6s; }
        .fade-up.visible { opacity: 1; transform: translateY(0); }

        /* Leaflet overrides */
        .leaflet-popup-content-wrapper { border-radius: 10px !important; font-family: 'Plus Jakarta Sans', sans-serif !important; }
        .leaflet-popup-content { font-size: 13px !important; line-height: 1.5 !important; margin: 12px 16px !important; }
        .leaflet-popup-content strong { color: var(--pri); }
    </style>
</head>
<body>

<!-- ═══ NAVBAR ═══ -->
<nav class="nav" id="navbar">
    <div class="nav-inner">
        <a href="/" class="nav-brand">
            <div class="nav-logo">SK</div>
            <div>
                <div class="nav-title">Desa Suranenggala Kulon</div>
                <div class="nav-sub nav-title" style="font-size:10px;opacity:.7">Kec. Suranenggala, Kab. Cirebon</div>
            </div>
        </a>
        <div class="nav-links">
            <a href="#tentang" class="nav-link">Tentang</a>
            <a href="#lokasi" class="nav-link">Lokasi</a>
            <a href="#pengumuman" class="nav-link">Pengumuman</a>
            <a href="{{ route('login') }}" class="nav-link" style="color:var(--accent)"><i class="bi bi-box-arrow-in-right"></i> Login</a>
            <a href="{{ route('laporan.create') }}" class="nav-link nav-cta"><i class="bi bi-send"></i> Lapor</a>
        </div>
    </div>
</nav>

<!-- ═══ HERO ═══ -->
<section class="hero">
    <div class="hero-inner">
        <div class="hero-badge"><i class="bi bi-geo-alt-fill"></i> Desa Suranenggala Kulon, Cirebon</div>
        <h1>Data Warga <span>Desa Suranenggala Kulon</span></h1>
        <p>Sistem informasi pendataan penduduk dan layanan publik digital Desa Suranenggala Kulon, Kecamatan Suranenggala, Kabupaten Cirebon.</p>
        <div class="hero-actions">
            <a href="{{ route('laporan.create') }}" class="btn-hero btn-fill"><i class="bi bi-chat-square-text"></i> Kirim Laporan</a>
            <a href="#lokasi" class="btn-hero" style="background:rgba(255,255,255,.1);color:#fff;border:1.5px solid rgba(255,255,255,.18);backdrop-filter:blur(6px)"><i class="bi bi-geo-alt"></i> Lihat Lokasi</a>
        </div>
        <div class="hero-stats">
            <div class="hero-stat">
                <h3>{{ \App\Models\Warga::count() }}</h3>
                <p>Total Warga Tercatat</p>
            </div>
            <div class="hero-stat">
                <h3>{{ \App\Models\KartuKeluarga::count() }}</h3>
                <p>Kartu Keluarga</p>
            </div>
            <div class="hero-stat">
                <h3>{{ $pengumuman->count() }}</h3>
                <p>Pengumuman Aktif</p>
            </div>
        </div>
    </div>
</section>

<!-- ═══ ABOUT ═══ -->
<section class="section" id="tentang">
    <div class="section-inner">
        <div class="about-grid">
            <div class="about-img fade-up">
                <img src="/img/hero-bg.png" alt="Desa Suranenggala Kulon">
            </div>
            <div class="about-text fade-up">
                <span class="section-tag">Tentang Desa</span>
                <h3>Desa Suranenggala Kulon</h3>
                <p>Desa Suranenggala Kulon terletak di Kecamatan Suranenggala, Kabupaten Cirebon, Provinsi Jawa Barat. Desa ini merupakan bagian dari wilayah pesisir utara Jawa yang memiliki potensi pertanian dan perikanan yang melimpah.</p>
                <p>Dengan semangat digitalisasi, Desa Suranenggala Kulon mengembangkan sistem informasi pendataan warga untuk meningkatkan pelayanan publik dan transparansi data kependudukan.</p>
                <div class="about-features">
                    <div class="about-feat"><i class="bi bi-shield-lock-fill"></i> Data Terenkripsi</div>
                    <div class="about-feat"><i class="bi bi-people-fill"></i> Pendataan Digital</div>
                    <div class="about-feat"><i class="bi bi-chat-dots-fill"></i> Laporan Online</div>
                    <div class="about-feat"><i class="bi bi-megaphone-fill"></i> Info Pengumuman</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ PETA LOKASI (GPS) ═══ -->
<section class="section map-section" id="lokasi">
    <div class="section-inner">
        <div class="section-title fade-up">
            <span class="section-tag">Lokasi</span>
            <h2>Lokasi Desa Suranenggala Kulon</h2>
            <p>Temukan lokasi desa kami di peta interaktif</p>
        </div>
        <div class="map-grid fade-up">
            <div class="map-container" id="map"></div>
            <div class="map-info">
                <h3><i class="bi bi-geo-alt-fill"></i> Alamat & Koordinat</h3>
                <ul class="map-detail">
                    <li>
                        <div class="dt-icon" style="background:#eff6ff;color:#2563eb"><i class="bi bi-building"></i></div>
                        <div><div class="dt-label">Desa</div><div class="dt-value">Suranenggala Kulon</div></div>
                    </li>
                    <li>
                        <div class="dt-icon" style="background:#f0fdf4;color:#16a34a"><i class="bi bi-signpost-split"></i></div>
                        <div><div class="dt-label">Kecamatan</div><div class="dt-value">Suranenggala</div></div>
                    </li>
                    <li>
                        <div class="dt-icon" style="background:#fef3c7;color:#d97706"><i class="bi bi-geo"></i></div>
                        <div><div class="dt-label">Kabupaten / Kota</div><div class="dt-value">Kabupaten Cirebon</div></div>
                    </li>
                    <li>
                        <div class="dt-icon" style="background:#fce7f3;color:#db2777"><i class="bi bi-map"></i></div>
                        <div><div class="dt-label">Provinsi</div><div class="dt-value">Jawa Barat, Indonesia</div></div>
                    </li>
                    <li>
                        <div class="dt-icon" style="background:#ecfeff;color:#0891b2"><i class="bi bi-pin-map-fill"></i></div>
                        <div><div class="dt-label">Koordinat GPS</div><div class="dt-value">-6.6314°S, 108.5215°E</div></div>
                    </li>
                </ul>
                <a href="https://maps.app.goo.gl/f1oPWCsrWmjyoGQNA" target="_blank" class="map-btn">
                    <i class="bi bi-box-arrow-up-right"></i> Buka di Google Maps
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ═══ PENGUMUMAN ═══ -->
<section class="section section-alt" id="pengumuman">
    <div class="section-inner">
        <div class="section-title fade-up">
            <span class="section-tag">Informasi</span>
            <h2>Pengumuman Desa</h2>
            <p>Informasi dan pengumuman terkini dari Pemerintah Desa Suranenggala Kulon</p>
        </div>
        @if($pengumuman->count() > 0)
        <div class="ann-grid">
            @foreach($pengumuman as $p)
            <div class="ann-card fade-up">
                <span class="ann-badge {{ strtolower($p->kategori) }}">{{ $p->kategori }}</span>
                <h4>{{ $p->judul }}</h4>
                <p>{{ strip_tags($p->isi) }}</p>
                <div class="ann-meta">
                    <i class="bi bi-calendar3"></i> {{ $p->created_at->format('d M Y') }}
                    · <i class="bi bi-person"></i> {{ $p->user->nama ?? 'Admin' }}
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="ann-empty fade-up">
            <i class="bi bi-megaphone" style="font-size: 40px; opacity: .3;"></i>
            <h4 style="margin-top: 12px; font-weight: 600;">Belum ada pengumuman</h4>
            <p style="font-size: 13px;">Pengumuman dari desa akan tampil di sini.</p>
        </div>
        @endif
    </div>
</section>

<!-- ═══ LAYANAN ═══ -->
<section class="section" id="layanan">
    <div class="section-inner">
        <div class="section-title fade-up">
            <span class="section-tag">Layanan</span>
            <h2>Layanan Desa Digital</h2>
            <p>Akses layanan Desa Suranenggala Kulon secara online</p>
        </div>
        <div class="svc-grid">
            <div class="svc-card fade-up">
                <div class="svc-icon" style="background:#eff6ff;color:#2563eb"><i class="bi bi-people-fill"></i></div>
                <h4>Data Warga</h4>
                <p>Pendataan lengkap warga desa yang terenkripsi dan terverifikasi secara digital.</p>
            </div>
            <div class="svc-card fade-up">
                <div class="svc-icon" style="background:#f0fdf4;color:#16a34a"><i class="bi bi-card-heading"></i></div>
                <h4>Kartu Keluarga</h4>
                <p>Pengelolaan data kartu keluarga dan anggota keluarga secara terpusat.</p>
            </div>
            <div class="svc-card fade-up">
                <div class="svc-icon" style="background:#fef3c7;color:#d97706"><i class="bi bi-chat-square-text-fill"></i></div>
                <h4>Laporan Warga</h4>
                <p>Sampaikan aspirasi, keluhan, atau laporan langsung ke perangkat desa via WhatsApp.</p>
            </div>
            <div class="svc-card fade-up">
                <div class="svc-icon" style="background:#fce7f3;color:#db2777"><i class="bi bi-megaphone-fill"></i></div>
                <h4>Pengumuman</h4>
                <p>Informasi terkini tentang kegiatan, layanan, dan berita desa Suranenggala Kulon.</p>
            </div>
        </div>
    </div>
</section>

<!-- ═══ CTA ═══ -->
<section class="cta-section">
    <div class="cta-inner fade-up">
        <h2>Punya Keluhan atau Laporan?</h2>
        <p>Sampaikan langsung ke perangkat Desa Suranenggala Kulon. Laporan Anda akan terintegrasi dengan WhatsApp untuk respon cepat.</p>
        <div class="cta-btns">
            <a href="{{ route('laporan.create') }}" class="btn-wa"><i class="bi bi-whatsapp"></i> Kirim Laporan via WhatsApp</a>
        </div>
    </div>
</section>

<!-- ═══ FOOTER ═══ -->
<footer class="footer">
    <div class="footer-inner">
        <div class="footer-grid">
            <div class="footer-brand">
                <h4>Desa Suranenggala Kulon</h4>
                <p>Kecamatan Suranenggala, Kabupaten Cirebon,<br>Provinsi Jawa Barat, Indonesia<br><br>Sistem informasi pendataan warga dan layanan publik digital desa.</p>
            </div>
            <div>
                <h5>Menu</h5>
                <div class="footer-links">
                    <a href="#tentang">Tentang Desa</a>
                    <a href="#lokasi">Lokasi Desa</a>
                    <a href="#pengumuman">Pengumuman</a>
                    <a href="{{ route('laporan.create') }}">Buat Laporan</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <span>&copy; {{ date('Y') }} Data Warga Desa Suranenggala Kulon</span>
            <a href="{{ route('login') }}" class="footer-login"><i class="bi bi-lock"></i> Perangkat Desa</a>
        </div>
    </div>
</footer>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
// Navbar scroll effect
window.addEventListener('scroll', () => {
    document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 40);
});

// Fade-up animation on scroll
const obs = new IntersectionObserver((entries) => {
    entries.forEach(e => { if(e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.1 });
document.querySelectorAll('.fade-up').forEach(el => obs.observe(el));

// ═══ LEAFLET MAP ═══
// Koordinat Kantor Kuwu Desa Suranenggala Kulon
const lat = -6.6313541;
const lng = 108.5214759;

const map = L.map('map', {
    scrollWheelZoom: false,
    zoomControl: true,
}).setView([lat, lng], 15);

// OpenStreetMap tile layer
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    maxZoom: 19,
}).addTo(map);

// Custom marker icon
const icon = L.divIcon({
    html: '<div style="background:var(--accent,#e8b931);width:40px;height:40px;border-radius:50% 50% 50% 0;transform:rotate(-45deg);display:flex;align-items:center;justify-content:center;box-shadow:0 4px 16px rgba(0,0,0,.25);border:3px solid #fff"><span style="transform:rotate(45deg);font-weight:900;font-size:14px;color:#1e3a5f">SK</span></div>',
    className: '',
    iconSize: [40, 40],
    iconAnchor: [20, 40],
    popupAnchor: [0, -42],
});

// Add marker
L.marker([lat, lng], { icon })
    .addTo(map)
    .bindPopup(`
        <strong style="font-size:14px">Desa Suranenggala Kulon</strong><br>
        <span style="color:#64748b;font-size:12px">Kec. Suranenggala, Kab. Cirebon<br>Jawa Barat, Indonesia</span><br><br>
        <a href="https://maps.app.goo.gl/f1oPWCsrWmjyoGQNA" target="_blank" style="color:#2563eb;font-weight:600;font-size:12px">
            Buka di Google Maps →
        </a>
    `)
    .openPopup();

// Area boundary (approximate village boundary)
L.circle([lat, lng], {
    radius: 800,
    color: '#1e3a5f',
    fillColor: '#1e3a5f',
    fillOpacity: 0.06,
    weight: 2,
    dashArray: '6 4',
}).addTo(map);
</script>
</body>
</html>
