<ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Home Icon Button Only -->
    <li class="nav-item mb-3 d-flex justify-content-center">
        <a class="nav-link p-2 rounded-circle bg-white shadow-sm"
           href="{{ route('dashboard') }}"
           style="width:48px; height:48px; display:flex; align-items:center; justify-content:center;">
            <i class="fa-solid fa-house fa-lg" style="color:black;"></i>
        </a>
    </li>

    <!-- Dashboard Link -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ url('/') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Gaji Link -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('gaji.index') }}">
            <i class="fas fa-fw fa-money-bill-wave"></i>
            <span>Gaji</span>
        </a>
    </li>

    <!-- Pegawai Link -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('pegawai.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Pegawai</span>
        </a>
    </li>

    <!-- Potongan Keterlambatan Link -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('potongan.index') }}">
            <i class="fas fa-fw fa-clock"></i>
            <span>Potongan Keterlambatan</span>
        </a>
    </li>

    <!-- Tunjangan Link -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('tunjangan.index') }}">
            <i class="fas fa-fw fa-hand-holding-usd"></i>
            <span>Tunjangan</span>
        </a>
    </li>

    {{-- <!-- Logo Pertamina di bawah sidebar -->
    <li class="nav-item mt-auto mb-4 d-flex justify-content-center">
        <img src="{{ asset('images/Pertamina.png') }}" alt="Logo Pertamina">
    </li> --}}
</ul>

