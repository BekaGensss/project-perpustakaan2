@extends('member.layout.main')

@section('content')
<style>
    /* CSS Khusus Landing Page - Light & Modern Theme */
    :root {
        --primary-blue: #1e1b4b;
        --accent-blue: #38bdf8;
        --indigo-accent: #6366f1;
        --bg-light: #ffffff;
        --bg-subtle: #f8fafc;
        --text-dark: #0f172a;
        --text-muted: #475569;
        --border-color: #e2e8f0;
    }

    body {
        background-color: var(--bg-light);
    }

    /* Hero Section - Tetap Biru Gelap agar berkesan premium */
    .hero-section {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
        color: white;
        padding: 100px 0 140px;
        position: relative;
        overflow: hidden;
    }
    .hero-section::before {
        content: ''; position: absolute; width: 600px; height: 600px;
        background: radial-gradient(circle, rgba(99,102,241,0.15) 0%, transparent 60%);
        top: -200px; left: -200px; border-radius: 50%;
    }
    .hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
    }
    .hero-title {
        font-size: 56px;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 24px;
    }
    .hero-title span {
        background: linear-gradient(135deg, #38bdf8, #818cf8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .hero-desc {
        font-size: 18px;
        color: rgba(255,255,255,0.7);
        margin-bottom: 40px;
    }
    .btn-hero {
        background: var(--indigo-accent);
        color: white !important;
        padding: 16px 36px;
        font-weight: 600;
        border-radius: 50px;
        box-shadow: 0 10px 25px rgba(99,102,241,0.4);
        transition: all 0.3s;
    }
    .btn-hero:hover {
        transform: translateY(-4px);
    }
    
    /* Stats Section */
    .stats-section {
        margin-top: -60px;
        position: relative;
        z-index: 10;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        background: white;
        border-radius: 24px;
        padding: 40px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        border: 1px solid var(--border-color);
        max-width: 900px;
        margin: 0 auto;
    }
    .stat-value {
        font-size: 40px;
        font-weight: 800;
        color: var(--primary-blue);
    }
    .stat-label {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
    }

    /* Features Section - Back to Light */
    .features-section {
        padding: 100px 0 80px;
        background: var(--bg-light);
    }
    .section-title h2 {
        font-size: 32px;
        font-weight: 800;
        color: var(--primary-blue);
        margin-bottom: 16px;
    }
    .section-title p {
        color: var(--text-muted);
        max-width: 500px;
        margin: 0 auto;
    }
    .feature-card {
        background: white;
        padding: 40px 32px;
        border-radius: 24px;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        border: 1px solid var(--border-color);
        transition: all 0.3s;
        height: 100%;
        margin-bottom: 24px;
    }
    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        border-color: var(--indigo-accent);
    }
    .feature-card h3 {
        color: var(--primary-blue);
        font-weight: 700;
    }
    .feature-card p {
        color: var(--text-muted);
    }

    /* Section Alternating for separation */
    #panduan {
        background: var(--bg-subtle);
    }
    #faq {
        background: var(--bg-light);
    }
    #tentang {
        background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);
        color: white;
    }

    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: 1fr; }
    }

    #panduan, #faq, #tentang {
        scroll-margin-top: 80px;
    }
</style>

<!-- HERO SECTION -->
<section class="hero-section">
    <div class="container hero-content">
        <h1 class="hero-title">Katalog<br><span>Literasi Digital Anda</span></h1>
        <p class="hero-desc">Platform modern eksplorasi koleksi literatur berkualitas secara online. Temukan referensi terbaik, booking buku dengan cepat, pinjam tanpa ribet, dan kembangkan wawasan tanpa batas.</p>
        
        <a href="{{ route('member.index') }}" class="btn-hero">
            <i class="fas fa-compass"></i> Jelajahi Katalog Buku
        </a>
    </div>
</section>

<!-- STATS SECTION -->
@php
    $totalBuku = \App\Models\Buku::count();
    $totalKategori = \App\Models\Kategori::count();
    $totalMember = \App\Models\User::where('role_id', '2')->count();
@endphp
<section class="stats-section container">
    <div class="stats-grid">
        <div class="stat-item text-center">
            <div class="stat-value">{{ $totalBuku }}+</div>
            <div class="stat-label">Koleksi Buku</div>
        </div>
        <div class="stat-item text-center">
            <div class="stat-value">{{ $totalKategori }}</div>
            <div class="stat-label">Kategori</div>
        </div>
        <div class="stat-item text-center">
            <div class="stat-value">{{ $totalMember }}</div>
            <div class="stat-label">Anggota Aktif</div>
        </div>
    </div>
</section>

<!-- FEATURES SECTION -->
<section class="features-section">
    <div class="container">
        <div class="section-title text-center">
            <h2>Kenapa Memilih Kami?</h2>
            <p>Berbagai pengalaman literasi digital terbaru dirancang khusus demi kemudahan para pembaca perpustakaan modern.</p>
        </div>
        
        <div class="row mt-5">
            <div class="col-md-4">
                <div class="feature-card">
                    <div style="font-size: 40px; color: var(--accent-blue); margin-bottom: 20px;"><i class="fas fa-search"></i></div>
                    <h3>Eksplorasi Mudah</h3>
                    <p>Cari judul, kategori, atau penulis favorit Anda dalam hitungan detik dengan sistem pencarian modern berbasis katalog kami.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div style="font-size: 40px; color: var(--indigo-accent); margin-bottom: 20px;"><i class="fas fa-bookmark"></i></div>
                    <h3>Sistem Booking</h3>
                    <p>Amankan buku yang Anda incar dari jarak jauh sebelum pergi ke perpustakaan menggunakan fitur booking 1-klik digital kami.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div style="font-size: 40px; color: #10b981; margin-bottom: 20px;"><i class="fas fa-history"></i></div>
                    <h3>Rekam Riwayat</h3>
                    <p>Lacak seluruh buku yang sedang Anda baca beserta riwayat penyelesaian peminjaman secara transparan melalui profil pengguna Anda.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PANDUAN SECTION -->
<section id="panduan" class="features-section">
    <div class="container">
        <div class="section-title text-center">
            <h2>Panduan Peminjaman</h2>
            <p>Ikuti langkah mudah berikut untuk mulai menikmati koleksi literasi digital kami.</p>
        </div>
        <div class="row text-center mt-5">
            <div class="col-md-3">
                <div class="p-3">
                    <div style="width: 50px; height: 50px; line-height: 50px; border-radius: 50%; background: var(--indigo-accent); color: white; margin: 0 auto 20px; font-weight: bold;">1</div>
                    <h5 class="font-weight-bold" style="color: var(--primary-blue);">Daftar / Masuk</h5>
                    <p class="small" style="color: var(--text-muted);">Buat akun anggota untuk mulai melakukan transaksi.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3">
                    <div style="width: 50px; height: 50px; line-height: 50px; border-radius: 50%; background: var(--indigo-accent); color: white; margin: 0 auto 20px; font-weight: bold;">2</div>
                    <h5 class="font-weight-bold" style="color: var(--primary-blue);">Pilih & Booking</h5>
                    <p class="small" style="color: var(--text-muted);">Cari buku di katalog dan klik "Booking" untuk reservasi.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3">
                    <div style="width: 50px; height: 50px; line-height: 50px; border-radius: 50%; background: var(--indigo-accent); color: white; margin: 0 auto 20px; font-weight: bold;">3</div>
                    <h5 class="font-weight-bold" style="color: var(--primary-blue);">Konfirmasi</h5>
                    <p class="small" style="color: var(--text-muted);">Bawa bukti booking ke petugas perpustakaan terdekat.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3">
                    <div style="width: 50px; height: 50px; line-height: 50px; border-radius: 50%; background: var(--indigo-accent); color: white; margin: 0 auto 20px; font-weight: bold;">4</div>
                    <h5 class="font-weight-bold" style="color: var(--primary-blue);">Bawa Pulang</h5>
                    <p class="small" style="color: var(--text-muted);">Selamat membaca! Jangan lupa kembalikan tepat waktu.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ SECTION -->
<section id="faq" class="features-section">
    <div class="container">
        <div class="section-title text-center">
            <h2>Pertanyaan Umum (FAQ)</h2>
            <p>Punya pertanyaan? Mungkin jawaban yang Anda cari ada di bawah ini.</p>
        </div>
        <div class="row mt-5">
            <div class="col-md-6 mb-4">
                <div class="feature-card text-left" style="padding: 30px;">
                    <h4 class="h6 font-weight-bold" style="color: var(--primary-blue);"><i class="fas fa-info-circle text-primary mr-2"></i> Berapa lama masa pinjam buku?</h4>
                    <p class="small mb-0" style="color: var(--text-muted);">Masa peminjaman standar adalah 3 hari kerja sejak status "Pinjam" diaktifkan.</p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="feature-card text-left" style="padding: 30px;">
                    <h4 class="h6 font-weight-bold" style="color: var(--primary-blue);"><i class="fas fa-info-circle text-primary mr-2"></i> Berapa buku yang bisa di-booking?</h4>
                    <p class="small mb-0" style="color: var(--text-muted);">Setiap anggota dapat melakukan booking maksimal 3 buku secara bersamaan.</p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="feature-card text-left" style="padding: 30px;">
                    <h4 class="h6 font-weight-bold" style="color: var(--primary-blue);"><i class="fas fa-info-circle text-primary mr-2"></i> Bagaimana jika terlambat mengembalikan?</h4>
                    <p class="small mb-0" style="color: var(--text-muted);">Keterlambatan akan dikenakan denda sesuai ketentuan yang berlaku di perpustakaan fisik.</p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="feature-card text-left" style="padding: 30px;">
                    <h4 class="h6 font-weight-bold" style="color: var(--primary-blue);"><i class="fas fa-info-circle text-primary mr-2"></i> Apakah bisa ganti password?</h4>
                    <p class="small mb-0" style="color: var(--text-muted);">Tentu, Anda bisa mengubah password melalui menu Profil setelah berhasil login.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ABOUT SECTION -->
<section id="tentang" class="features-section" style="padding: 80px 0; background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%); color: white;">
    <div class="container text-center">
        <div style="max-width: 700px; margin: 0 auto;">
            <h2 class="hero-title" style="font-size: 32px; color: white !important;">Tentang <span>Layanan Kami</span></h2>
            <p class="hero-desc" style="font-size: 16px; color: rgba(255,255,255,0.8);">Inisiatif modern untuk memudahkan akses literatur. Kami percaya bahwa setiap orang berhak mendapatkan akses informasi yang cepat, mudah, dan terorganisir dengan baik melalui teknologi digital masa kini.</p>
            <div class="d-flex justify-content-center" style="gap: 40px; margin-top: 30px;">
                <div class="text-white text-center">
                    <i class="fas fa-shield-alt fa-2x mb-2" style="color: #38bdf8;"></i>
                    <p class="small font-weight-bold">Aman & Terpercaya</p>
                </div>
                <div class="text-white text-center">
                    <i class="fas fa-bolt fa-2x mb-2" style="color: #38bdf8;"></i>
                    <p class="small font-weight-bold">Layanan Cepat</p>
                </div>
                <div class="text-white text-center">
                    <i class="fas fa-heart fa-2x mb-2" style="color: #38bdf8;"></i>
                    <p class="small font-weight-bold">User Friendly</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
