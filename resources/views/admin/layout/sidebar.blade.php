{{-- SIDEBAR BRAND --}}
<a href="{{ route('admin.dashboard') }}" class="brand-link d-flex align-items-center" style="text-decoration:none; gap:10px;">
    <div style="position:relative; width:34px; height:34px; display:flex; align-items:center; justify-content:center; border-radius:10px; background:rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15); box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
        <i class="fas fa-book-reader" style="color:#38bdf8; font-size:15px;"></i>
    </div>
    <div style="line-height:1.1;">
        <span style="font-family: 'Inter', sans-serif; font-weight: 800; font-size: 19px; letter-spacing: -0.5px; color: #ffffff; text-shadow: 0 2px 4px rgba(0,0,0,0.2);">
            EL<span style="color: #38bdf8;">KALA</span>
        </span>
    </div>
</a>

{{-- SIDEBAR MENU --}}
<div class="sidebar">
    <nav class="mt-2">
        @php
            $master_active = request()->is('admin/master/*');
        @endphp

        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview"
            role="menu" data-accordion="false">

            {{-- Dashboard --}}
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-chart-pie"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            {{-- Data Master (Treeview) --}}
            <li class="nav-item has-treeview {{ $master_active ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ $master_active ? 'active' : '' }}">
                    <i class="fas fa-database nav-icon"></i>
                    <p>
                        Data Master
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('admin.master.kategori.index') }}"
                            class="nav-link {{ request()->is('admin/master/kategori') || request()->is('admin/master/kategori/*') ? 'active' : '' }}">
                            <i class="fas fa-tags nav-icon"></i>
                            <p>Kategori</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.master.buku.index') }}"
                            class="nav-link {{ request()->is('admin/master/buku') || request()->is('admin/master/buku/*') ? 'active' : '' }}">
                            <i class="fas fa-book nav-icon"></i>
                            <p>Buku</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.master.user.index') }}"
                            class="nav-link {{ request()->is('admin/master/user') || request()->is('admin/master/user/*') ? 'active' : '' }}">
                            <i class="fas fa-user-friends nav-icon"></i>
                            <p>User / Anggota</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Data Transaksi (Treeview) --}}
            <li class="nav-item has-treeview {{ request()->is('admin/transaksi/*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->is('admin/transaksi/*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-exchange-alt"></i>
                    <p>
                        Transaksi
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('admin.transaksi.booking.index') }}"
                            class="nav-link {{ Request::segment(3) == 'booking' ? 'active' : '' }}">
                            <i class="fas fa-clipboard-list nav-icon"></i>
                            <p>Booking</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.transaksi.peminjaman.index') }}"
                            class="nav-link {{ Request::segment(3) == 'peminjaman' && !request()->is('*/pengembalian') ? 'active' : '' }}">
                            <i class="fas fa-hand-holding-heart nav-icon"></i>
                            <p>Peminjaman</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.transaksi.peminjaman.pengembalian') }}"
                            class="nav-link {{ request()->is('*/pengembalian') ? 'active' : '' }}">
                            <i class="fas fa-undo-alt nav-icon"></i>
                            <p>Pengembalian</p>
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    </nav>
</div>