@extends('member.layout.main')
@section('title', 'Sedang Pinjam')

@section('content')
<style>
    .table-modern td, .table-modern th { vertical-align: middle; padding: 1rem; border-color: #f1f5f9; }
    .table-modern thead th { background: #f8fafc; color: #475569; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: none; }
    .table-modern tbody tr { transition: all 0.2s ease; }
    .table-modern tbody tr:hover { background-color: #f8fafc; }
    .info-sm { font-size: 13px; color: #64748b; margin-bottom: 3px; }
    .val-sm { font-size: 14px; font-weight: 600; color: #0f172a; margin-bottom: 0; }
</style>

<div class="container pt-4 pb-5">
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 16px; overflow: hidden;">
        <div class="card-header bg-white border-0 pt-4 pb-3 px-4 d-flex justify-content-between align-items-center">
            <div>
                <h4 style="font-weight: 700; color: #0f172a; margin: 0;"><i class="fas fa-book-reader text-primary mr-2"></i> Buku Sedang Dipinjam</h4>
                <p class="text-muted mt-1 mb-0" style="font-size: 14px;">Daftar buku yang saat ini sedang Anda pinjam beserta tenggat waktunya.</p>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="sedang-pinjam" class="table table-modern mb-0" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th style="width: 90px;">Cover</th>
                            <th>Buku & Peminjaman</th>
                            <th>Durasi & Jadwal</th>
                            <th>Status & Denda</th>
                            <th>Petugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sedang_pinjam as $pinjam)
                            @foreach ($pinjam->pinjam_detail as $detail)
                                <tr>
                                    <td class="text-center" style="font-weight: 600;">{{ $loop->iteration }}</td>
                                    
                                    {{-- Cover --}}
                                    <td>
                                        @php $imagePath = $detail->buku->image ?? 'cover-buku/book-default-cover.jpg'; @endphp
                                        <img src="{{ asset('storage/' . $imagePath) }}" alt="Cover Buku" 
                                             style="width: 65px; height: 95px; object-fit: cover; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                    </td>

                                    {{-- Detail Buku & Transaksi --}}
                                    <td>
                                        <div style="font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 8px;">{{ $detail->buku->judul_buku }}</div>
                                        <div class="info-sm"><i class="fas fa-hashtag text-primary" style="width:16px;"></i> No: <span class="val-sm">{{ $pinjam->no_pinjam }}</span></div>
                                        <div class="info-sm"><i class="fas fa-calendar-alt text-primary" style="width:16px;"></i> Dipinjam: <span class="val-sm">{{ date('d M Y', strtotime($pinjam->tgl_pinjam)) }}</span></div>
                                    </td>

                                    {{-- Waktu Pinjam --}}
                                    <td>
                                        <div class="info-sm">Lama Pinjam: <span class="val-sm">{{ $detail->lama_pinjam }} Hari</span></div>
                                        <div class="info-sm">Batas Kembali:</div>
                                        <div class="val-sm text-danger"><i class="fas fa-clock"></i> {{ date('d M Y', strtotime($detail->tgl_kembali)) }}</div>
                                    </td>
                                    
                                    {{-- Status & Keterlambatan --}}
                                    <td>
                                        <div style="margin-bottom: 8px;">
                                            @if ($detail->status == 'Pinjam')
                                                <span class="badge badge-warning text-dark" style="padding: 6px 12px; font-weight: 600; border-radius: 6px;"><i class="fas fa-hourglass-half mr-1"></i> Sedang Dipinjam</span>
                                            @else
                                                <span class="badge badge-success" style="padding: 6px 12px; font-weight: 600; border-radius: 6px;"><i class="fas fa-check-circle mr-1"></i> Selesai</span>
                                            @endif
                                        </div>

                                        @php
                                            $tglKembali = \Carbon\Carbon::parse($detail->tgl_kembali)->startOfDay();
                                            $hariIni = \Carbon\Carbon::now()->startOfDay();
                                            $terlambat = 0;
                                            
                                            if ($hariIni->gt($tglKembali)) {
                                                $terlambat = $hariIni->diffInDays($tglKembali, false);
                                                $terlambat = ceil($terlambat);
                                            }
                                        @endphp
                                        
                                        @if($terlambat > 0)
                                            <div class="info-sm" style="color: #ef4444 !important; font-weight: 600;"><i class="fas fa-exclamation-circle"></i> Terlambat: {{ $terlambat }} hari</div>
                                            <div class="info-sm">Total Denda: <span class="val-sm text-danger">Rp {{ number_format($detail->denda * $terlambat, 0, ',', '.') }}</span></div>
                                        @else
                                            <div class="info-sm text-success"><i class="fas fa-check"></i> Waktu aman</div>
                                            <div class="info-sm">Denda/hari: Rp {{ number_format($detail->denda, 0, ',', '.') }}</div>
                                        @endif
                                    </td>

                                    {{-- Petugas --}}
                                    <td>
                                        <div class="info-sm">Diserahkan oleh:</div>
                                        <div class="val-sm">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($pinjam->petugas_pinjam->nama) }}&background=6366f1&color=fff" style="width:20px;height:20px;border-radius:50%;margin-right:5px;">
                                            {{ $pinjam->petugas_pinjam->nama }}
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $("#sedang-pinjam").DataTable({
            "responsive": true,
            "autoWidth": false,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            }
        });
    });
</script>
@endpush