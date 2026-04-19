@extends('admin.layout.main')
@section('title', 'Master Kategori')
@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- Header Page Kategori --}}
        <div class="col-12 mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h4 style="font-weight: 700; color: #0f172a; margin: 0;"><i class="fas fa-tags text-primary mr-2"></i> Kategori Buku</h4>
                <p class="text-muted mt-1 mb-0" style="font-size: 14px;">Kelola klasifikasi dan kelompok buku di perpustakaan.</p>
            </div>
            <button class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#categoryModal" style="background: linear-gradient(135deg, #6366f1, #4f46e5); border: none; font-weight: 600; padding: 10px 20px; border-radius: 8px;">
                <i class="fas fa-plus mr-2"></i>Tambah Kategori
            </button>
        </div>

        {{-- Daftar Kategori yang Diambil dari Controller --}}
        @foreach ($kategori as $index => $item)
            @php
                // Array warna gradient untuk tampilan dinamis (tailwind colors)
                $gradients = [
                    'linear-gradient(135deg, #3b82f6, #1d4ed8)', // blue
                    'linear-gradient(135deg, #10b981, #047857)', // emerald
                    'linear-gradient(135deg, #8b5cf6, #5b21b6)', // violet
                    'linear-gradient(135deg, #f59e0b, #b45309)', // amber
                    'linear-gradient(135deg, #ec4899, #be185d)', // pink
                    'linear-gradient(135deg, #14b8a6, #0f766e)'  // teal
                ];
                $gradient = $gradients[$index % count($gradients)];
            @endphp
            <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-4">
                <div class="card border-0 h-100" style="border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: all 0.3s ease; cursor: pointer; overflow: hidden;"
                     onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.1)'" 
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.05)'"
                     data-toggle="modal" data-target="#categoryModal" data-kategori="{{ $item->nama_kategori }}" data-id="{{ $item->id }}">
                    
                    <div style="height: 6px; width: 100%; background: {{ $gradient }};"></div>
                    
                    <div class="card-body p-4 d-flex align-items-center">
                        <div style="width: 50px; height: 50px; border-radius: 12px; background: {{ $gradient }}; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; font-weight: 700; box-shadow: 0 4px 10px rgba(0,0,0,0.1); margin-right: 16px; flex-shrink: 0;">
                            {{ substr($item->nama_kategori, 0, 1) }}
                        </div>
                        <div>
                            <h6 style="font-weight: 700; color: #0f172a; margin: 0 0 4px 0; font-size: 16px;">{{ $item->nama_kategori }}</h6>
                            <div style="font-size: 13px; color: #64748b;"><i class="fas fa-book text-muted mr-1"></i> {{ $item->buku_count }} Koleksi</div>
                        </div>
                        <div class="ml-auto" style="color: #cbd5e1;">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    </div>{{-- Modal Tambah/Edit Kategori --}}
<div class="modal fade" id="categoryModal" data-backdrop="static" tabindex="-1"
    role="dialog"
    aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="categoryModalLabel">Tambah Kategori Baru</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            {{-- Form Kategori (Digunakan untuk Create dan Update) --}}
            <form action="{{ route('admin.master.kategori.store') }}"
                method="POST" id="kategoriForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_kategori">Nama Kategori</label>
                        <input type="text" class="form-control"
                            id="nama_kategori" name="nama_kategori" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    {{-- Tombol Simpan/Ubah --}}
                    <button type="submit" class="btn btn-primary simpan-ubah">Simpan</button>
                </div>
            </form>
            {{-- Form Hapus akan disuntikkan di sini oleh JS --}}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Event listener saat info-box (kategori) diklik
    $('.info-box').click(function() {
        var attr = $(this).attr('data-kategori');
        var form = $('#kategoriForm');
        var methodInput = form.find('input[name="_method"]');
        var idInput = form.find('input[name="id"]');
        var formHapus = $('#hapusKategoriForm'); // Seleksi form hapus by ID

        // === Logika untuk Mode EDIT/DELETE ===
        if (typeof attr !== 'undefined' && attr !== false) {
            var nama_kategori = $(this).attr('data-kategori');
            var id_kategori = $(this).attr('data-id');

            $('#categoryModalLabel').text('Ubah Kategori');
            $('.simpan-ubah').text('Ubah');
            $('#nama_kategori').val(nama_kategori);
            
            // Set URL action ke rute update (PUT)
            form.attr('action', '{{ url('admin/master/kategori/') }}/' + id_kategori);

            // Jika input _method belum ada, tambahkan. Jika sudah ada, update valuenya.
            if (methodInput.length === 0) {
                form.append('<input type="hidden" name="_method" value="PUT">');
                form.append('<input type="hidden" name="id" value="' + id_kategori + '">');
            } else {
                methodInput.val('PUT');
                if (idInput.length === 0) {
                    form.append('<input type="hidden" name="id" value="' + id_kategori + '">');
                } else {
                    idInput.val(id_kategori);
                }
            }

            // Tambahkan tombol dan form Hapus (DELETE) di dalam modal-footer
            if (formHapus.length === 0) {
                $(`
                    <form action="{{ url('admin/master/kategori/') }}/` + id_kategori + `" method="POST" id="hapusKategoriForm" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger hapus-data">Hapus</button>
                    </form>
                `).insertAfter(".simpan-ubah");
            } else {
                // Jika form hapus sudah ada, update action-nya
                formHapus.attr('action', '{{ url('admin/master/kategori/') }}/' + id_kategori);
            }

        // === Logika untuk Mode TAMBAH BARU (CREATE) ===
        } else {
            $('#categoryModalLabel').text('Tambah Kategori Baru');
            $('.simpan-ubah').text('Simpan');
            $('#nama_kategori').val('');
            
            // Set URL action ke rute store (POST)
            form.attr('action', '{{ route('admin.master.kategori.store') }}');

            // Hapus input _method (PUT/DELETE) karena ini mode POST
            if (methodInput.length > 0) {
                methodInput.remove();
            }
            if (idInput.length > 0) {
                idInput.remove();
            }
            // Hapus tombol dan form Hapus jika ada
            if (formHapus.length > 0) {
                formHapus.remove();
            }
        }
    });

    // Konfirmasi dan Submit Form Hapus
    $(document).on('click', '.hapus-data', function() {
        var form = $(this).closest("form");
        if (confirm('Yakin ingin menghapus data??')) {
            form.submit();
        }
    });
</script>
@endpush