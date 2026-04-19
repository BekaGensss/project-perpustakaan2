@extends('admin.layout.main')

@section('title', 'Transaksi Booking')

@section('content')
<div class="container-fluid pt-3 pb-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 mb-4" style="border-radius: 16px; overflow: hidden;">
                
                {{-- Header Awal --}}
                <div class="card-header bg-white border-0 pt-4 pb-3 px-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 style="font-weight: 700; color: #0f172a; margin: 0;"><i class="fas fa-clipboard-check text-primary mr-2"></i> Transaksi Booking</h4>
                        <p class="text-muted mt-1 mb-0" style="font-size: 14px;">Pantau status pemesanan buku yang belum diambil oleh anggota.</p>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive px-4 pb-4">
                        <table id="example1" class="table table-hover table-modern mb-0" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 50px;">#</th>
                                    <th>Kode & Anggota</th>
                                    <th>Jadwal Reservasi</th>
                                    <th>Batas Waktu Pengambilan</th>
                                    <th class="text-center" style="width: 100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($booking as $item)
                                    <tr>
                                        <td class="text-center" style="font-weight: 600; vertical-align: middle;">{{ $loop->iteration }}</td>
                                        
                                        <td style="vertical-align: middle;">
                                            <div style="font-weight: 700; color: #0f172a; font-size: 15px; margin-bottom: 4px;">{{ $item->anggota->nama }}</div>
                                            <div style="font-size: 12px; color: #64748b;">
                                                <i class="fas fa-hashtag text-primary mr-1" style="opacity:0.7"></i> <strong>{{ $item->id_booking }}</strong>
                                            </div>
                                        </td>
                                        
                                        <td style="vertical-align: middle;">
                                            <div style="font-size: 13px; color: #0f172a; font-weight: 500;"><i class="far fa-calendar-alt text-info mr-1"></i> {{ date('d M Y', strtotime($item->tgl_booking)) }}</div>
                                        </td>
                                        
                                        <td style="vertical-align: middle;">
                                            <div style="font-size: 13px; color: #dc2626; font-weight: 700;"><i class="far fa-clock mr-1"></i> {{ date('d M Y', strtotime($item->batas_ambil)) }}</div>
                                            <div style="font-size: 11px; color: #ef4444; margin-top: 2px;">Otomatis batal jika melewati batas</div>
                                        </td>
                                        
                                        <td class="text-center" style="vertical-align: middle;">
                                            <form action="{{ route('admin.transaksi.booking.destroy', $item->id) }}" method="POST" class="d-flex justify-content-center" style="gap: 6px;">
                                                
                                                {{-- Tombol Detail --}}
                                                <a href="{{ route('admin.transaksi.booking.show', $item->id) }}" 
                                                    class="btn btn-sm btn-info text-white"
                                                    data-toggle="tooltip" data-placement="top" 
                                                    title="Proses & Lihat Detail"
                                                    style="border-radius: 6px; font-weight:600;">
                                                    <i class="fas fa-external-link-alt"></i> Detail
                                                </a>
                                                
                                                @csrf
                                                @method('DELETE')
                                                
                                                {{-- Tombol Hapus --}}
                                                <button type="button" 
                                                    class="btn btn-sm btn-danger hapus-data" 
                                                    data-toggle="tooltip" data-placement="top"
                                                    title="Batalkan Booking"
                                                    style="border-radius: 6px;">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
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
    
    $(document).on('click', '.hapus-data', function() {
        var form = $(this).closest("form");
        if (confirm('Yakin ingin menghapus data??')) {
            form.submit();
        }
    });
</script>
@endpush