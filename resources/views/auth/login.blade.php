@extends('layouts.auth')

@section('content')
<div class="login-card">
    <div class="brand">
        <div class="brand-icon" style="font-weight:900;font-size:16px">SK</div>
        <h1>Desa Suranenggala Kulon</h1>
        <p>Sistem Data Warga · Kec. Suranenggala, Kab. Cirebon</p>
    </div>

    @if(session('error'))
    <div class="alert-err"><i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ url('/login') }}">
        @csrf
        <div class="field">
            <input type="text" name="username" placeholder="Username" autofocus required value="{{ old('username') }}">
            <i class="bi bi-person ico"></i>
        </div>
        <div class="field">
            <input type="password" name="password" placeholder="Password" required>
            <i class="bi bi-lock ico"></i>
        </div>
        <button type="submit" class="btn-login"><i class="bi bi-box-arrow-in-right"></i> Masuk</button>
    </form>

    <div class="sec-tags">
        <span class="sec-tag"><i class="bi bi-shield-lock-fill"></i> Argon2id</span>
        <span class="sec-tag"><i class="bi bi-fingerprint"></i> HMAC-SHA256</span>
        <span class="sec-tag"><i class="bi bi-file-earmark-lock2"></i> SHA-256</span>
    </div>

    <div class="foot">&copy; {{ date('Y') }} Desa Suranenggala Kulon</div>
</div>
@endsection
