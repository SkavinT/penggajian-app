<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');
    .sidebar-modern {
        background: linear-gradient(135deg, #e1251b 80%, #b71c1c 100%);
        color: #fff;
        min-height: 100vh;
        font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
        box-shadow: 2px 0 12px rgba(44,62,80,0.10);
    }
    .sidebar-modern .sidebar-brand-text {
        font-size: 1.1rem;
        font-weight: 700;
        letter-spacing: 1px;
    }
    .sidebar-modern .nav-link {
        color: #fff !important;
        font-weight: 500;
        border-radius: 10px;
        margin-bottom: 12px;
        transition: background 0.18s, color 0.18s, box-shadow 0.18s;
        padding: 10px 16px;
        text-align: left;
        display: flex;
        align-items: center;
        box-shadow: 0 1px 4px rgba(44,62,80,0.04);
        background: rgba(255,255,255,0.06);
        font-size: 0.98rem;
        gap: 12px;
    }
    .sidebar-modern .nav-link.active, .sidebar-modern .nav-link:hover {
        background: #fff;
        color: #e1251b !important;
        box-shadow: 0 4px 16px rgba(44,62,80,0.10);
        font-weight: 600;
    }
    .sidebar-modern .nav-link i {
        min-width: 22px;
        text-align: center;
        font-size: 1.15rem;
        margin-right: 8px;
    }
    .sidebar-modern .sidebar-divider {
        border-top: 1.5px solid #fff2;
        margin: 0.7rem 0;
    }
    .sidebar-modern .sidebar-footer {
        margin-top: auto;
        padding-bottom: 1.5rem;
        text-align: center;
    }
</style>

<ul class="navbar-nav sidebar-modern sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center my-4" href="{{ route('dashboard') }}">
        <img src="https://logowik.com/content/uploads/images/pertamina2579.jpg" alt="Logo Pertamina" style="width: 90px;">
    </a>

    <hr class="sidebar-divider">

    <!-- Dashboard Link -->
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <i class="fas fa-home"></i>
            Dashboard
        </a>
    </li>

    <!-- Gaji Link -->
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('gaji.*') ? 'active' : '' }}" href="{{ route('gaji.index') }}">
            <i class="fas fa-money-bill-wave"></i>
            Gaji
        </a>
    </li>

    <!-- Pegawai Link -->
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('pegawai.*') ? 'active' : '' }}" href="{{ route('pegawai.index') }}">
            <i class="fas fa-users"></i>
            Pegawai
        </a>
    </li>
{{-- 
    <!-- Potongan Keterlambatan Link -->
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('potongan.*') ? 'active' : '' }}" href="{{ route('potongan.index') }}">
            <i class="fas fa-clock"></i>
            Potongan Keterlambatan
        </a>
    </li> --}}
{{-- 
    <!-- Tunjangan Link -->
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('tunjangan.*') ? 'active' : '' }}" href="{{ route('tunjangan.index') }}">
            <i class="fas fa-hand-holding-usd"></i>
            Tunjangan
        </a>
    </li> --}}

    <hr class="sidebar-divider">

    <!-- Logout Link -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i>
            Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </li>

    <hr class="sidebar-divider">

</ul>

