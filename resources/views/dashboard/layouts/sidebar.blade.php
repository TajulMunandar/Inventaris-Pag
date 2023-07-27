<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand">
        <a class="navbar-brand fs-5 fw-bold" href="/dashboard/">
            <img src="{{ asset('images/logos/pag.png') }}" class="img-fluid" alt="Inventaris PAG" width="700">
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @if (auth()->user()->isAdmin == 1)
            <li class="menu-item {{ Request::is('dashboard/peminjaman') ? 'active' : '' }}">
                <a href="{{ route('peminjaman.index') }}" class="menu-link">
                    <i class="fa-calendar-week fa-solid  me-3"></i>
                    <div data-i18n="Analytics">Peminjaman</div>
                </a>
            </li>
        @else
        {{-- Sidebar --}}
        <li class="menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
            <a href="{{ route('index') }}" class="menu-link">
                <i class="fa-duotone fa-grid-2 me-3"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <li class="menu-item {{ Request::is('dashboard/peminjaman') ? 'active' : '' }}">
            <a href="{{ route('peminjaman.index') }}" class="menu-link">
                <i class="fa-calendar-week fa-solid  me-3"></i>
                <div data-i18n="Analytics">Peminjaman</div>
            </a>
        </li>

        <li class="menu-item {{ Request::is('dashboard/laporan*') ? 'active' : '' }}">
            <a href="{{ route('laporan-utama.index') }}" class="menu-link">
                <i class="fa-book fa-solid  me-3"></i>
                <div data-i18n="Analytics">Laporan</div>
            </a>
        </li>

        <li class="menu-item {{ Request::is('dashboard/barang') ? 'active' : '' }}">
            <a href="{{ route('barang.index') }}" class="menu-link">
                <i class="fa-box-open fa-solid  me-3"></i>
                <div data-i18n="Analytics">Barang</div>
            </a>
        </li>

        <li class="menu-item {{ Request::is('dashboard/kategori') ? 'active' : '' }}">
            <a href="{{ route('kategori.index') }}" class="menu-link">
                <i class="fa-list fa-solid fa-grid-2 me-3"></i>
                <div data-i18n="Analytics">Kategori</div>
            </a>
        </li>

        <li class="menu-item {{ Request::is('dashboard/user') ? 'active' : '' }}">
            <a href="{{ route('user.index') }}" class="menu-link">
                <i class="fa-user fa-solid fa-grid-2 me-3"></i>
                <div data-i18n="Analytics">User</div>
            </a>
        </li>
        @endif
        {{-- end Sidebar --}}
    </ul>
</aside>