<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');
    .sidebar-modern {
        background: linear-gradient(135deg, #e1251b 80%, #b71c1c 100%);
        color: #fff;
        min-height: 100vh;
        font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
        box-shadow: 2px 0 12px rgba(44,62,80,0.10);
        transition: margin-left 0.3s;
        width: 220px;
        position: fixed;
        z-index: 1045;
        left: 0;
        top: 0;
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
    .sidebar-collapsed {
        margin-left: -220px !important;
    }
    #sidebar-toggle-btn {
        position: fixed;
        top: 18px;
        left: 18px;
        z-index: 1050;
        background: #fff;
        color: #e1251b;
        border: none;
        border-radius: 50%;
        width: 38px;
        height: 38px;
        box-shadow: 0 2px 8px rgba(44,62,80,0.10);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    @media (max-width: 991px) {
        .sidebar-modern {
            margin-left: -220px;
        }
        .sidebar-modern.sidebar-open {
            margin-left: 0 !important;
        }
        #main-content {
            margin-left: 0 !important;
        }
    }
    #main-content {
        margin-left: 220px;
        transition: margin-left 0.3s;
    }
    .sidebar-open ~ #main-content {
        margin-left: 220px;
    }
    @media (max-width: 991px) {
        .sidebar-open ~ #main-content {
            margin-left: 0;
        }
    }
</style>

<!-- Tambahkan overlay -->
<div id="sidebar-overlay" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.2); z-index:1040;"></div>

<!-- Sidebar -->
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

    <!-- Gaji Link (khusus admin) -->
    @if(auth()->user() && auth()->user()->role === 'a')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('gaji.*') ? 'active' : '' }}" href="{{ route('gaji.index') }}">
            <i class="fas fa-money-bill-wave"></i>
            Gaji
        </a>
    </li>
    @endif

    <!-- Pegawai Link (khusus admin) -->
    @if(auth()->user() && auth()->user()->role === 'a')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('pegawai.*') ? 'active' : '' }}" href="{{ route('pegawai.index') }}">
            <i class="fas fa-users"></i>
            Pegawai
        </a>
    </li>
    @endif

    <!-- Register Karyawan Link (khusus admin) -->
    @if(auth()->user() && auth()->user()->role === 'a')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('karyawan.register') }}">
            <i class="fas fa-user-plus"></i>
            Register Karyawan
        </a>
    </li>
    @endif

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

<!-- Toggle Button -->
<button id="sidebar-toggle-btn" type="button" title="Toggle Sidebar">
    <i class="fas fa-bars"></i>
</button>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.sidebar-modern');
    const mainContent = document.getElementById('main-content');
    const toggleBtn = document.getElementById('sidebar-toggle-btn');
    const overlay = document.getElementById('sidebar-overlay');

    function openSidebarMobile() {
        sidebar.classList.add('sidebar-open');
        overlay.style.display = 'block';
    }
    function closeSidebarMobile() {
        sidebar.classList.remove('sidebar-open');
        overlay.style.display = 'none';
    }
    function toggleSidebarDesktop() {
        sidebar.classList.toggle('sidebar-collapsed');
        if(mainContent) {
            mainContent.style.marginLeft = sidebar.classList.contains('sidebar-collapsed') ? '0' : '220px';
        }
    }

    toggleBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        if(window.innerWidth <= 991) {
            if(sidebar.classList.contains('sidebar-open')) {
                closeSidebarMobile();
            } else {
                openSidebarMobile();
            }
        } else {
            toggleSidebarDesktop();
        }
    });

    overlay.addEventListener('click', closeSidebarMobile);

    // Responsive: auto close sidebar on resize to mobile
    window.addEventListener('resize', function() {
        if(window.innerWidth > 991) {
            overlay.style.display = 'none';
            sidebar.classList.remove('sidebar-open');
            if(mainContent && !sidebar.classList.contains('sidebar-collapsed')) {
                mainContent.style.marginLeft = '220px';
            }
        } else {
            if(!sidebar.classList.contains('sidebar-open')) {
                mainContent.style.marginLeft = '0';
            }
        }
    });

    // Inisialisasi sidebar tertutup di desktop & mobile
    if(window.innerWidth > 991) {
        sidebar.classList.add('sidebar-collapsed');
        if(mainContent) mainContent.style.marginLeft = '0';
    } else {
        sidebar.classList.remove('sidebar-open');
        if(mainContent) mainContent.style.marginLeft = '0';
    }
});
</script>

