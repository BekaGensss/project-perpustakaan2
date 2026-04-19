@extends('member.layout.main')
@section('title', 'Data Booking')
@section('content')
<div class="container pt-4 pb-5">
    @if(count($data_booking) > 0)
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0 mb-4" style="border-radius: 16px; overflow: hidden; background: linear-gradient(135deg, #1e1b4b, #312e81);">
                <div class="card-body p-4 text-white">
                    <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap: 20px;">
                        <div>
                            <h4 style="font-weight: 700; margin-bottom: 5px;"><i class="fas fa-bookmark text-warning mr-2"></i> Bukti Booking Anda</h4>
                            <p style="margin: 0; font-size: 14px; opacity: 0.9;">Harap tunjukkan bukti ini (Cetak/Screenshot) kepada pustakawan untuk mengambil buku.</p>
                        </div>
                        <a href="{{ route('member.cetakBooking', ['user' => Auth::user()->id]) }}" target="_blank" class="btn btn-warning" style="font-weight: 700; border-radius: 10px; padding: 10px 24px; box-shadow: 0 4px 10px rgba(245, 158, 11, 0.3);">
                            <i class="fas fa-print mr-1"></i> Cetak Bukti PDF
                        </a>
                    </div>
                </div>
                
                <div class="card-footer p-0" style="background: rgba(0,0,0,0.15); border-top: 1px solid rgba(255,255,255,0.1);">
                    <div class="d-flex flex-wrap text-white">
                        <div class="p-3 px-4" style="border-right: 1px solid rgba(255,255,255,0.1);">
                            <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 1px; opacity: 0.7;">ID Booking</div>
                            <div style="font-size: 16px; font-weight: 700; font-family: monospace;">{{ $data_booking[0]->id_booking }}</div>
                        </div>
                        <div class="p-3 px-4" style="border-right: 1px solid rgba(255,255,255,0.1);">
                            <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 1px; opacity: 0.7;">Tanggal Pesan</div>
                            <div style="font-size: 15px; font-weight: 600;">{{ \Carbon\Carbon::parse($data_booking[0]->tgl_booking)->format('d M Y, H:i') }}</div>
                        </div>
                        <div class="p-3 px-4">
                            <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #fca5a5;">Batas Pengambilan</div>
                            <div style="font-size: 15px; font-weight: 600; color: #fecaca;">{{ \Carbon\Carbon::parse($data_booking[0]->batas_ambil)->format('d M Y, H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Peringatan --}}
            <div class="alert" style="background: #fffbeb; border: 1px solid #fef3c7; border-left: 4px solid #f59e0b; border-radius: 10px; color: #b45309;">
                <i class="fas fa-exclamation-triangle mr-2"></i> <strong>Waktu Pengambilan Buku: 1x24 jam dari waktu booking.</strong> Jika tidak diambil setelah batas waktu, maka sistem akan secara otomatis membatalkan pesanan.
            </div>

            {{-- Tabel Cover --}}
            <div class="card shadow-sm border-0" style="border-radius: 16px;">
                <div class="card-body p-0">
                    <div class="table-responsive" style="border-radius: 16px;">
                        <table class="table table-hover mb-0">
                            <thead style="background: #f8fafc;">
                                <tr>
                                    <th class="text-center" style="width: 50px; border-top: none;">#</th>
                                    <th style="width: 100px; border-top: none;">Cover</th>
                                    <th style="border-top: none;">Rincian Buku</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_booking as $booking)
                                    @php $no = 1; @endphp
                                    @foreach ($booking->booking_detail as $detail)
                                        <tr>
                                            <td class="text-center align-middle" style="font-weight: 600;">{{ $no++ }}</td>
                                            <td class="align-middle">
                                                @php $imagePath = $detail->buku->image ?? 'cover-buku/book-default-cover.jpg'; @endphp
                                                <img src="{{ asset('storage/' . $imagePath) }}" alt="Cover Buku" 
                                                     style="width: 70px; height: 100px; object-fit: cover; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                            </td>
                                            <td class="align-middle">
                                                <div style="font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 4px;">{{ $detail->buku->judul_buku ?? 'Buku Tidak Diketahui' }}</div>
                                                <div style="font-size: 13px; color: #64748b; margin-bottom: 2px;">
                                                    <i class="fas fa-tags text-primary" style="width: 16px;"></i> {{ $detail->buku->kategori->nama_kategori ?? 'N/A' }}
                                                </div>
                                                <div style="font-size: 13px; color: #64748b;">
                                                    <i class="fas fa-user-edit text-primary" style="width: 16px;"></i> {{ $detail->buku->pengarang ?? 'N/A' }} &middot; {{ $detail->buku->penerbit ?? 'N/A' }} ({{ $detail->buku->tahun_terbit ?? 'N/A' }})
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
    @else
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center py-5">
                    <img src="https://img.freepik.com/free-vector/no-data-concept-illustration_114360-536.jpg" alt="Empty" style="width: 250px; opacity: 0.8; margin-bottom: 20px;">
                    <h4 style="font-weight: 700; color: #334155;">Belum ada Data Booking</h4>
                    <p class="text-muted">Anda tidak memiliki daftar pesanan aktif saat ini.</p>
                    <a href="{{ route('member.index') }}" class="btn btn-primary" style="border-radius: 10px; padding: 10px 24px;"><i class="fas fa-search mr-1"></i> Cari Buku Sekarang</a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection