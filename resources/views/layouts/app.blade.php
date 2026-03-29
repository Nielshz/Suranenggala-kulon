<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Data Warga') — Desa Suranenggala Kulon</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-w: 260px;
            --nav-h: 60px;
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --primary-light: #eef2ff;
            --accent: #8b5cf6;
            --bg: #f8fafc;
            --surface: #ffffff;
            --surface-hover: #f8fafc;
            --text: #0f172a;
            --text-2: #475569;
            --text-3: #94a3b8;
            --border: #e2e8f0;
            --border-light: #f1f5f9;
            --success: #10b981;
            --success-bg: #ecfdf5;
            --warning: #f59e0b;
            --warning-bg: #fffbeb;
            --danger: #ef4444;
            --danger-bg: #fef2f2;
            --info: #06b6d4;
            --info-bg: #ecfeff;
            --r: 10px;
            --r-lg: 16px;
            --shadow-xs: 0 1px 2px rgba(0,0,0,.04);
            --shadow: 0 1px 3px rgba(0,0,0,.06), 0 1px 2px rgba(0,0,0,.04);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,.07), 0 2px 4px -2px rgba(0,0,0,.05);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,.08), 0 4px 6px -4px rgba(0,0,0,.04);
            --ease: cubic-bezier(.4,0,.2,1);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg);
            color: var(--text);
            margin: 0;
            -webkit-font-smoothing: antialiased;
            font-size: 14px;
            line-height: 1.6;
        }

        /* ═══════════ SIDEBAR ═══════════ */
        .sidebar {
            position: fixed; top: 0; left: 0;
            width: var(--sidebar-w); height: 100vh;
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            z-index: 1040; overflow-y: auto;
            transition: transform .3s var(--ease);
            border-right: 1px solid rgba(255,255,255,.04);
        }
        .sidebar::-webkit-scrollbar { width: 3px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,.08); border-radius: 10px; }

        .sidebar-brand {
            display: flex; align-items: center; gap: 12px;
            padding: 20px 20px 18px; text-decoration: none !important;
            border-bottom: 1px solid rgba(255,255,255,.06);
        }
        .brand-icon {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 11px; font-weight: 900; flex-shrink: 0;
        }
        .brand-icon::after { content: 'SK'; }
        .brand-text h5 { color: #fff; font-weight: 800; margin: 0; font-size: 15px; letter-spacing: -.3px; }
        .brand-text small { color: var(--text-3); font-size: 10.5px; letter-spacing: .3px; }

        .nav-label {
            padding: 20px 20px 6px; color: rgba(148,163,184,.6);
            font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px;
        }
        .nav-sep { border-top: 1px solid rgba(255,255,255,.04); margin: 6px 16px; }

        .nav-list { list-style: none; padding: 0 10px; margin: 0; }
        .nav-list li { margin: 1px 0; }
        .nav-list li a {
            display: flex; align-items: center; gap: 11px;
            padding: 9px 14px; color: rgba(148,163,184,.85); font-size: 13px; font-weight: 500;
            border-radius: 8px; text-decoration: none; transition: all .2s var(--ease);
        }
        .nav-list li a i { font-size: 15px; width: 18px; text-align: center; opacity: .65; transition: all .2s; }
        .nav-list li a:hover { color: #e2e8f0; background: rgba(255,255,255,.05); }
        .nav-list li a:hover i { opacity: 1; color: var(--primary); }
        .nav-list li.active a {
            color: #fff; background: rgba(99,102,241,.12);
            box-shadow: inset 3px 0 0 var(--primary);
        }
        .nav-list li.active a i { color: var(--primary); opacity: 1; }

        /* ═══════════ TOP NAV ═══════════ */
        .topnav {
            position: fixed; top: 0; left: var(--sidebar-w); right: 0;
            height: var(--nav-h); background: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 24px; z-index: 1030;
        }
        .topnav-left { display: flex; align-items: center; gap: 12px; }
        .btn-toggle { display: none; background: none; border: none; font-size: 20px; color: var(--text-2); cursor: pointer; padding: 4px; }
        .topnav-right { display: flex; align-items: center; gap: 14px; }
        .user-pill {
            display: flex; align-items: center; gap: 10px;
            padding: 5px 14px 5px 5px; border-radius: 50px;
            background: var(--bg); border: 1px solid var(--border);
        }
        .avatar {
            width: 32px; height: 32px; border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: 12px; flex-shrink: 0;
        }
        .user-pill .name { font-weight: 600; font-size: 13px; color: var(--text); }
        .user-pill .role { font-size: 10.5px; color: var(--text-3); }
        .btn-out {
            padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 600;
            background: var(--danger-bg); color: var(--danger); border: 1px solid #fecaca;
            cursor: pointer; transition: all .2s;
        }
        .btn-out:hover { background: var(--danger); color: #fff; border-color: var(--danger); }

        /* ═══════════ MAIN ═══════════ */
        .main { margin-left: var(--sidebar-w); padding-top: var(--nav-h); min-height: 100vh; }
        .content { padding: 24px; max-width: 1400px; }

        /* Page Header */
        .pg-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 20px; flex-wrap: wrap; gap: 12px;
        }
        .pg-header h1 {
            font-size: 20px; font-weight: 700; margin: 0;
            display: flex; align-items: center; gap: 8px; color: var(--text);
        }
        .pg-header h1 i { color: var(--primary); font-size: 20px; }

        /* ═══════════ CARDS ═══════════ */
        .card {
            border: 1px solid var(--border); border-radius: var(--r-lg);
            box-shadow: var(--shadow-xs); transition: all .2s var(--ease);
            overflow: hidden; background: var(--surface);
        }
        .card:hover { box-shadow: var(--shadow-md); }

        /* Stat */
        .stat {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: var(--r-lg); padding: 20px;
            transition: all .25s var(--ease); position: relative; overflow: hidden;
        }
        .stat:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); border-color: transparent; }
        .stat-icon {
            width: 44px; height: 44px; border-radius: var(--r);
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; margin-bottom: 14px;
        }
        .stat-icon.i1 { background: var(--primary-light); color: var(--primary); }
        .stat-icon.i2 { background: var(--success-bg); color: var(--success); }
        .stat-icon.i3 { background: var(--warning-bg); color: var(--warning); }
        .stat-icon.i4 { background: var(--info-bg); color: var(--info); }
        .stat-val { font-size: 28px; font-weight: 800; line-height: 1; margin-bottom: 4px; letter-spacing: -.5px; }
        .stat-lbl { font-size: 12px; font-weight: 600; color: var(--text-3); text-transform: uppercase; letter-spacing: .5px; }
        .stat-extra { margin-top: 12px; padding-top: 12px; border-top: 1px solid var(--border-light); font-size: 12px; color: var(--text-2); }
        .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--r); padding: 14px 18px; display: flex; align-items: center; gap: 14px; }
        .stat-card .stat-num { font-size: 22px; font-weight: 800; line-height: 1; }
        .stat-card .stat-label { font-size: 11px; font-weight: 600; color: var(--text-3); text-transform: uppercase; letter-spacing: .3px; }
        .pill { display: inline-flex; align-items: center; gap: 3px; padding: 2px 8px; border-radius: 50px; font-size: 11px; font-weight: 600; }
        .pill-m { background: #dbeafe; color: #2563eb; }
        .pill-f { background: #fce7f3; color: #db2777; }

        /* ═══════════ TABLE ═══════════ */
        .tbl-wrap {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: var(--r-lg); overflow: hidden;
        }
        .tbl-wrap .table { margin: 0; }
        .table thead th {
            background: var(--bg); border-bottom: 1px solid var(--border);
            color: var(--text-3); font-weight: 600; font-size: 11px;
            text-transform: uppercase; letter-spacing: .5px; padding: 12px 14px;
            white-space: nowrap; position: sticky; top: 0;
        }
        .table tbody td {
            padding: 10px 14px; vertical-align: middle; font-size: 13px;
            border-top: 1px solid var(--border-light); color: var(--text);
        }
        .table-hover tbody tr:hover { background: var(--primary-light) !important; }
        .table tbody tr { transition: background .15s; }
        .nik-code { font-family: 'JetBrains Mono', monospace; font-size: 12px; color: var(--primary); font-weight: 500; }

        /* ═══════════ ACTION BUTTONS (horizontal) ═══════════ */
        .act-group {
            display: inline-flex; align-items: center; gap: 4px; flex-wrap: nowrap;
        }
        .act-btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 4px;
            padding: 5px 10px; border-radius: 6px; font-size: 11.5px; font-weight: 600;
            border: 1px solid var(--border); background: var(--surface);
            color: var(--text-2); cursor: pointer; transition: all .15s var(--ease);
            text-decoration: none; white-space: nowrap; line-height: 1;
        }
        .act-btn i { font-size: 12px; }
        .act-btn:hover { border-color: var(--primary); color: var(--primary); background: var(--primary-light); }
        .act-btn.act-view { color: var(--info); border-color: #b2f5ea; background: var(--info-bg); }
        .act-btn.act-view:hover { background: var(--info); color: #fff; border-color: var(--info); }
        .act-btn.act-edit { color: var(--primary); border-color: #c7d2fe; background: var(--primary-light); }
        .act-btn.act-edit:hover { background: var(--primary); color: #fff; border-color: var(--primary); }
        .act-btn.act-danger { color: var(--danger); border-color: #fecaca; background: var(--danger-bg); }
        .act-btn.act-danger:hover { background: var(--danger); color: #fff; border-color: var(--danger); }
        .act-btn.act-warn { color: var(--warning); border-color: #fde68a; background: var(--warning-bg); }
        .act-btn.act-warn:hover { background: var(--warning); color: #fff; border-color: var(--warning); }

        /* ═══════════ BUTTONS ═══════════ */
        .btn { border-radius: 8px; font-weight: 600; font-size: 13px; padding: 8px 18px; transition: all .2s var(--ease); border: none; }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: var(--primary-hover); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(99,102,241,.25); }
        .btn-outline-secondary { border: 1px solid var(--border); color: var(--text-2); background: var(--surface); }
        .btn-outline-secondary:hover { background: var(--bg); border-color: var(--text-3); }
        .btn-success { background: var(--success); }
        .btn-danger { background: var(--danger); }

        /* ═══════════ FORMS ═══════════ */
        .form-control, .form-select {
            border: 1px solid var(--border); border-radius: 8px;
            padding: 9px 13px; font-size: 13px; transition: all .2s;
            background: var(--surface); color: var(--text);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary); box-shadow: 0 0 0 3px rgba(99,102,241,.08);
        }
        .form-label { font-weight: 600; font-size: 12.5px; color: var(--text-2); margin-bottom: 5px; }

        /* ═══════════ BADGES ═══════════ */
        .badge { font-weight: 600; padding: 4px 10px; border-radius: 50px; font-size: 11px; letter-spacing: .2px; }
        .badge-verified { background: var(--success-bg); color: #065f46; border: 1px solid #a7f3d0; }
        .badge-unverified { background: var(--danger-bg); color: #991b1b; border: 1px solid #fecaca; }

        /* ═══════════ ALERTS ═══════════ */
        .alert {
            border: none; border-radius: var(--r); font-weight: 500; font-size: 13px;
            display: flex; align-items: center; gap: 8px;
        }
        .alert-success { background: var(--success-bg); color: #065f46; border: 1px solid #a7f3d0; }
        .alert-danger { background: var(--danger-bg); color: #991b1b; border: 1px solid #fecaca; }

        /* ═══════════ WELCOME ═══════════ */
        .welcome {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: var(--r-lg); padding: 24px 28px; margin-bottom: 24px;
            color: #fff; position: relative; overflow: hidden;
        }
        .welcome::after {
            content: ''; position: absolute; top: -60%; right: -8%;
            width: 250px; height: 250px; background: rgba(255,255,255,.06);
            border-radius: 50%; pointer-events: none;
        }
        .welcome h2 { color: #fff; font-size: 18px; font-weight: 700; margin: 0 0 4px; }
        .welcome p { color: rgba(255,255,255,.8); font-size: 13px; margin: 0; }

        /* Section cards */
        .sec { background: var(--surface); border: 1px solid var(--border); border-radius: var(--r-lg); margin-bottom: 20px; overflow: hidden; }
        .sec-head {
            padding: 14px 20px; border-bottom: 1px solid var(--border-light);
            display: flex; align-items: center; gap: 8px;
        }
        .sec-head h5 { margin: 0; font-weight: 700; font-size: 14px; }
        .sec-body { padding: 20px; }

        /* DataTables */
        .dataTables_wrapper { padding: 14px; }
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid var(--border); border-radius: 8px; padding: 6px 12px;
            font-size: 13px; outline: none;
        }
        .dataTables_wrapper .dataTables_filter input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(99,102,241,.08); }
        .dataTables_wrapper .dataTables_length select { border: 1px solid var(--border); border-radius: 6px; padding: 4px 8px; font-size: 13px; }
        .dataTables_wrapper .dataTables_info { font-size: 12px; color: var(--text-3); }
        .dataTables_wrapper .dataTables_paginate { font-size: 13px; }
        .page-link { border-radius: 6px !important; margin: 0 1px; font-size: 13px; }
        .page-item.active .page-link { background: var(--primary); border-color: var(--primary); }

        /* Footer */
        .app-footer { padding: 16px 0; margin-top: 32px; border-top: 1px solid var(--border-light); text-align: center; color: var(--text-3); font-size: 12px; }

        /* Animations */
        @keyframes fadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
        .anim { animation: fadeUp .35s var(--ease) forwards; }
        .d1 { animation-delay: .05s; opacity: 0; }
        .d2 { animation-delay: .1s; opacity: 0; }
        .d3 { animation-delay: .15s; opacity: 0; }
        .d4 { animation-delay: .2s; opacity: 0; }

        /* ═══════════ RESPONSIVE ═══════════ */
        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); box-shadow: 4px 0 20px rgba(0,0,0,.3); }
            .topnav { left: 0; }
            .main { margin-left: 0; }
            .btn-toggle { display: flex; }
            .overlay { position: fixed; inset: 0; background: rgba(0,0,0,.4); z-index: 1035; display: none; backdrop-filter: blur(2px); }
            .overlay.show { display: block; }
            .content { padding: 16px; }

            /* Responsive table: hide less critical columns on small screens */
            .tbl-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
            .hide-sm { display: none !important; }
        }

        @media (max-width: 575px) {
            .pg-header { flex-direction: column; align-items: flex-start; }
            .pg-header .btn { width: 100%; text-align: center; }
            .topnav { padding: 0 12px; }
            .user-pill .name, .user-pill .role { display: none; }
            .stat-val { font-size: 24px; }

            /* Stack action buttons vertically on very small screens */
            .act-group { flex-direction: column; gap: 3px; }
            .act-btn { width: 100%; justify-content: center; padding: 6px 8px; }
        }

        @media print {
            .sidebar, .topnav, .act-group, .btn, .app-footer { display: none !important; }
            .main { margin-left: 0 !important; padding-top: 0 !important; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <aside class="sidebar" id="sidebar">
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            <div class="brand-icon"></div>
            <div class="brand-text">
                <h5>Desa Suranenggala Kulon</h5>
                <small>Data Warga</small>
            </div>
        </a>

        <div class="nav-label">Menu Utama</div>
        <ul class="nav-list">
            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}"><i class="bi bi-grid-1x2-fill"></i> Dashboard</a>
            </li>
        </ul>

        <div class="nav-sep"></div>
        <div class="nav-label">Data Master</div>
        <ul class="nav-list">
            <li class="{{ request()->routeIs('warga.*') ? 'active' : '' }}">
                <a href="{{ route('warga.index') }}"><i class="bi bi-people-fill"></i> Data Warga</a>
            </li>
            <li class="{{ request()->routeIs('kartu-keluarga.*') ? 'active' : '' }}">
                <a href="{{ route('kartu-keluarga.index') }}"><i class="bi bi-person-vcard-fill"></i> Kartu Keluarga</a>
            </li>
            <li class="{{ request()->routeIs('mutasi.*') ? 'active' : '' }}">
                <a href="{{ route('mutasi.index') }}"><i class="bi bi-arrow-left-right"></i> Data Mutasi</a>
            </li>
        </ul>

        <div class="nav-sep"></div>
        <div class="nav-label">Media</div>
        <ul class="nav-list">
            <li class="{{ request()->routeIs('galeri.*') ? 'active' : '' }}">
                <a href="{{ route('galeri.index') }}"><i class="bi bi-images"></i> Galeri</a>
            </li>
        </ul>

        @if(auth()->user()->status !== 'RW')
        <div class="nav-sep"></div>
        <div class="nav-label">Layanan</div>
        <ul class="nav-list">
            <li class="{{ request()->routeIs('pengumuman.*') ? 'active' : '' }}">
                <a href="{{ route('pengumuman.index') }}"><i class="bi bi-megaphone-fill"></i> Pengumuman</a>
            </li>
            <li class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                <a href="{{ route('laporan.index') }}"><i class="bi bi-chat-square-text-fill"></i> Laporan Warga
                @php $laporanMasuk = \App\Models\Laporan::where('status','Masuk')->count(); @endphp
                @if($laporanMasuk > 0)<span class="badge bg-danger" style="font-size:9px;padding:2px 6px;border-radius:50px;margin-left:auto">{{ $laporanMasuk }}</span>@endif
                </a>
            </li>
        </ul>

        <div class="nav-sep"></div>
        <div class="nav-label">Administrasi</div>
        <ul class="nav-list">
            <li class="{{ request()->routeIs('user.*') ? 'active' : '' }}">
                <a href="{{ route('user.index') }}"><i class="bi bi-person-gear"></i> Kelola User</a>
            </li>
        </ul>
        @endif
    </aside>

    <div class="overlay" id="overlay" onclick="toggleSB()"></div>

    <header class="topnav">
        <div class="topnav-left">
            <button class="btn-toggle" onclick="toggleSB()"><i class="bi bi-list"></i></button>
            <a href="{{ url('/') }}" target="_blank" style="font-size:12px; font-weight:600; color:var(--text-2); background:var(--bg); padding:6px 12px; border-radius:8px; display:inline-flex; align-items:center; gap:6px; text-decoration:none; border:1px solid var(--border); margin-left: 10px; transition:all .2s;"><i class="bi bi-globe"></i> Buka Website Desa</a>
        </div>
        <div class="topnav-right">
            <div class="user-pill">
                <div class="avatar">{{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}</div>
                <div>
                    <div class="name">{{ auth()->user()->nama }}</div>
                    <div class="role">{{ auth()->user()->status }}</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                @csrf
                <button type="submit" class="btn-out"><i class="bi bi-box-arrow-right"></i> Keluar</button>
            </form>
        </div>
    </header>

    <main class="main">
        <div class="content">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div><i class="bi bi-exclamation-triangle-fill"></i> <ul class="mb-0 d-inline">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @yield('content')

            <footer class="app-footer">&copy; {{ date('Y') }} <strong>Desa Suranenggala Kulon</strong> — Sistem Informasi Data Warga</footer>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        function toggleSB() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('overlay').classList.toggle('show');
        }
        $(function() {
            $('.data-table').DataTable({
                responsive: true,
                language: {
                    search: '<i class="bi bi-search"></i>', searchPlaceholder: 'Cari data...',
                    lengthMenu: 'Tampilkan _MENU_',
                    info: '_START_–_END_ dari _TOTAL_',
                    infoEmpty: 'Tidak ada data', infoFiltered: '(dari _MAX_)',
                    zeroRecords: '<div class="text-center py-4 text-muted"><i class="bi bi-inbox" style="font-size:24px"></i><br>Data tidak ditemukan</div>',
                    paginate: { first: '«', last: '»', next: '›', previous: '‹' }
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
