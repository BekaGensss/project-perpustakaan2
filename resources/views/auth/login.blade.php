<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>EL-KALA | Login Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #0f0c29;
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
        }

        /* LEFT PANEL */
        .left-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 40px;
            position: relative;
            overflow: hidden;
        }
        .left-panel::before {
            content: '';
            position: absolute;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(99,102,241,0.3) 0%, transparent 70%);
            top: -100px; left: -100px;
            border-radius: 50%;
        }
        .left-panel::after {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(20,184,166,0.2) 0%, transparent 70%);
            bottom: -80px; right: -80px;
            border-radius: 50%;
        }
        .brand-logo {
            display: flex; align-items: center; gap: 12px; margin-bottom: 40px; z-index: 1;
        }
        .brand-icon {
            width: 44px; height: 44px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .brand-icon i { color: #38bdf8; font-size: 20px; }
        .brand-name { font-family: 'Inter', sans-serif; font-weight: 800; font-size: 28px; letter-spacing: -1px; color: #ffffff; text-shadow: 0 2px 4px rgba(0,0,0,0.2); line-height: 1.1; }
        .brand-name span { color: #38bdf8; }

        .hero-text { text-align: center; z-index: 1; }
        .hero-text h1 { color: white; font-size: 38px; font-weight: 700; line-height: 1.2; margin-bottom: 16px; }
        .hero-text h1 span { background: linear-gradient(135deg, #6366f1, #14b8a6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .hero-text p { color: rgba(255,255,255,0.6); font-size: 16px; line-height: 1.6; max-width: 360px; }

        .feature-list { margin-top: 40px; display: flex; flex-direction: column; gap: 16px; z-index: 1; width: 100%; max-width: 320px; }
        .feature-item { display: flex; align-items: center; gap: 12px; }
        .feature-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .feature-icon.purple { background: rgba(99,102,241,0.2); color: #818cf8; }
        .feature-icon.teal { background: rgba(20,184,166,0.2); color: #2dd4bf; }
        .feature-icon.amber { background: rgba(245,158,11,0.2); color: #fbbf24; }
        .feature-text { color: rgba(255,255,255,0.75); font-size: 14px; }

        /* RIGHT PANEL */
        .right-panel {
            width: 480px;
            min-height: 100vh;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 48px;
            box-shadow: -20px 0 60px rgba(0,0,0,0.3);
        }
        .form-header { width: 100%; margin-bottom: 36px; }
        .form-header h2 { font-size: 28px; font-weight: 700; color: #0f172a; margin-bottom: 8px; }
        .form-header p { color: #64748b; font-size: 15px; }

        .form-group { margin-bottom: 20px; }
        .form-group label {
            display: block;
            font-size: 13px; font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .input-wrap { position: relative; }
        .input-wrap i {
            position: absolute; left: 16px; top: 50%; transform: translateY(-50%);
            color: #9ca3af; font-size: 16px;
        }
        .input-wrap input {
            width: 100%;
            padding: 14px 16px 14px 46px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-family: 'Inter', sans-serif;
            font-size: 15px;
            color: #0f172a;
            transition: all 0.2s;
            outline: none;
            background: #f9fafb;
        }
        .input-wrap input:focus {
            border-color: #6366f1;
            background: white;
            box-shadow: 0 0 0 4px rgba(99,102,241,0.1);
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: white;
            border: none;
            border-radius: 12px;
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            box-shadow: 0 4px 15px rgba(99,102,241,0.4);
            margin-top: 28px;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99,102,241,0.5);
        }
        .btn-login:active { transform: translateY(0); }

        .divider { text-align: center; margin: 24px 0; position: relative; }
        .divider::before {
            content: '';
            position: absolute; left: 0; right: 0; top: 50%;
            height: 1px; background: #e5e7eb;
        }
        .divider span { background: white; padding: 0 12px; color: #9ca3af; font-size: 13px; position: relative; }

        .back-link { text-align: center; margin-top: 24px; }
        .back-link a { color: #6366f1; text-decoration: none; font-size: 14px; font-weight: 500; }
        .back-link a:hover { text-decoration: underline; }

        @media (max-width: 768px) {
            body { flex-direction: column; }
            .left-panel { padding: 40px 24px; min-height: 220px; }
            .hero-text h1 { font-size: 26px; }
            .right-panel { width: 100%; padding: 40px 24px; box-shadow: none; }
            .feature-list { display: none; }
        }
    </style>
</head>
<body>
    <!-- LEFT PANEL -->
    <div class="left-panel">
        <div class="brand-logo">
            <div class="brand-icon">
                <i class="fas fa-book-reader"></i>
            </div>
            <div class="brand-name">EL<span>KALA</span></div>
        </div>

        <div class="hero-text">
            <h1>E-Library: Katalog<br><span>Literasi Digital Anda</span></h1>
            <p>Platform pengelolaan koleksi buku, peminjaman, dan anggota secara digital dan efisien.</p>
        </div>

        <div class="feature-list">
            <div class="feature-item">
                <div class="feature-icon purple"><i class="fas fa-book-open"></i></div>
                <div class="feature-text">Kelola ribuan koleksi buku dengan mudah</div>
            </div>
            <div class="feature-item">
                <div class="feature-icon teal"><i class="fas fa-users"></i></div>
                <div class="feature-text">Manajemen anggota dan transaksi terintegrasi</div>
            </div>
            <div class="feature-item">
                <div class="feature-icon amber"><i class="fas fa-chart-bar"></i></div>
                <div class="feature-text">Laporan peminjaman dan pengembalian real-time</div>
            </div>
        </div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="right-panel">
        <div class="form-header">
            <h2>Selamat Datang 👋</h2>
            <p>Masuk ke panel admin untuk mengelola sistem perpustakaan.</p>
        </div>

        <form method="POST" action="{{ route('login') }}" style="width:100%">
            @csrf
            <div class="form-group">
                <label>Email Address</label>
                <div class="input-wrap">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" id="email" placeholder="admin@elibrary.com" required autocomplete="email">
                </div>
            </div>
            <div class="form-group">
                <label>Password</label>
                <div class="input-wrap">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="password" placeholder="••••••••" required autocomplete="current-password">
                </div>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Masuk ke Dashboard
            </button>
        </form>

        <div class="divider"><span>atau</span></div>

        <div class="back-link">
            <a href="{{ url('/') }}"><i class="fas fa-arrow-left"></i> Kembali ke Katalog Buku</a>
        </div>
    </div>

    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <script>
        toastr.options = {
            "closeButton": true, "progressBar": true,
            "positionClass": "toast-top-right", "timeOut": "5000"
        }
        @if (Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif
        @if (Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif
    </script>
</body>
</html>