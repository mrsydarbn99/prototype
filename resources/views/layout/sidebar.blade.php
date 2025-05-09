<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <img src="{{ asset('assets/dist/img/infineonlogo.png') }}" alt="" width="100" height="100" style="filter: invert(1)">
        <div class="sidebar-brand-text mx-3">Cabinet System</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#">
            <i class="fas fa-solid fa-list"></i>
            <span>Transaction Log</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('userlist') }}">
            <i class="fas fa-solid fa-users"></i>
            <span>User</span>
        </a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider">

</ul>
<!-- End of Sidebar -->