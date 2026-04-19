@extends('admin.layout.main')
@section('title', 'Dashboard')
@section('content')

<div class="container-fluid">

    {{-- Welcome Banner --}}
    <div style="
        background: linear-gradient(135deg, #4338ca 0%, #6366f1 50%, #14b8a6 100%);
        border-radius: 20px;
        padding: 32px 36px;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
    ">
        <div style="position:absolute;top:-40px;right:-20px;width:200px;height:200px;background:rgba(255,255,255,0.06);border-radius:50%;"></div>
        <div style="position:absolute;bottom:-60px;right:80px;width:140px;height:140px;background:rgba(255,255,255,0.04);border-radius:50%;"></div>
        <div style="position:relative;z-index:1;">
            <div style="color:rgba(255,255,255,0.8); font-size:13px; font-weight:500; letter-spacing:0.5px; text-transform:uppercase; margin-bottom:6px;">
                <i class="fas fa-hand-wave"></i> Selamat datang kembali
            </div>
            <h2 style="color:white; font-weight:700; font-size:26px; margin:0 0 6px 0;">
                {{ Auth::user()->nama }} 👋
            </h2>
            <p style="color:rgba(255,255,255,0.7); margin:0; font-size:14px;">
                Ini adalah panel kontrol sistem perpustakaan digital Anda.
            </p>
        </div>
        
        {{-- Real Time Clock --}}
        <div style="position:absolute; top:32px; right:36px; text-align:right; z-index:2;">
            <div id="realtime-clock" style="color:white; font-size:32px; font-weight:700; font-variant-numeric: tabular-nums; line-height:1.1; letter-spacing:1px;">
                00:00:00
            </div>
            <div id="realtime-date" style="color:rgba(255,255,255,0.8); font-size:13px; font-weight:500; margin-bottom:8px;">
                Memuat tanggal...
            </div>
            <div id="live-indicator" style="display:none;">
                <span style="background:rgba(16,185,129,0.2);color:#10b981;padding:4px 10px;border-radius:20px;font-size:11px;font-weight:600;border:1px solid rgba(16,185,129,0.3);">
                    <i class="fas fa-circle" style="font-size:8px; margin-right:4px; animation: blinker 1s linear infinite;"></i> Live Update
                </span>
            </div>
        </div>
    </div>
    
    <style>
        @keyframes blinker {
            50% { opacity: 0; }
        }
    </style>

    {{-- Stats Row --}}
    <div class="row" style="margin-bottom: 24px;">

        {{-- Stat: Total Buku --}}
        <div class="col-lg-3 col-md-6 col-sm-6 col-12" style="margin-bottom:16px;">
            <div class="info-box" style="background:white;">
                <span class="info-box-icon" style="background:linear-gradient(135deg,#6366f1,#4338ca); height:auto; padding:20px 0;">
                    <i class="fas fa-book" style="font-size:26px;"></i>
                </span>
                <div class="info-box-content" style="display:flex;flex-direction:column;justify-content:center;padding:16px 20px;">
                    <span style="font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:0.5px;">Total Buku</span>
                    <span id="stat-total-buku" style="font-size:28px;font-weight:700;color:#0f172a;line-height:1.2;">
                        {{ \App\Models\Buku::count() }}
                    </span>
                    <span style="font-size:12px;color:#10b981;"><i class="fas fa-books"></i> Koleksi tersedia</span>
                </div>
            </div>
        </div>

        {{-- Stat: Total Anggota --}}
        <div class="col-lg-3 col-md-6 col-sm-6 col-12" style="margin-bottom:16px;">
            <div class="info-box" style="background:white;">
                <span class="info-box-icon" style="background:linear-gradient(135deg,#14b8a6,#0d9488); height:auto; padding:20px 0;">
                    <i class="fas fa-users" style="font-size:26px;"></i>
                </span>
                <div class="info-box-content" style="padding:16px 20px;">
                    <span style="font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:0.5px;">Total Anggota</span>
                    <span id="stat-total-anggota" style="font-size:28px;font-weight:700;color:#0f172a;display:block;line-height:1.2;">
                        {{ \App\Models\User::where('role_id', 2)->count() }}
                    </span>
                    <span style="font-size:12px;color:#10b981;"><i class="fas fa-user-check"></i> Member aktif</span>
                </div>
            </div>
        </div>

        {{-- Stat: Sedang Dipinjam --}}
        <div class="col-lg-3 col-md-6 col-sm-6 col-12" style="margin-bottom:16px;">
            <div class="info-box" style="background:white;">
                <span class="info-box-icon" style="background:linear-gradient(135deg,#f59e0b,#d97706); height:auto; padding:20px 0;">
                    <i class="fas fa-hand-holding-heart" style="font-size:26px;"></i>
                </span>
                <div class="info-box-content" style="padding:16px 20px;">
                    <span style="font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:0.5px;">Sedang Dipinjam</span>
                    <span id="stat-sedang-dipinjam" style="font-size:28px;font-weight:700;color:#0f172a;display:block;line-height:1.2;">
                        {{ \App\Models\PinjamDetail::where('status', 'Pinjam')->count() }}
                    </span>
                    <span style="font-size:12px;color:#f59e0b;"><i class="fas fa-clock"></i> Belum dikembalikan</span>
                </div>
            </div>
        </div>

        {{-- Stat: Booking Aktif --}}
        <div class="col-lg-3 col-md-6 col-sm-6 col-12" style="margin-bottom:16px;">
            <div class="info-box" style="background:white;">
                <span class="info-box-icon" style="background:linear-gradient(135deg,#ef4444,#dc2626); height:auto; padding:20px 0;">
                    <i class="fas fa-clipboard-list" style="font-size:26px;"></i>
                </span>
                <div class="info-box-content" style="padding:16px 20px;">
                    <span style="font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:0.5px;">Booking Aktif</span>
                    <span id="stat-booking-aktif" style="font-size:28px;font-weight:700;color:#0f172a;display:block;line-height:1.2;">
                        {{ \App\Models\Booking::count() }}
                    </span>
                    <span style="font-size:12px;color:#ef4444;"><i class="fas fa-hourglass-half"></i> Menunggu diambil</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Row 2 (Baru ditambahkan) --}}
    <div class="row" style="margin-bottom: 24px;">

        {{-- Stat: Stok Tersedia --}}
        <div class="col-lg-4 col-md-6 col-sm-6 col-12" style="margin-bottom:16px;">
            <div class="info-box" style="background:white;">
                <span class="info-box-icon" style="background:linear-gradient(135deg,#0ea5e9,#0369a1); height:auto; padding:20px 0;">
                    <i class="fas fa-layer-group" style="font-size:26px;"></i>
                </span>
                <div class="info-box-content" style="padding:16px 20px;">
                    <span style="font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:0.5px;">Stok Tersedia</span>
                    <span id="stat-stok-tersedia" style="font-size:28px;font-weight:700;color:#0f172a;display:block;line-height:1.2;">
                        {{ \App\Models\Buku::sum('stok') }}
                    </span>
                    <span style="font-size:12px;color:#0ea5e9;"><i class="fas fa-check-circle"></i> Siap dipinjam</span>
                </div>
            </div>
        </div>

        {{-- Stat: Total Kategori --}}
        <div class="col-lg-4 col-md-6 col-sm-6 col-12" style="margin-bottom:16px;">
            <div class="info-box" style="background:white;">
                <span class="info-box-icon" style="background:linear-gradient(135deg,#8b5cf6,#6d28d9); height:auto; padding:20px 0;">
                    <i class="fas fa-tags" style="font-size:26px;"></i>
                </span>
                <div class="info-box-content" style="padding:16px 20px;">
                    <span style="font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:0.5px;">Kategori Buku</span>
                    <span id="stat-total-kategori" style="font-size:28px;font-weight:700;color:#0f172a;display:block;line-height:1.2;">
                        {{ \App\Models\Kategori::count() }}
                    </span>
                    <span style="font-size:12px;color:#8b5cf6;"><i class="fas fa-folder"></i> Klasifikasi data</span>
                </div>
            </div>
        </div>

        {{-- Stat: Peminjaman Selesai --}}
        <div class="col-lg-4 col-md-6 col-sm-6 col-12" style="margin-bottom:16px;">
            <div class="info-box" style="background:white;">
                <span class="info-box-icon" style="background:linear-gradient(135deg,#10b981,#059669); height:auto; padding:20px 0;">
                    <i class="fas fa-check-double" style="font-size:26px;"></i>
                </span>
                <div class="info-box-content" style="padding:16px 20px;">
                    <span style="font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:0.5px;">Telah Dikembalikan</span>
                    <span id="stat-total-selesai" style="font-size:28px;font-weight:700;color:#0f172a;display:block;line-height:1.2;">
                        {{ \App\Models\PinjamDetail::where('status', 'Kembali')->count() }}
                    </span>
                    <span style="font-size:12px;color:#10b981;"><i class="fas fa-history"></i> Riwayat tuntas</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="row" style="margin-bottom: 24px;">
        <div class="col-lg-8">
            <div class="card" style="height:100%;">
                <div class="card-header" style="font-size:15px; font-weight:600; display:flex; justify-content:space-between; align-items:center;">
                    <div><i class="fas fa-chart-area" style="color:#6366f1; margin-right:8px;"></i> Tren Peminjaman (7 Hari Terakhir)</div>
                </div>
                <div class="card-body">
                    <canvas id="peminjamanChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card" style="height:100%;">
                <div class="card-header" style="font-size:15px; font-weight:600;">
                    <i class="fas fa-chart-pie" style="color:#14b8a6; margin-right:8px;"></i> Proporsi Status
                </div>
                <div class="card-body" style="display:flex; justify-content:center; align-items:center;">
                    <canvas id="statusChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Action Cards --}}
    <div class="row">
        <div class="col-md-6" style="margin-bottom:16px;">
            <div class="card">
                <div class="card-header" style="font-size:15px; font-weight:600;">
                    <i class="fas fa-bolt" style="color:#6366f1; margin-right:8px;"></i> Akses Cepat
                </div>
                <div class="card-body">
                    <div style="display:flex; flex-wrap:wrap; gap:10px;">
                        <a href="{{ route('admin.master.buku.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Buku
                        </a>
                        <a href="{{ route('admin.transaksi.booking.index') }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-bookmark"></i> Lihat Booking
                        </a>
                        <a href="{{ route('admin.transaksi.peminjaman.index') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-list"></i> Data Peminjaman
                        </a>
                        <a href="{{ route('admin.transaksi.peminjaman.pengembalian') }}" class="btn btn-info btn-sm">
                            <i class="fas fa-undo"></i> Pengembalian
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6" style="margin-bottom:16px;">
            <div class="card">
                <div class="card-header" style="font-size:15px; font-weight:600;">
                    <i class="fas fa-info-circle" style="color:#14b8a6; margin-right:8px;"></i> Status Sistem
                </div>
                <div class="card-body">
                    <div style="display:flex; flex-direction:column; gap:10px;">
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <span style="font-size:13px; color:#64748b;">Database</span>
                            <span style="background:#d1fae5;color:#065f46;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600;">Online</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <span style="font-size:13px; color:#64748b;">Storage</span>
                            <span style="background:#d1fae5;color:#065f46;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600;">Aktif</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <span style="font-size:13px; color:#64748b;">Versi Aplikasi</span>
                            <span style="background:#e0e7ff;color:#4338ca;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600;">v1.0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Realtime Clock Logic
    function updateClock() {
        const now = new Date();
        const timeHTML = now.toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit', second:'2-digit' }).replace(/\./g, ':');
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const dateHTML = now.toLocaleDateString('id-ID', options);
        
        $('#realtime-clock').text(timeHTML);
        $('#realtime-date').text(dateHTML);
    }
    setInterval(updateClock, 1000);
    updateClock();

    // Init Charts Variable
    let peminjamanChart;
    let statusChart;

    // Live update function fetching from JSON endpoint every 3 seconds
    function updateDashboardStats() {
        $.ajax({
            url: "{{ route('admin.dashboard.stats') }}",
            type: "GET",
            dataType: "json",
            success: function(data) {
                // Flash Live Indicator
                $('#live-indicator').fadeIn(200).delay(1000).fadeOut(200);

                // Update text fields
                let updateField = function(id, newValue) {
                    let element = $('#' + id);
                    if(element.text().trim() != newValue) {
                        element.fadeOut('fast', function() {
                            $(this).text(newValue).fadeIn('fast');
                        });
                    }
                };

                updateField('stat-total-buku', data.totalBuku);
                updateField('stat-total-anggota', data.totalAnggota);
                updateField('stat-sedang-dipinjam', data.sedangDipinjam);
                updateField('stat-booking-aktif', data.bookingAktif);
                
                updateField('stat-stok-tersedia', data.bukuTersedia);
                updateField('stat-total-kategori', data.totalKategori);
                updateField('stat-total-selesai', data.totalPeminjamanSelesai);
                
                // --- UPDATE CHART 1: Bar Chart Harian ---
                if (!peminjamanChart) {
                    const ctxBar = document.getElementById('peminjamanChart').getContext('2d');
                    peminjamanChart = new Chart(ctxBar, {
                        type: 'bar',
                        data: {
                            labels: data.chartHarian.labels,
                            datasets: [{
                                label: 'Jumlah Peminjam',
                                data: data.chartHarian.data,
                                backgroundColor: 'rgba(99, 102, 241, 0.8)',
                                borderRadius: 6,
                                maxBarThickness: 40
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: {
                                y: { beginAtZero: true, ticks: { stepSize: 1 } },
                                x: { grid: { display: false } }
                            }
                        }
                    });
                } else {
                    peminjamanChart.data.labels = data.chartHarian.labels;
                    peminjamanChart.data.datasets[0].data = data.chartHarian.data;
                    peminjamanChart.update();
                }

                // --- UPDATE CHART 2: Doughnut Chart Status ---
                if (!statusChart) {
                    const ctxPie = document.getElementById('statusChart').getContext('2d');
                    statusChart = new Chart(ctxPie, {
                        type: 'doughnut',
                        data: {
                            labels: ['Sedang Dipinjam', 'Booking', 'Selesai'],
                            datasets: [{
                                data: [data.chartStatus.pinjam, data.chartStatus.booking, data.chartStatus.kembali],
                                backgroundColor: ['#f59e0b', '#ef4444', '#10b981'],
                                borderWidth: 0,
                                hoverOffset: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '70%',
                            plugins: {
                                legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 8 } }
                            }
                        }
                    });
                } else {
                    statusChart.data.datasets[0].data = [data.chartStatus.pinjam, data.chartStatus.booking, data.chartStatus.kembali];
                    statusChart.update();
                }
            },
            error: function(err) {
                console.log("Error loading realtime stats", err);
            }
        });
    }

    $(document).ready(function() {
        // Init Load & setInterval (every 4 seconds)
        updateDashboardStats();
        setInterval(updateDashboardStats, 4000);
    });
</script>
@endpush