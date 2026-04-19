<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>EL-KALA | @yield('title')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    <style>
        /* =====================================================
           GLOBAL OVERRIDES — MODERN DARK INDIGO THEME
        ===================================================== */
        :root {
            --primary:     #6366f1;
            --primary-dark:#4338ca;
            --primary-light:#a5b4fc;
            --accent:      #14b8a6;
            --sidebar-bg:  #1e1b4b;
            --sidebar-dark:#16134a;
            --sidebar-hover:#312e81;
            --sidebar-text:rgba(255,255,255,0.75);
            --sidebar-text-active:#ffffff;
            --navbar-bg:   #ffffff;
            --body-bg:     #f1f5f9;
            --card-bg:     #ffffff;
            --text-main:   #0f172a;
            --text-muted:  #64748b;
            --border:      #e2e8f0;
            --success:     #10b981;
            --danger:      #ef4444;
            --warning:     #f59e0b;
            --info:        #06b6d4;
        }

        body { font-family: 'Inter', sans-serif !important; }
        body.sidebar-mini { background: var(--body-bg) !important; }

        /* ---- SIDEBAR ---- */
        .main-sidebar {
            background: var(--sidebar-bg) !important;
            box-shadow: 4px 0 20px rgba(0,0,0,0.15) !important;
        }
        .brand-link {
            background: var(--sidebar-dark) !important;
            border-bottom: 1px solid rgba(255,255,255,0.08) !important;
            padding: 16px 20px !important;
            text-decoration: none !important;
            transition: background 0.2s !important;
        }
        .brand-link:hover { background: rgba(49,46,129,0.6) !important; }
        .brand-text { color: #ffffff !important; font-weight: 700 !important; font-size: 16px !important; letter-spacing: -0.3px !important; }

        .sidebar { background: transparent !important; }
        .nav-sidebar .nav-link {
            color: var(--sidebar-text) !important;
            border-radius: 10px !important;
            margin: 2px 8px !important;
            padding: 10px 14px !important;
            transition: all 0.2s !important;
            font-size: 13.5px !important;
            font-weight: 500 !important;
        }
        .nav-sidebar .nav-link:hover {
            background: var(--sidebar-hover) !important;
            color: var(--sidebar-text-active) !important;
        }
        .nav-sidebar .nav-link.active {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark)) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(99,102,241,0.35) !important;
        }
        .nav-sidebar .nav-link .nav-icon { color: inherit !important; }
        .nav-icon { width: 20px !important; }

        /* treeview submenu */
        .nav-treeview { background: transparent !important; }
        .nav-treeview .nav-link { color: rgba(255,255,255,0.6) !important; font-size: 13px !important; padding: 8px 14px 8px 30px !important; }
        .nav-treeview .nav-link:hover { background: rgba(255,255,255,0.06) !important; color: #fff !important; }
        .nav-treeview .nav-link.active { background: rgba(99,102,241,0.35) !important; color: #c7d2fe !important; }

        /* user panel in sidebar */
        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active { background: linear-gradient(135deg, var(--primary), var(--primary-dark)) !important; }

        /* ---- NAVBAR ---- */
        .main-header.navbar {
            background: var(--navbar-bg) !important;
            box-shadow: 0 2px 20px rgba(0,0,0,0.08) !important;
            border-bottom: none !important;
        }
        .main-header .nav-link { color: var(--text-main) !important; }

        /* ---- CONTENT WRAPPER ---- */
        .content-wrapper { background: var(--body-bg) !important; }

        /* ---- CONTENT HEADER ---- */
        .content-header h1 { font-size: 22px !important; font-weight: 700 !important; color: var(--text-main) !important; }
        .breadcrumb-item a { color: var(--primary) !important; }
        .breadcrumb-item.active { color: var(--text-muted) !important; }

        /* ---- CARDS ---- */
        .card {
            border: none !important;
            border-radius: 16px !important;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.04) !important;
            overflow: hidden !important;
        }
        .card-header {
            background: var(--card-bg) !important;
            border-bottom: 1px solid var(--border) !important;
            font-weight: 600 !important;
            padding: 16px 20px !important;
            color: var(--text-main) !important;
        }
        .card-body { padding: 20px !important; }

        /* ---- INFO BOXES (Dashboard Stats) ---- */
        .info-box {
            border-radius: 14px !important;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08) !important;
            transition: transform 0.25s, box-shadow 0.25s !important;
            border: none !important;
            overflow: hidden !important;
        }
        .info-box:hover {
            transform: translateY(-4px) !important;
            box-shadow: 0 8px 24px rgba(0,0,0,0.12) !important;
        }
        .info-box-icon { border-radius: 0 !important; width: 80px !important; }

        /* ---- BUTTONS ---- */
        .btn-primary { background: var(--primary) !important; border-color: var(--primary) !important; border-radius: 8px !important; font-weight: 500 !important; }
        .btn-primary:hover { background: var(--primary-dark) !important; border-color: var(--primary-dark) !important; }
        .btn-success { border-radius: 8px !important; font-weight: 500 !important; }
        .btn-danger  { border-radius: 8px !important; font-weight: 500 !important; }
        .btn-warning { border-radius: 8px !important; font-weight: 500 !important; }
        .btn-info    { border-radius: 8px !important; font-weight: 500 !important; }
        .btn-secondary { border-radius: 8px !important; font-weight: 500 !important; }
        .btn-sm { font-size: 12px !important; padding: 5px 12px !important; }

        /* ---- FORMS ---- */
        .form-control {
            border-radius: 10px !important;
            border: 1.5px solid var(--border) !important;
            font-size: 14px !important;
            padding: 10px 14px !important;
            transition: border-color 0.2s, box-shadow 0.2s !important;
        }
        .form-control:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.12) !important;
        }
        .input-group .input-group-text { border-radius: 10px 0 0 10px !important; border-color: var(--border) !important; }

        /* ---- TABLES ---- */
        .table thead th {
            background: #f8fafc !important;
            color: var(--text-muted) !important;
            font-size: 11px !important; font-weight: 600 !important;
            text-transform: uppercase !important; letter-spacing: 0.8px !important;
            border-bottom: 2px solid var(--border) !important;
            padding: 12px 16px !important;
        }
        .table tbody td { padding: 12px 16px !important; color: var(--text-main) !important; vertical-align: middle !important; font-size: 14px !important; }
        .table tbody tr:hover { background: #f8fafc !important; }

        /* ---- DATATABLES FIXES ---- */
        .dataTables_wrapper .form-control {
            padding: 4px 10px !important;
            height: auto !important;
            border-radius: 6px !important;
            display: inline-block !important;
            width: auto !important;
            margin: 0 5px !important;
        }
        .dataTables_wrapper .dataTables_length { margin-bottom: 20px !important; font-size: 13px !important; color: var(--text-muted) !important; }
        .dataTables_wrapper .dataTables_filter { margin-bottom: 20px !important; font-size: 13px !important; color: var(--text-muted) !important; }
        .dataTables_wrapper .dataTables_info { padding-top: 15px !important; color: var(--text-muted) !important; font-size: 13px !important; }
        .dataTables_wrapper .dataTables_paginate { padding-top: 10px !important; }

        /* ---- BADGES ---- */
        .badge { border-radius: 6px !important; font-size: 11px !important; font-weight: 600 !important; padding: 4px 8px !important; }

        /* ---- FOOTER ---- */
        .main-footer {
            background: var(--navbar-bg) !important;
            border-top: 1px solid var(--border) !important;
            color: var(--text-muted) !important;
            font-size: 13px !important;
            padding: 14px 20px !important;
        }

        /* ---- DROPDOWN ---- */
        .dropdown-menu {
            border: none !important;
            border-radius: 12px !important;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12) !important;
            padding: 8px !important;
        }
        .dropdown-item { border-radius: 8px !important; font-size: 14px !important; padding: 10px 14px !important; color: var(--text-main) !important; }
        .dropdown-item:hover { background: #f1f5f9 !important; color: var(--primary) !important; }
        .dropdown-divider { margin: 6px 0 !important; }

        /* ---- SELECT2 ---- */
        .select2-container--bootstrap4 .select2-selection { border-radius: 10px !important; border-color: var(--border) !important; }

        /* ---- ALERTS ---- */
        .alert { border-radius: 12px !important; border: none !important; font-size: 14px !important; }
        .alert-success { background: #d1fae5 !important; color: #065f46 !important; }
        .alert-danger  { background: #fee2e2 !important; color: #991b1b !important; }
        .alert-warning { background: #fef3c7 !important; color: #92400e !important; }
        .alert-info    { background: #e0f2fe !important; color: #0c4a6e !important; }

        /* ---- PAGINATION ---- */
        .page-item.active .page-link { background: var(--primary) !important; border-color: var(--primary) !important; border-radius: 8px !important; }
        .page-link { border-radius: 8px !important; margin: 0 2px !important; color: var(--primary) !important; border-color: var(--border) !important; }
        .page-link:hover { background: #e0e7ff !important; }

        /* booking card */
        .booking { height: 200px; object-fit: cover; }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            @include('admin.layout.navbar')
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            @include('admin.layout.sidebar')
        </aside>

        <div class="content-wrapper">
            <div class="content-header">
                @include('admin.layout.header')
            </div>
            <div class="content">
                @yield('content')
            </div>
        </div>

        <footer class="main-footer">
            @include('admin.layout.footer')
        </footer>
    </div>

    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    @stack('scripts')

    <script>
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

        $(function() {
            $('.select2').select2({ theme: 'bootstrap4' })
        });

        const APP_URL = {!! json_encode(url('/')) !!}
    </script>
</body>
</html>