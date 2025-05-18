<aside class="navbar-vertical" id="sidebar">
    <div class="mt-3" style="display: flex; justify-content: center; align-items: center;">
        <img src="{{ asset('assets/dist/img/infineonlogo.png') }}" alt="" style="filter: invert(1); max-width: 60%; height: auto;">
    </div>
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
        <i class="fas fa-home"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('parcels.index') }}">
        <i class="fas fa-box"></i>
        <span>Parcels</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('cabinet.index') ? 'active' : '' }}" href="{{ route('cabinet.index') }}">
        <i class="fas fa-boxes-stacked"></i>
        <span>Cabinets</span>
      </a> 
    </li>
    @hasrole('admin')
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('userlist') ? 'active' : '' }}" href="{{ route('userlist') }}">
        <i class="fas fa-users"></i>
        <span>Users</span>
      </a>
    </li>
    @endhasrole
  </ul>
  
  <div class="navbar-footer">
    <span>© 2025 xBlankz Systems</span>
  </div>
</aside>