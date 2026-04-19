@extends('admin.layout.main')
@section('title', 'Transaksi Pengembalian')

@section('content')
<div class="container-fluid pt-3 pb-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 mb-4" style="border-radius: 16px; overflow: hidden;">
                
                {{-- Header Awal --}}
                <div class="card-header bg-white border-0 pt-4 pb-3 px-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 style="font-weight: 700; color: #0f172a; margin: 0;"><i class="fas fa-history text-primary mr-2"></i> Log Transaksi Pengembalian</h4>
                        <p class="text-muted mt-1 mb-0" style="font-size: 14px;">Arsip seluruh riwayat peminjaman dan detail denda keterlambatan buku.</p>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive px-4 pb-4">
                        <table id="example1" class="table table-hover table-modern mb-0" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 50px;">#</th>
                                    <th>Detail Buku & Transaksi</th>
                                    <th>Timeline Peminjaman</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Kalkulasi Denda</th>
                                    <th>Operator Staf</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_pinjam as $pinjam)
                                    @foreach ($pinjam->pinjam_detail as $detail)
                                        <tr>
                                            <td class="text-center" style="font-weight: 600; vertical-align: middle;">{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                                            
                                            {{-- Detail Buku & Transaksi --}}
                                            <td style="vertical-align: middle;">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('storage/' . $detail->buku->image) }}" alt="Cover" style="width: 45px; height: 60px; object-fit: cover; border-radius: 6px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-right: 12px; flex-shrink: 0;">
                                                    <div>
                                                        <div style="font-weight: 700; color: #0f172a; font-size: 14px; margin-bottom: 2px;">{{ $detail->buku->judul_buku }}</div>
                                                        <div style="font-size: 12px; color: #6366f1; font-weight: 600;"><i class="fas fa-barcode mr-1"></i>{{ $pinjam->no_pinjam }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            
                                            {{-- Timeline Peminjaman --}}
                                            <td style="vertical-align: middle;">
                                                <div style="font-size: 12px; color: #64748b; margin-bottom: 2px;"><span style="display:inline-block; width: 45px;">Mulai</span>: <strong style="color: #0f172a;">{{ date('d M Y', strtotime($pinjam->tgl_pinjam)) }}</strong></div>
                                                <div style="font-size: 12px; color: #64748b; margin-bottom: 2px;"><span style="display:inline-block; width: 45px;">Batas</span>: <strong style="color: #dc2626;">{{ date('d M Y', strtotime($detail->tgl_kembali)) }}</strong></div>
                                                <div style="font-size: 11px; color: #06b6d4; font-weight: 600; margin-top: 4px;"> <i class="fas fa-clock mr-1"></i> Durasi: {{ $detail->lama_pinjam }} hari</div>
                                            </td>
                                            
                                            {{-- Status --}}
                                            <td class="text-center" style="vertical-align: middle;">
                                                @if ($detail->status == 'Pinjam')
                                                    <span class="badge" style="background: #fef3c7; color: #d97706; padding: 6px 12px; font-weight: 600;"><i class="fas fa-sync-alt fa-spin mr-1"></i> MASIH DIPINJAM</span>
                                                    <div style="font-size: 11px; color: #64748b; margin-top: 6px;">Menunggu dikembalikan</div>
                                                @else
                                                    <span class="badge" style="background: #d1fae5; color: #065f46; padding: 6px 12px; font-weight: 600;"><i class="fas fa-check mr-1"></i> DIKEMBALIKAN</span>
                                                    <div style="font-size: 11px; color: #64748b; margin-top: 6px;">Pada: {{ date('d M Y', strtotime($detail->tgl_pengembalian)) }}</div>
                                                @endif
                                            </td>
                                            
                                            {{-- Kalkulasi Denda --}}
                                            <td style="vertical-align: middle; background-color: #fafafa; border-radius: 8px;">
                                                @php
                                                    $tglKembali = \Carbon\Carbon::parse($detail->tgl_kembali);
                                                    $terlambat = 0;
                                                    if (!is_null($detail->tgl_pengembalian)) {
                                                        $tglPengembalian = \Carbon\Carbon::parse($detail->tgl_pengembalian);
                                                        if ($tglPengembalian->gt($tglKembali)) {
                                                            $terlambat = round($tglKembali->diffInDays($tglPengembalian));
                                                        }
                                                    } elseif ($detail->status == 'Pinjam') {
                                                        // Jika masih dipinjam, hitung keterlambatan sampai hari ini
                                                        $hariIni = \Carbon\Carbon::now();
                                                        if ($hariIni->gt($tglKembali)) {
                                                            $terlambat = round($tglKembali->diffInDays($hariIni));
                                                        }
                                                    }
                                                @endphp
                                                
                                                <div class="d-flex justify-content-between align-items-center mb-1" style="font-size: 12px;">
                                                    <span style="color: #64748b;">Terlambat:</span>
                                                    <strong style="color: {{ $terlambat > 0 ? '#dc2626' : '#10b981' }}">{{ $terlambat > 0 ? $terlambat . ' hari' : 'Tepat Waktu' }}</strong>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="font-size: 12px;">
                                                    <span style="color: #64748b;">Tarif (Harian):</span>
                                                    <strong style="color: #0f172a;">Rp {{ number_format($detail->denda, 0, ',', '.') }}</strong>
                                                </div>
                                                <hr style="margin: 4px 0; border-top: 1px dashed #cbd5e1;">
                                                <div class="d-flex justify-content-between align-items-center" style="font-size: 13px;">
                                                    <span style="color: #0f172a; font-weight: 600;">Total:</span>
                                                    @if($terlambat > 0)
                                                        <strong style="color: #dc2626;">Rp {{ number_format($detail->denda * $terlambat, 0, ',', '.') }}</strong>
                                                    @else
                                                        <strong style="color: #10b981;">Rp 0</strong>
                                                    @endif
                                                </div>
                                            </td>
                                            
                                            {{-- Operator Staf --}}
                                            <td style="vertical-align: middle;">
                                                <div style="font-size: 12px; color: #0f172a; margin-bottom: 4px;">
                                                    <i class="fas fa-sign-out-alt text-primary mr-1" style="width:14px"></i> {{ $pinjam->petugas_pinjam->nama }}
                                                </div>
                                                <div style="font-size: 12px; color: {{ $detail->petugas_kembali != null ? '#0f172a' : '#94a3b8' }};">
                                                    <i class="fas fa-sign-in-alt text-success mr-1" style="width:14px"></i> {{ $detail->petugas_kembali != null ? $detail->petugas_kembali->nama : 'Belum kembali' }}
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
    </div>
</div>@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $("#example1").DataTable({
            "responsive": true,
            "autoWidth": false,
        });
    });
    $('[data-toggle="tooltip"]').tooltip();
    $(document).on('click', '.kembalikan-buku', function() {
        var form = $(this).closest("form");
        if (confirm('Yakin ingin mengembalikan buku ini??')) {
            form.submit();
        }
    });
</script>
@endpush