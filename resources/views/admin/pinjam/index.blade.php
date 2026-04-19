@extends('admin.layout.main')
@section('title', 'Transaksi Peminjaman')

@section('content')
<div class="container-fluid pt-3 pb-4">
    <div class="row">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 12px; background: #d1fae5; color: #065f46;">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                </div>
            @endif

            <div class="card shadow-sm border-0 mb-4" style="border-radius: 16px; overflow: hidden;">
                
                {{-- Header Awal --}}
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h4 style="font-weight: 700; color: #0f172a; margin: 0;"><i class="fas fa-book-reader text-primary mr-2"></i> Transaksi Peminjaman</h4>
                    <p class="text-muted mt-1 mb-4" style="font-size: 14px;">Pantau siklus pinjam buku anggota yang sedang aktif berlangsung saat ini.</p>
                    
                    {{-- Filter & Export Bar --}}
                    <div class="bg-light rounded p-3 mb-3" style="border: 1px solid #e2e8f0;">
                        <form method="GET" action="{{ route('admin.transaksi.peminjaman.index') }}" class="m-0">
                            <div class="row align-items-center">
                                <div class="col-md-3 col-sm-6 mb-2 mb-md-0">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-right-0"><i class="far fa-calendar-alt text-primary"></i></span>
                                        </div>
                                        <input type="date" id="start_date" name="start_date" class="form-control border-left-0" placeholder="Tanggal Mulai" value="{{ request('start_date') }}" style="border-radius: 0 8px 8px 0; border: 1px solid #ced4da; box-shadow: none;">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-2 mb-md-0">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-right-0"><i class="far fa-calendar-check text-primary"></i></span>
                                        </div>
                                        <input type="date" id="end_date" name="end_date" class="form-control border-left-0" placeholder="Tanggal Akhir" value="{{ request('end_date') }}" style="border-radius: 0 8px 8px 0; border: 1px solid #ced4da; box-shadow: none;">
                                    </div>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <button type="submit" class="btn btn-primary shadow-sm" style="background: linear-gradient(135deg, #6366f1, #4f46e5); border: none; font-weight: 600; padding: 8px 16px; border-radius: 8px;">
                                        <i class="fas fa-filter mr-1"></i> Filter
                                    </button>
                                    
                                    <a href="#" id="export-pdf" class="btn btn-danger shadow-sm ml-2" style="font-weight: 600; padding: 8px 16px; border-radius: 8px; border: none;">
                                        <i class="far fa-file-pdf mr-1"></i> Export PDF
                                    </a>
                                    
                                    <a href="#" id="export-excel" class="btn btn-success shadow-sm ml-2" style="font-weight: 600; padding: 8px 16px; border-radius: 8px; background-color: #10b981; border: none;">
                                        <i class="far fa-file-excel mr-1"></i> Export Excel
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                {{-- Card Body: DataTables --}}
                <div class="card-body p-0">
                    <div class="table-responsive px-4 pb-4">
                        <table class="table table-hover table-modern mb-0" id="transaksi-table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 50px;">#</th>
                                    <th>No. Register</th>
                                    <th>Cakupan Waktu</th>
                                    <th>Buku</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Gambar</th>
                                    <th>Partisipan</th>
                                    <th class="text-center" style="width: 80px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($data_pinjam->isEmpty())
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted"><i class="fas fa-folder-open text-primary mb-2" style="font-size: 24px; opacity: 0.5;"></i><br>Tidak ada data peminjaman aktif.</td>
                                    </tr>
                                @else
                                    @foreach ($data_pinjam as $pinjam)
                                        @foreach ($pinjam->pinjam_detail as $detail)
                                            @if ($detail->status == 'Pinjam') 
                                                <tr>
                                                    <td class="text-center" style="font-weight: 600; vertical-align: middle;">{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                                                    
                                                    <td style="vertical-align: middle; font-weight: 600; color: #0f172a; font-size:14px;">
                                                        <i class="fas fa-barcode text-primary mr-2" style="opacity:0.7"></i>{{ $pinjam->no_pinjam }}
                                                    </td>
                                                    
                                                    <td style="vertical-align: middle;">
                                                        <div style="font-size: 12px; color: #64748b; margin-bottom: 2px;"><span style="display:inline-block; width:45px;">Mulai</span>: <strong style="color: #0f172a;">{{ \Carbon\Carbon::parse($pinjam->tgl_pinjam)->format('d M Y') }}</strong></div>
                                                        <div style="font-size: 12px; color: #64748b;"><span style="display:inline-block; width:45px;">Batas</span>: <strong style="color: #dc2626;">{{ \Carbon\Carbon::parse($detail->tgl_kembali)->format('d M Y') }}</strong></div>
                                                    </td>
                                                    
                                                    <td style="vertical-align: middle; font-weight: 600; color: #0f172a; max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                        {{ $detail->buku->judul_buku ?? 'N/A' }}
                                                    </td>
                                                    
                                                    <td class="text-center" style="vertical-align: middle;">
                                                        <span class="badge" style="background: #fef3c7; color: #d97706; padding: 6px 12px; font-weight: 600;"><i class="fas fa-hourglass-half mr-1"></i> {{ $detail->status }}</span>
                                                    </td>
                                                    
                                                    <td class="text-center" style="vertical-align: middle;">
                                                        <img src="{{ asset('storage/' . ($detail->buku->image ?? '')) }}" alt="Cover" style="width: 40px; height: 55px; object-fit: cover; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                                    </td>
                                                    
                                                    <td style="vertical-align: middle;">
                                                        <div style="font-size: 13px; color: #0f172a; margin-bottom: 3px;"><i class="fas fa-user-circle text-primary mr-1"></i> {{ $pinjam->anggota->nama ?? 'N/A' }} (Peminjam)</div>
                                                        <div style="font-size: 13px; color: #64748b;"><i class="fas fa-user-shield text-info mr-1"></i> {{ $pinjam->petugas_pinjam->nama ?? 'N/A' }} (Staf)</div>
                                                    </td>
                                                    
                                                    <td class="text-center" style="vertical-align: middle;">
                                                        <form action="{{ route('admin.transaksi.pinjam.kembalikanBuku', ['no_pinjam' => $pinjam->no_pinjam, 'id_buku' => $detail->id_buku]) }}" method="POST" class="m-0">
                                                            @csrf
                                                            <input type="hidden" name="_method" value="PUT">
                                                            <button type="submit" class="btn btn-sm text-white" data-toggle="tooltip" title="Kembalikan Buku" style="border-radius: 6px; background-color: #6366f1; border-color: #6366f1; box-shadow: 0 2px 5px rgba(99,102,241,0.3);">
                                                                <i class="fas fa-undo-alt mr-1"></i> Proses
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // 1. Inisialisasi DataTable client-side (TIDAK ADA AJAX/serverSide)
    // Ini menghilangkan error 'Ajax error'
    $('#transaksi-table').DataTable({
        "responsive": true,
        "autoWidth": false,
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true
    });
    
    // 2. Logika untuk Tombol Export PDF
    $('#export-pdf').on('click', function(e) {
        e.preventDefault();
        var startDate = $('input[name="start_date"]').val(); // Ambil nilai dari input date name
        var endDate = $('input[name="end_date"]').val();
        
        if (startDate === '' || endDate === '') {
            alert("Silakan pilih Tanggal Mulai dan Tanggal Akhir untuk export.");
            return false;
        }
        
        // Memanggil route Controller PDF
        var url = '{{ route('admin.transaksi.pinjam.exportPdfPinjam') }}?start_date=' + startDate + '&end_date=' + endDate;
        window.open(url, '_blank');
    });

    // 3. Logika untuk Tombol Export Excel
    $('#export-excel').on('click', function(e) {
        e.preventDefault();
        var startDate = $('input[name="start_date"]').val();
        var endDate = $('input[name="end_date"]').val();
        
        if (startDate === '' || endDate === '') {
            alert("Silakan pilih Tanggal Mulai dan Tanggal Akhir untuk export Excel.");
            return false;
        }
        
        // Memanggil route Controller Excel
        var url = '{{ route('admin.transaksi.pinjam.exportExcelPinjam') }}?start_date=' + startDate + '&end_date=' + endDate;
        window.open(url, '_blank');
    });
    
    // Inisialisasi tooltip
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endpush