@extends('member.layout.main')

@section('title', 'Katalog Buku')

@section('content')
<main role="main" class="container pt-4">
    {{-- Menampilkan pesan sukses atau error dari Controller --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    
    <div class="row">
        {{-- KODE YANG DIMODERNISASI: Tampilan Kartu Buku --}}
        @foreach ($buku as $index => $item)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4 d-flex align-items-stretch">
                <div class="card shadow-sm border-0 w-100" style="border-radius: 16px; overflow: hidden; transition: transform 0.3s ease, box-shadow 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.05)'">
                    
                    {{-- Ribbon Stok Float --}}
                    @if ($item->stok > 0)
                        <div class="position-absolute" style="top: 15px; left: 15px; background: rgba(16, 185, 129, 0.9); color: white; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; z-index: 10; backdrop-filter: blur(4px);">
                            <i class="fas fa-box-open mr-1"></i> Stok: {{ $item->stok }}
                        </div>
                    @else
                        <div class="position-absolute" style="top: 15px; left: 15px; background: rgba(239, 68, 68, 0.9); color: white; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; z-index: 10; backdrop-filter: blur(4px);">
                            <i class="fas fa-times-circle mr-1"></i> Kosong
                        </div>
                    @endif
                    
                    {{-- Cover Gambar --}}
                    <div class="card-header d-flex justify-content-center align-items-center border-0 p-0" style="background: linear-gradient(135deg, #f8fafc, #e2e8f0); height: 220px; position: relative;">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="Cover Buku" style="width: 120px; height: 170px; object-fit: cover; border-radius: 8px; box-shadow: 0 10px 15px rgba(0,0,0,0.2); transition: transform 0.3s ease;" class="book-cover">
                    </div>
                    
                    {{-- Detail Buku --}}
                    <div class="card-body p-3 d-flex flex-column bg-white">
                        <div class="mb-2 text-center">
                            <span class="badge" style="background: #e0e7ff; color: #4338ca; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700;">{{ $item->kategori->nama_kategori }}</span>
                        </div>
                        
                        <h6 class="card-title text-center mb-1" style="font-weight: 800; font-size: 15px; color: #0f172a; line-height: 1.3; height: 38px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                            {{ $item->judul_buku }}
                        </h6>
                        
                        <p class="text-muted text-center mb-0" style="font-size: 12px; margin-top: 5px;">
                            <i class="fas fa-pen-nib text-primary mr-1" style="opacity:0.7"></i> <span style="font-weight: 600;">{{ $item->pengarang }}</span>
                        </p>
                        <p class="text-muted text-center mb-3" style="font-size: 11px; opacity: 0.8;">
                            {{ $item->penerbit }} &middot; {{ $item->tahun_terbit }}
                        </p>
                        
                        {{-- Action Buttons --}}
                        <div class="mt-auto d-flex justify-content-between align-items-center" style="gap: 8px;">
                            <button class="btn btn-sm w-50" style="background: #f1f5f9; color: #475569; font-weight: 700; border-radius: 8px; font-size: 12px; padding: 8px 0;" onclick="detailBuku('{{ $item->id }}');">
                                <i class="fas fa-info-circle mr-1"></i> Detail
                            </button>
                            
                            @if ($item->stok > 0)
                                <form action="{{ route('member.tambahKeranjang') }}" method="POST" class="d-inline w-50 m-0">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                    <button type="submit" class="btn btn-sm w-100" style="background: linear-gradient(135deg, #6366f1, #4f46e5); color: white; border: none; font-weight: 700; border-radius: 8px; font-size: 12px; padding: 8px 0; box-shadow: 0 4px 6px rgba(99,102,241,0.25);">
                                        <i class="fas fa-plus mr-1"></i> Keranjang
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-sm w-50" disabled style="background: #f1f5f9; color: #94a3b8; font-weight: 600; border-radius: 8px; font-size: 12px; padding: 8px 0; border: none; cursor: not-allowed;">
                                    <i class="fas fa-ban mr-1"></i> Habis
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{ $buku->links() }}
</main>

<div class="modal fade" id="detailBukuModal" tabindex="-1" role="dialog" aria-labelledby="detailBukuModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Buku</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-3 d-flex justify-content-center align-items-center"
                        style="border-right: 1px solid black">
                        <img src="" class="card-img-top" alt="Cover Buku" style="max-width: 120px;" id="gambar">
                    </div>
                    <div class="col-lg-9 pl-2">
                        <dl>
                            <dt>Judul Buku</dt>
                            <dd id="judul_buku"></dd>
                            <dt>Kategori</dt>
                            <dd id="kategori"></dd>
                            <dt>Pengarang</dt>
                            <dd id="pengarang"></dd>
                            <dt>Penerbit</dt>
                            <dd id="penerbit"></dd>
                            <dt>Tahun Terbit</dt>
                            <dd id="tahun_terbit"></dd>
                            <dt>ISBN</dt>
                            <dd id="isbn"></dd>
                            <dt>Stok</dt>
                            <dd id="stok"></dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <a href="#" class="btn btn-success" id="tambahKeranjangModal">Tambah ke keranjang</a> 
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function detailBuku(id) {
        $.ajax({
            url: '{{ url('/') }}/detail-buku/' + id,
            dataType: 'json',
            type: 'GET',
            error: function() {
                toastr.error('Server error occurred', 'Error', {
                    CloseButton: true,
                    ProgressBar: true
                });
            },
            success: function(data) {
                const APP_URL = '{{ url('/') }}'; 
                
                $('#gambar').attr('src', APP_URL + '/storage/' + data.image);
                $('#judul_buku').html(data.judul_buku)
                $('#kategori').html(data.kategori.nama_kategori)
                $('#pengarang').html(data.pengarang)
                $('#penerbit').html(data.penerbit)
                $('#tahun_terbit').html(data.tahun_terbit)
                $('#isbn').html(data.isbn)
                $('#stok').html(data.stok)
                
                $('#tambahKeranjangModal').off('click').on('click', function(e) {
                    e.preventDefault();
                    let form = $('<form action="{{ route('member.tambahKeranjang') }}" method="POST" style="display:none;">' +
                        '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                        '<input type="hidden" name="id" value="' + data.id + '">' +
                        '</form>');
                        
                    $('body').append(form);
                    form.submit();
                });

                if (data.stok > 0) {
                    $('#tambahKeranjangModal').removeClass('d-none')
                } else {
                    $('#tambahKeranjangModal').addClass('d-none')
                }
            },
        });
        $('#detailBukuModal').modal('show');
    }
</script>
@endpush