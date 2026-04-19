<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>EL-KALA | @yield('title')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

    <style>
        /* =====================================================
           MEMBER GLOBAL THEME — MODERN DARK + INDIGO
        ===================================================== */
        :root {
            --primary:      #6366f1;
            --primary-dark: #4338ca;
            --accent:       #14b8a6;
            --body-bg:      #f8fafc;
            --card-bg:      #ffffff;
            --text-main:    #0f172a;
            --text-muted:   #64748b;
            --border:       #e2e8f0;
            --success:      #10b981;
            --danger:       #ef4444;
        }

        body { display: flex; flex-direction: column; background: var(--body-bg); color: var(--text-main); font-family: 'Inter', sans-serif !important; }
        
        html {
            scroll-behavior: smooth;
            scroll-padding-top: 80px; /* Offset for sticky navbar */
        }
        html, body { height: 100%; margin: 0; }
        .content { flex: 1; }

        /* ---- BUTTONS ---- */
        .btn { border-radius: 8px !important; font-weight: 500 !important; font-size: 13px !important; }
        .btn-primary { background: var(--primary) !important; border-color: var(--primary) !important; }
        .btn-primary:hover { background: var(--primary-dark) !important; border-color: var(--primary-dark) !important; }
        .btn-sm { padding: 6px 14px !important; font-size: 12px !important; }

        /* ---- CARDS (Book Cards) ---- */
        .card {
            border: none !important;
            border-radius: 16px !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06), 0 0 1px rgba(0,0,0,0.04) !important;
            transition: transform 0.25s, box-shadow 0.25s !important;
            overflow: hidden !important;
            background: var(--card-bg) !important;
        }
        .card:hover {
            transform: translateY(-4px) !important;
            box-shadow: 0 12px 28px rgba(0,0,0,0.1) !important;
        }
        .card-header {
            background: #f8fafc !important;
            border-bottom: 1px solid var(--border) !important;
            padding: 0 !important;
        }
        .card-header img { height: 180px !important; width: 100% !important; object-fit: cover !important; }
        .card-body { padding: 14px 16px !important; }
        .card-footer {
            background: transparent !important;
            border-top: 1px solid var(--border) !important;
            padding: 10px 16px !important;
        }

        /* ---- BADGES ---- */
        .badge { border-radius: 6px !important; font-size: 11px !important; font-weight: 600 !important; }
        .badge-success { background: #d1fae5 !important; color: #065f46 !important; }
        .badge-danger  { background: #fee2e2 !important; color: #991b1b !important; }
        .badge-info    { background: #e0f2fe !important; color: #0c4a6e !important; }
        .badge-primary { background: #e0e7ff !important; color: #3730a3 !important; }
        .badge-light   { background: #f1f5f9 !important; color: #475569 !important; }

        /* ---- RIBBON ---- */
        .ribbon-wrapper { position: absolute; overflow: hidden; top: 0; right: 0; z-index: 10; width: 90px; height: 90px; }
        .ribbon { font-weight: 600; font-size: 11px; color: #fff; text-align: center; line-height: 30px;
                  transform: rotate(45deg); position: relative; padding: 0; top: 14px; right: -22px; width: 100px;
                  box-shadow: 0 2px 8px rgba(0,0,0,0.2); border-radius: 0; }
        .ribbon.bg-success { background: linear-gradient(135deg, #10b981, #059669) !important; }
        .ribbon.bg-danger  { background: linear-gradient(135deg, #ef4444, #dc2626) !important; }

        /* ---- FORMS ---- */
        .form-control {
            border-radius: 10px !important; border: 1.5px solid var(--border) !important;
            font-size: 14px !important; transition: border-color 0.2s, box-shadow 0.2s !important;
        }
        .form-control:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.12) !important;
        }

        /* ---- ALERTS ---- */
        .alert { border-radius: 12px !important; border: none !important; font-size: 14px !important; font-weight: 500 !important; }
        .alert-success { background: #d1fae5 !important; color: #065f46 !important; }
        .alert-danger  { background: #fee2e2 !important; color: #991b1b !important; }
        .alert-info    { background: #e0f2fe !important; color: #0c4a6e !important; }

        /* ---- MODALS ---- */
        .modal-content { border-radius: 20px !important; border: none !important; overflow: hidden !important; }
        .modal-header { background: linear-gradient(135deg, #6366f1, #4338ca) !important; color: white !important; padding: 16px 24px !important; }
        .modal-header h4 { color: white !important; font-weight: 700 !important; margin: 0 !important; }
        .modal-header .close { color: white !important; opacity: 0.8 !important; }
        .modal-body { padding: 24px !important; }
        .modal-footer { padding: 16px 24px !important; border-top: 1px solid var(--border) !important; }

        /* ---- TABLES ---- */
        .table thead th {
            background: #f8fafc !important; color: var(--text-muted) !important;
            font-size: 11px !important; font-weight: 600 !important;
            text-transform: uppercase !important; letter-spacing: 0.7px !important;
            border-bottom: 2px solid var(--border) !important; border-top: none !important;
        }
        .table tbody td { font-size: 14px !important; color: var(--text-main) !important; vertical-align: middle !important; }

        /* ---- PAGINATION ---- */
        .page-item.active .page-link { background: var(--primary) !important; border-color: var(--primary) !important; border-radius: 8px !important; }
        .page-link { border-radius: 8px !important; margin: 0 2px !important; color: var(--primary) !important; border-color: var(--border) !important; }

        /* ---- H1 PAGE TITLE ---- */
        header.container h1 { font-size: 22px !important; font-weight: 700 !important; color: var(--text-main) !important; margin-bottom: 0 !important; }

        /* Images */
        .img-pinjam { height: 100px; object-fit: cover; }
        .profil-img { height: 40px; width: 40px; object-fit: cover; }
    </style>
</head>
<body style="height: auto;" data-spy="scroll" data-target="#memberNavbar" data-offset="100">
    <div class="content">
        @include('member.layout.navbar')
        @hasSection('title')
        <header class="container pt-4" style="padding-bottom:8px;">
            <h1>@yield('title')</h1>
        </header>
        @endif
        @yield('content')
    </div>

    @include('member.layout.footer')

    {{-- MODAL LOGIN DAN DAFTAR UMUM --}}
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('loginMember') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Login Member</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <p>Belum punya akun? <span class="text-primary" style="cursor: pointer;"
                                onclick="daftarModal();">Daftar di sini</span></p>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="daftarMemberModal" tabindex="-1" role="dialog" aria-labelledby="daftarMemberModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form id="daftarMemberForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Daftar Member</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="nama">Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control" id="nama"
                                        placeholder="Nama lengkap">
                                    <span class="invalid-feedback" role="alert"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <input type="text" name="alamat" class="form-control" id="alamat"
                                        placeholder="Alamat">
                                    <span class="invalid-feedback" role="alert"></span>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" id="email"
                                        placeholder="Email">
                                    <span class="invalid-feedback" role="alert"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control" id="password"
                                        placeholder="Password">
                                    <span class="invalid-feedback" role="alert"></span>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="konfirmasi_password">Konfirmasi Password</label>
                                    <input type="password" name="konfirmasi_password" class="form-control"
                                        id="konfirmasi_password" placeholder="Konfirmasi Password">
                                    <span class="invalid-feedback" role="alert"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <p>Sudah punya akun? <span class="text-primary" style="cursor: pointer;"
                                onclick="loginModal();">Login di sini</span></p>
                        <button type="submit" class="btn btn-primary">Daftar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

    @stack('scripts')

    <script>
        const APP_URL = {!! json_encode(url('/')) !!}
        toastr.options = {
            "closeButton": true, "debug": false, "newestOnTop": true,
            "progressBar": true, "positionClass": "toast-top-right",
            "preventDuplicates": false, "onclick": null,
            "showDuration": "300", "hideDuration": "1000",
            "timeOut": "5000", "extendedTimeOut": "1000",
            "showEasing": "swing", "hideEasing": "linear",
            "showMethod": "fadeIn", "hideMethod": "fadeOut"
        }
        @if (Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif
        @if (Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif
        @if (Session::has('info'))
            toastr.info("{{ Session::get('info') }}");
        @endif

        function daftarModal() {
            $('#daftarMemberModal').modal('show');
            $('#loginModal').modal('hide');
        }

        function loginModal() {
            $('#daftarMemberModal').modal('hide');
            $('#loginModal').modal('show');
        }

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        });

        $('#daftarMemberForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('registerMember') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.success);
                        $('#daftarMemberModal').modal('hide');
                        $('#daftarMemberForm')[0].reset();
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $('.form-control').removeClass('is-invalid');
                        $('.invalid-feedback').empty();
                        $.each(errors, function(key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).next('.invalid-feedback').html(value[0]);
                        });
                    } else {
                        toastr.error('Terjadi kesalahan server.', 'Error');
                    }
                }
            });
        });

        // Anchor Smooth Scroll Fix
        $(document).on('click', 'a[href^="#"], a[href^="' + APP_URL + '/#"], a[href^="/#"]', function(e) {
            let href = $(this).attr('href');
            let hash = href.substring(href.indexOf('#'));
            if (hash && $(hash).length > 0) {
                e.preventDefault();
                const targetOffset = $(hash).offset().top - 85;
                $('html, body').animate({
                    scrollTop: targetOffset
                }, 700);
                
                // Close mobile menu if open
                $('.navbar-collapse').collapse('hide');
            }
        });
    </script>
</body>
</html>