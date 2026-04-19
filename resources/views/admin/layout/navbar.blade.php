{{-- Navigasi Sisi Kiri (Tombol Toggle Sidebar) --}}
<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
            <i class="fas fa-bars" style="font-size:18px; color:#374151;"></i>
        </a>
    </li>
</ul>

{{-- Navigasi Sisi Kanan (Dropdown Profil) --}}
<ul class="navbar-nav ml-auto" style="align-items:center;">

    {{-- Badge Info Singkat --}}
    <li class="nav-item" style="margin-right:8px;">
        <span style="
            background:#f1f5f9; padding:6px 14px; border-radius:20px;
            font-size:13px; font-weight:500; color:#64748b;
        ">
            <i class="fas fa-circle" style="color:#10b981; font-size:8px; margin-right:6px;"></i>
            Admin
        </span>
    </li>

    {{-- Profile Dropdown --}}
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#"
            id="adminProfileDropdown" role="button" data-toggle="dropdown" aria-expanded="false"
            style="gap:10px; padding:6px 12px;">
            <img src="{{ asset('storage/' . Auth::user()->image) }}"
                class="rounded-circle"
                style="width:36px;height:36px;object-fit:cover;border:2px solid #e0e7ff;"
                alt="Avatar" loading="lazy">
            <div style="text-align:left; line-height:1.2;">
                <div style="font-weight:600; font-size:13px; color:#0f172a;">{{ Str::limit(Auth::user()->nama, 18) }}</div>
                <div style="font-size:11px; color:#6366f1; font-weight:500;">Administrator</div>
            </div>
            <i class="fas fa-chevron-down" style="font-size:11px; color:#9ca3af; margin-left:2px;"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" style="min-width:180px; margin-top:8px;">
            <a class="dropdown-item" href="{{ route('admin.profil') }}">
                <i class="fas fa-user-circle" style="color:#6366f1; width:18px;"></i>&nbsp; Profil Saya
            </a>
            <a class="dropdown-item" href="{{ route('admin.ganti-password') }}">
                <i class="fas fa-key" style="color:#14b8a6; width:18px;"></i>&nbsp; Ganti Password
            </a>
            <div class="dropdown-divider"></div>
            <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                @csrf
                <button type="submit" class="dropdown-item" style="background:none;border:none;width:100%;text-align:left;cursor:pointer;">
                    <i class="fas fa-sign-out-alt" style="color:#ef4444; width:18px;"></i>&nbsp; Logout
                </button>
            </form>
        </div>
    </li>
</ul>