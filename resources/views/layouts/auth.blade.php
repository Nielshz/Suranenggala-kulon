<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login — Desa Suranenggala Kulon</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 40%, #312e81 100%);
            display: flex; align-items: center; justify-content: center;
            -webkit-font-smoothing: antialiased;
            position: relative; overflow: hidden;
            padding: 20px;
        }
        body::before {
            content: ''; position: absolute; top: -15%; right: -8%;
            width: 400px; height: 400px; background: rgba(99,102,241,.06);
            border-radius: 50%; animation: drift 18s infinite ease-in-out;
        }
        body::after {
            content: ''; position: absolute; bottom: -12%; left: -5%;
            width: 350px; height: 350px; background: rgba(139,92,246,.05);
            border-radius: 50%; animation: drift 14s infinite ease-in-out reverse;
        }
        @keyframes drift {
            0%, 100% { transform: translate(0, 0); }
            33% { transform: translate(20px, -20px); }
            66% { transform: translate(-15px, 15px); }
        }

        .login-card {
            width: 100%; max-width: 400px;
            background: rgba(255,255,255,.97); backdrop-filter: blur(20px);
            border-radius: 20px; box-shadow: 0 20px 50px rgba(0,0,0,.25);
            padding: 40px 36px; animation: rise .5s ease forwards;
            border: 1px solid rgba(255,255,255,.15); position: relative; z-index: 1;
        }
        @keyframes rise { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        .brand { text-align: center; margin-bottom: 32px; }
        .brand-icon {
            display: inline-flex; align-items: center; justify-content: center;
            width: 52px; height: 52px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 14px; color: #fff; font-size: 22px; margin-bottom: 14px;
            box-shadow: 0 6px 20px rgba(99,102,241,.3);
        }
        .brand h1 { font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px; letter-spacing: -.5px; }
        .brand p { font-size: 13px; color: #64748b; margin: 0; }

        .field { position: relative; margin-bottom: 14px; }
        .field .ico {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            color: #94a3b8; font-size: 15px; z-index: 2; transition: color .2s;
        }
        .field input {
            width: 100%; padding: 12px 14px 12px 42px; font-size: 13.5px;
            border: 1.5px solid #e2e8f0; border-radius: 10px;
            background: #f8fafc; color: #0f172a; outline: none;
            font-family: 'Plus Jakarta Sans', sans-serif; transition: all .2s;
        }
        .field input:focus { border-color: #6366f1; background: #fff; box-shadow: 0 0 0 3px rgba(99,102,241,.08); }
        .field input:focus ~ .ico { color: #6366f1; }
        .field input::placeholder { color: #94a3b8; }

        .btn-login {
            width: 100%; padding: 12px; font-size: 14px; font-weight: 700;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: #fff; border: none; border-radius: 10px; cursor: pointer;
            font-family: 'Plus Jakarta Sans', sans-serif; transition: all .2s; margin-top: 4px;
        }
        .btn-login:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(99,102,241,.3); }

        .alert-err {
            background: #fef2f2; color: #991b1b; padding: 10px 14px;
            border-radius: 8px; font-size: 12.5px; font-weight: 500; margin-bottom: 14px;
            display: flex; align-items: center; gap: 6px; border: 1px solid #fecaca;
        }

        .sec-tags { display: flex; gap: 5px; justify-content: center; margin-top: 18px; flex-wrap: wrap; }
        .sec-tag {
            display: inline-flex; align-items: center; gap: 3px;
            padding: 3px 9px; border-radius: 50px; font-size: 10px; font-weight: 600;
            background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0;
        }

        .foot { text-align: center; margin-top: 24px; font-size: 11px; color: #94a3b8; }

        @media (max-width: 440px) {
            .login-card { padding: 32px 24px; border-radius: 16px; }
            .brand-icon { width: 44px; height: 44px; font-size: 18px; border-radius: 12px; }
            .brand h1 { font-size: 19px; }
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
