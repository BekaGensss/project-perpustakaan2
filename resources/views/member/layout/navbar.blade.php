<nav class="navbar navbar-expand-lg sticky-top" style="
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    box-shadow: 0 2px 15px rgba(0,0,0,0.06);
    padding: 10px 0;
    border-bottom: 1px solid rgba(0,0,0,0.05);
">
    <div class="container">
        {{-- Brand --}}
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}" style="gap:8px; text-decoration:none;">
            <div style="position:relative; width:36px; height:36px; display:flex; align-items:center; justify-content:center; border-radius:12px; background:rgba(99,102,241,0.1); border: 1px solid rgba(99,102,241,0.1);">
                <i class="fas fa-book-reader" style="color:#6366f1; font-size:16px;"></i>
            </div>
            <div style="line-height:1.1;">
                <span style="font-family: 'Inter', sans-serif; font-weight: 800; font-size: 20px; letter-spacing: -0.5px; color: #1e1b4b;">
                    EL<span style="color: #6366f1;">KALA</span>
                </span>
            </div>
        </a>

        {{-- Hamburger Toggler --}}
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#memberNavbar"
                aria-controls="memberNavbar" aria-expanded="false" aria-label="Toggle navigation"
                style="border:1px solid rgba(0,0,0,0.1);padding:6px 10px;">
            <i class="fas fa-bars" style="color:#1e1b4b;font-size:16px;"></i>
        </button>

        <div class="collapse navbar-collapse" id="memberNavbar">

            {{-- Navigasi Kiri --}}
            <ul class="navbar-nav mr-auto" style="margin-left:16px;">
                {{-- Beranda --}}
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="{{ url('/') }}"
                       style="color:#475569;font-size:13.5px;font-weight:500;padding:8px 12px;border-radius:8px;transition:all 0.2s;gap:6px;
                       {{ request()->is('/') ? 'background:rgba(99,102,241,0.08);color:#6366f1;' : '' }}">
                        <i class="fas fa-home" style="font-size:13px;"></i>
                        Beranda
                    </a>
                </li>
                {{-- Katalog --}}
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="{{ route('member.index') }}"
                       style="color:#475569;font-size:13.5px;font-weight:500;padding:8px 12px;border-radius:8px;transition:all 0.2s;gap:6px;
                       {{ request()->is('katalog') || request()->is('detail-buku/*') ? 'background:rgba(99,102,241,0.08);color:#6366f1;' : '' }}">
                        <i class="fas fa-layer-group" style="font-size:13px;"></i>
                        Katalog
                    </a>
                </li>
                @guest
                    {{-- Panduan --}}
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="{{ url('/#panduan') }}"
                           style="color:#475569;font-size:13.5px;font-weight:500;padding:8px 12px;border-radius:8px;transition:all 0.2s;gap:6px;">
                            <i class="fas fa-book-open" style="font-size:13px;"></i>
                            Panduan
                        </a>
                    </li>
                    {{-- FAQ --}}
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="{{ url('/#faq') }}"
                           style="color:#475569;font-size:13.5px;font-weight:500;padding:8px 12px;border-radius:8px;transition:all 0.2s;gap:6px;">
                            <i class="fas fa-question-circle" style="font-size:13px;"></i>
                            FAQ
                        </a>
                    </li>
                @endguest
                @auth
                    {{-- Links for logged in users remain with light styling --}}
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="{{ route('member.dataKeranjang', auth()->user()->id) }}"
                           style="color:#475569;font-size:13.5px;font-weight:500;padding:8px 12px;border-radius:8px;transition:all 0.2s;gap:6px;
                           {{ Request::segment(2) == 'data-keranjang' ? 'background:rgba(99,102,241,0.08);color:#6366f1;' : '' }}">
                            <i class="fas fa-shopping-cart" style="font-size:13px;"></i>
                            Keranjang
                            @if(Auth::user()->totalKeranjang() > 0)
                                <span style="background:#ef4444;color:white;border-radius:20px;padding:1px 7px;font-size:11px;font-weight:700;">
                                    {{ Auth::user()->totalKeranjang() }}
                                </span>
                            @endif
                        </a>
                    </li>
                    {{-- Add other auth links here if needed, following the same color pattern --}}
                @endauth
            </ul>

            {{-- Navigasi Kanan --}}
            <ul class="navbar-nav ml-auto" style="gap: 10px;">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                            id="memberDropdown" role="button" data-toggle="dropdown" aria-expanded="false"
                            style="color:#1e1b4b;gap:8px;padding:6px 12px;border-radius:10px;border:1px solid rgba(0,0,0,0.08);">
                            <img src="{{ asset('storage/' . Auth::user()->image) }}"
                                 class="rounded-circle profil-img"
                                 style="border:2px solid rgba(99,102,241,0.2);"
                                 alt="Avatar" loading="lazy">
                            <span style="font-size:13px; font-weight:600;">{{ Str::limit(Auth::user()->nama, 16) }}</span>
                            <i class="fas fa-chevron-down" style="font-size:10px; opacity:0.7;"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" style="min-width:180px; margin-top:8px; border:none; box-shadow:0 10px 30px rgba(0,0,0,0.1);">
                            <a class="dropdown-item" href="{{ route('member.profil') }}">
                                <i class="fas fa-user-circle" style="color:#6366f1; width:18px;"></i>&nbsp; Profil Saya
                            </a>
                            <a class="dropdown-item" href="{{ route('member.ganti-password') }}">
                                <i class="fas fa-key" style="color:#14b8a6; width:18px;"></i>&nbsp; Ganti Password
                            </a>
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                                @csrf
                                <button type="submit" class="dropdown-item" style="background:none;border:none;width:100%;text-align:left;cursor:pointer;font-size:14px;padding:10px 14px;">
                                    <i class="fas fa-sign-out-alt" style="color:#ef4444; width:18px;"></i>&nbsp; Logout
                                </button>
                            </form>
                        </div>
                    </li>
                @else
                    {{-- Guest Buttons --}}
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="daftarModal();"
                           style="color:#475569;font-weight:600;font-size:13.5px;padding:8px 12px;">
                            Daftar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-masuk-nav" href="#" onclick="loginModal();"
                           style="background:#6366f1;color:white;border-radius:10px;padding:8px 20px;font-weight:600;font-size:13.5px;transition:all 0.3s;
                           box-shadow: 0 4px 12px rgba(99,102,241,0.3);">
                            <i class="fas fa-sign-in-alt mr-1"></i> Masuk
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>