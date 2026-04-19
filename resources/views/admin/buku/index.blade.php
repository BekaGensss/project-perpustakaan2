@extends('admin.layout.main')
@section('title', 'Master Buku')

@section('content')
<div class="container-fluid pt-3 pb-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 mb-4" style="border-radius: 16px; overflow: hidden;">
                
                {{-- Header & Aksi Tambah --}}
                <div class="card-header bg-white border-0 pt-4 pb-3 px-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 style="font-weight: 700; color: #0f172a; margin: 0;"><i class="fas fa-book-open text-primary mr-2"></i> Direktori Buku</h4>
                        <p class="text-muted mt-1 mb-0" style="font-size: 14px;">Kelola inventaris dan katalog semua koleksi buku perpustakaan.</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.master.buku.create') }}" class="btn btn-primary" style="background: linear-gradient(135deg, #6366f1, #4f46e5); color: white; border: none; font-weight: 600; padding: 10px 20px; border-radius: 8px; box-shadow: 0 4px 10px rgba(99,102,241,0.3);">
                            <i class="fas fa-plus mr-2"></i>Tambah Buku Baru
                        </a>
                    </div>
                </div>

                {{-- Tabel Data --}}
                <div class="card-body p-0">
                    <div class="table-responsive px-4 pb-4">
                        <table id="data-buku" class="table table-hover table-modern mb-0" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 50px;">#</th>
                                    <th>Info Buku</th>
                                    <th>Kategori</th>
                                    <th>Penerbitan</th>
                                    <th class="text-center">Gambar</th>
                                    <th class="text-center" style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($buku as $item)
                                <tr>
                                    <td class="text-center" style="font-weight: 600; vertical-align: middle;">{{ $loop->iteration }}</td>
                                    
                                    <td style="vertical-align: middle;">
                                        <div style="font-weight: 700; color: #0f172a; font-size: 15px; margin-bottom: 4px;">{{ $item->judul_buku }}</div>
                                        <div style="font-size: 12px; color: #64748b;"><i class="fas fa-pen-nib text-primary mr-1" style="opacity:0.7"></i> {{ $item->pengarang }}</div>
                                    </td>
                                    
                                    <td style="vertical-align: middle;">
                                        <span class="badge" style="background: #e0e7ff; color: #4338ca; padding: 6px 12px; font-weight: 600;">{{ $item->kategori->nama_kategori }}</span>
                                    </td>
                                    
                                    <td style="vertical-align: middle;">
                                        <div style="font-size: 13px; color: #0f172a; font-weight: 500;"><i class="fas fa-building text-info mr-1"></i> {{ $item->penerbit }}</div>
                                        <div style="font-size: 13px; color: #64748b; margin-top: 4px;"><i class="fas fa-calendar-alt text-warning mr-1"></i> Tahun {{ $item->tahun_terbit }}</div>
                                    </td>
                                    
                                    <td class="text-center" style="vertical-align: middle;">
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="Cover" style="width: 45px; height: 60px; object-fit: cover; border-radius: 6px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                    </td>
                                    
                                    <td style="vertical-align: middle;">
                                        <form action="{{ route('admin.master.buku.destroy', $item->id) }}" method="POST" class="d-flex justify-content-center" style="gap: 6px;">
                                            <a href="{{ route('admin.master.buku.show', $item->id) }}" class="btn btn-sm btn-info text-white" data-toggle="tooltip" title="Lihat Detail" style="border-radius: 6px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.master.buku.edit', $item->id) }}" class="btn btn-sm btn-warning text-dark" data-toggle="tooltip" title="Ubah Data" style="border-radius: 6px; font-weight: 600;">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger hapus-data" data-toggle="tooltip" title="Hapus Permanen" style="border-radius: 6px;">
                                                <i class="fas fa-trash-alt"></i>
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
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $("#data-buku").DataTable({
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