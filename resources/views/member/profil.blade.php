@extends('member.layout.main')

@section('title', 'Profil Saya')

@section('content')
<div class="container pt-4">
    <div class="row">
        <div class="col-lg-8">
            {{-- Tampilkan notifikasi sukses jika ada --}}
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Profil Saya</h3>
                </div>
                <form role="form" action="{{ route('member.profil') }}"
                    method="POST" enctype="multipart/form-data" id="profilForm">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text"
                                        class="form-control @error('nama') is-invalid @enderror"
                                        name="nama" id="nama"
                                        placeholder="Nama Lengkap"
                                        value="{{ old('nama', Auth::user()->nama) }}"
                                        data-initial-value="{{ Auth::user()->nama }}" readonly>
                                    @error('nama')
                                        <span id="nama-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <input type="text"
                                        class="form-control @error('alamat') is-invalid @enderror"
                                        name="alamat" id="alamat"
                                        placeholder="Alamat"
                                        value="{{ old('alamat', Auth::user()->alamat) }}"
                                        data-initial-value="{{ Auth::user()->alamat }}" readonly>
                                    @error('alamat')
                                        <span id="alamat-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    {{-- Email tidak bisa diubah --}}
                                    <input type="email" class="form-control"
                                        name="email" id="email" placeholder="Email"
                                        value="{{ Auth::user()->email }}"
                                        data-initial-value="{{ Auth::user()->email }}" readonly>
                                </div>

                                <div class="form-group mb-0">
                                    <label for="image">Gambar</label>
                                    <input type="hidden" name="oldImage"
                                        value="{{ Auth::user()->image }}">
                                    <div class="input-group @error('image') is-invalid @enderror">
                                        <div class="custom-file">
                                            <input type="file"
                                                class="custom-file-input @error('image') is-invalid @enderror"
                                                id="image" name="image"
                                                data-default-src="{{ Auth::user()->image }}"
                                                accept="image/x-png,image/jpg,image/jpeg"
                                                onchange="previewImage()" disabled>
                                            <label class="custom-file-label"
                                                for="image">Pilih file...</label>
                                        </div>
                                    </div>
                                    @error('image')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4 d-flex justify-content-center align-items-center">
                                <div class="form-group">
                                    <img class="img-preview img-fluid d-block"
                                        src="{{ asset('storage/' . Auth::user()->image) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-secondary"
                            id="toggleButton">Klik untuk Ubah Profil</button>
                        <button type="button" class="btn btn-danger d-none"
                            id="batal">Batal</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Inisialisasi plugin file input kustom
        bsCustomFileInput.init();

        // Fungsi untuk mengaktifkan/menonaktifkan mode edit
        function toggleEditMode(isEditMode, batal = false) {
            // Mengubah teks dan tipe tombol utama (Ubah Profil/Simpan Perubahan)
            $('#toggleButton')
                .removeClass(isEditMode ? 'btn-secondary' : 'btn-primary')
                .addClass(isEditMode ? 'btn-primary' : 'btn-secondary')
                .text(isEditMode ? 'Simpan Perubahan' : 'Klik untuk Ubah Profil')
                .attr('type', isEditMode ? 'submit' : 'button');

            // Menampilkan/menyembunyikan tombol Batal
            $('#batal').toggleClass('d-none', !isEditMode);

            // Mengaktifkan/menonaktifkan input teks
            $('#nama, #alamat').prop('readonly', !isEditMode);

            // Fokus pada input nama saat mode edit aktif
            if (isEditMode) {
                $('#nama').focus();
            }

            // Mengaktifkan/menonaktifkan input gambar
            if (isEditMode || batal) {
                $('#image').prop('disabled', !isEditMode);
            }
        }

        // Event handler untuk tombol utama (Ubah Profil/Simpan Perubahan)
        $('#toggleButton').click(function(e) {
            e.preventDefault();
            // Cek apakah mode edit akan diaktifkan (saat tombol masih 'Klik untuk Ubah Profil')
            if ($(this).hasClass('btn-secondary')) {
                toggleEditMode(true); // Aktifkan mode edit
            } else {
                // Jika tombol adalah 'Simpan Perubahan', submit form
                $('#profilForm').submit();
            }
        });

        // Event handler untuk tombol Batal
        $('#batal').click(function() {
            toggleEditMode(false, true); // Nonaktifkan mode edit dan reset input

            // Kembalikan nilai input teks ke nilai awal dari database
            $('#nama, #alamat').each(function() {
                $(this).val($(this).data('initial-value')).prop('readonly', true);
            });

            // Kosongkan pratinjau gambar dan label file
            $('.img-preview').attr('src', '{{ asset('storage/' . Auth::user()->image) }}');
            $('.custom-file-label').text('Pilih file...');

            // Hapus kelas error validasi (jika ada)
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
        });
    });

    // Fungsi untuk menampilkan pratinjau gambar yang dipilih
    function previewImage() {
        const image = $('#image');
        const imgPreview = $('.img-preview');
        const file = image[0].files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                imgPreview.attr('src', event.target.result);
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush