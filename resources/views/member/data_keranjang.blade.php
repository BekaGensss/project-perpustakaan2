@extends('member.layout.main')
@section('title', 'Data Keranjang')
@section('content')
<div class="container pt-4 pb-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0" style="border-radius: 16px; overflow: hidden;">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h4 style="font-weight: 700; color: #0f172a; margin: 0;"><i class="fas fa-shopping-cart text-primary mr-2"></i> Keranjang Pinjaman</h4>
                    <p class="text-muted mt-1" style="font-size: 14px;">Buku-buku ini telah Anda pilih dan siap untuk diproses (di-booking).</p>
                </div>
                
                <div class="card-body px-4">
                    {{-- Alert jika ada buku stok kosong --}}
                    @php $adaStokKosong = false; @endphp
                    @foreach ($data_keranjang as $item)
                        @if($item->buku->stok == 0)
                            @php $adaStokKosong = true; @endphp
                        @endif
                    @endforeach

                    @if($adaStokKosong)
                        <div class="alert alert-danger" style="border-radius:10px;">
                            <i class="fas fa-exclamation-triangle"></i> Ada buku di keranjang Anda yang stoknya saat ini kosong (ditandai merah). Silakan hapus buku tersebut sebelum menekan tombol Proses Booking.
                        </div>
                    @endif

                    <div class="table-responsive" style="border-radius: 12px; border: 1px solid #e2e8f0;">
                        <table class="table table-hover mb-0">
                            <thead style="background: #f8fafc;">
                                <tr>
                                    <th class="text-center" style="width: 60px;">#</th>
                                    <th>Cove Buku</th>
                                    <th>Detail Buku</th>
                                    <th class="text-center">Stok sisa</th>
                                    <th class="text-center" style="width: 100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_keranjang as $item)
                                    <tr style="{{ $item->buku->stok == 0 ? 'background-color: #fee2e2;' : '' }}">
                                        <td class="text-center align-middle" style="font-weight: 600;">{{ $loop->iteration }}</td>
                                        <td class="align-middle" style="width: 100px;">
                                            <img src="{{ asset('storage/' . $item->buku->image) }}" alt="Cover Buku" 
                                                 style="width: 70px; height: 100px; object-fit: cover; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                        </td>
                                        <td class="align-middle">
                                            <div style="font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 4px;">{{ $item->buku->judul_buku }}</div>
                                            <div style="font-size: 13px; color: #64748b; margin-bottom: 2px;">
                                                <i class="fas fa-tags text-primary" style="width: 16px;"></i> {{ $item->buku->kategori->nama_kategori }}
                                            </div>
                                            <div style="font-size: 13px; color: #64748b;">
                                                <i class="fas fa-user-edit text-primary" style="width: 16px;"></i> {{ $item->buku->pengarang }} &middot; {{ $item->buku->tahun_terbit }}
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <span class="badge {{ $item->buku->stok > 0 ? 'badge-success' : 'badge-danger' }}" style="font-size: 14px; padding: 6px 12px;">
                                                {{ $item->buku->stok }} Tersedia
                                            </span>
                                        </td>
                                        <td class="text-center align-middle">
                                            {{-- Aksi Hapus Keranjang --}}
                                            <form action="{{ route('member.hapusKeranjang', ['buku' => $item->buku->id, 'user' => Auth::user()->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger hapus-data" style="border-radius: 8px; padding: 6px 12px; font-size: 13px;" data-toggle="tooltip" data-placement="top" title="Hapus dari Keranjang">
                                                    <i class="fas fa-trash-alt"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer bg-white border-top px-4 py-4 d-flex justify-content-between align-items-center flex-wrap" style="gap: 16px;">
                    <a href="{{ route('member.index') }}" class="btn" style="background: #f1f5f9; color: #475569; border-radius: 10px; padding: 10px 20px; font-weight: 600;">
                        <i class="fas fa-arrow-left"></i> Cari Buku Lain
                    </a>
                    
                    <form action="{{ route('member.simpanBooking') }}" method="POST" class="m-0">
                        @csrf
                        <input type="hidden" name="id" value="{{ auth()->user()->id }}">
                        <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #6366f1, #4f46e5); border: none; border-radius: 10px; padding: 12px 28px; font-size: 15px; font-weight: 700; box-shadow: 0 4px 15px rgba(99,102,241,0.4);" {{ $adaStokKosong ? 'disabled' : '' }}>
                            <i class="fas fa-check-circle"></i> Proses Booking Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>@endsection

@push('scripts')
    <script>
        $(document).on('click', '.hapus-data', function() {
            var form = $(this).closest("form");
            if (confirm('Yakin ingin menghapus data??')) {
                form.submit();
            }
        });
    </script>
@endpush