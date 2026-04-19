@extends('member.layout.main')

@section('title', 'Ganti Password')

@section('content')
<div class="container pt-4">
    {{-- Menghapus 'justify-content-center' agar form rata kiri --}}
    <div class="row">
        {{-- Menggunakan col-md-8 col-lg-6 untuk membatasi lebar card --}}
        <div class="col-md-8 col-lg-6">

            {{-- Tampilkan notifikasi sukses --}}
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            {{-- Tampilkan notifikasi error --}}
            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Ganti Password</h3>
                </div>
                <form role="form" action="{{ route('member.ganti-password') }}"
                    method="POST" id="gantiPasswordForm">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="password-saat-ini">Password Saat Ini</label>
                            <input type="password"
                                class="form-control @error('password_saat_ini') is-invalid @enderror"
                                name="password_saat_ini" id="password-saat-ini"
                                placeholder="Password Saat Ini">
                            @error('password_saat_ini')
                                <span id="password-saat-ini-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password-baru">Password Baru</label>
                            <input type="password"
                                class="form-control @error('password_baru') is-invalid @enderror"
                                name="password_baru" id="password-baru"
                                placeholder="Password Baru">
                            @error('password_baru')
                                <span id="password-baru-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="konfirmasi-password">Konfirmasi Password</label>
                            <input type="password"
                                class="form-control @error('konfirmasi_password') is-invalid @enderror"
                                name="konfirmasi_password" id="konfirmasi-password"
                                placeholder="Konfirmasi Password">
                            @error('konfirmasi_password')
                                <span id="konfirmasi-password-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Ubah Password</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Fokuskan pada input pertama saat halaman dimuat
        $('#password-saat-ini').focus();
    });
</script>
@endpush