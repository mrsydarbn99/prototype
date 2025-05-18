<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ProCabT</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('assets/dist/css/app.css') }}">
  @stack('css')
</head>
<body>

<button class="navbar-toggler" id="sidebarToggle">
  <i class="fas fa-bars"></i>
</button>

<!-- Sidebar -->
@include('layout.sidebar')

<!-- Main Content -->
<div class="page-wrapper">
  <!-- Page Header -->
    <header class="page-header">
        <h1 class="page-title">ProCabT</h1>
            <div class="dropdown" style="position: relative;">
                <a href="#" class="nav-link" id="profileDropdown" onclick="toggleDropdown(event)">
                <div class="avatar">
                </div>
                <div class="d-xl-block">
                    <div style="font-weight: 500;">John Doe</div>
                    <div style="font-size: 0.75rem; color: var(--text-muted);">Administrator</div>
                </div>
                </a>
                <div class="dropdown-menu" id="userDropdown" style="display: none; position: absolute; top: 100%; left: 0; min-width: 200px;">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="{{ route('logout') }}">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
                </div>
            </div>
    </header>

  <!-- Page Body -->
  
  <div class="container-fluid">
    <div class="page-body">
      @if (session('success'))
          <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
      @endif

      @if (session('error'))
          <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
              {{ session('error') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
      @endif
      @yield('content')
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
<script>
  // Toggle sidebar on mobile
  document.getElementById('sidebarToggle').addEventListener('click', function() {
    document.getElementById('sidebar').classList.toggle('open');
  });

   function toggleDropdown(event) {
    event.preventDefault();
    var dropdownMenu = document.getElementById('userDropdown');
    dropdownMenu.style.display = (dropdownMenu.style.display === 'none' || dropdownMenu.style.display === '') ? 'block' : 'none';
  }
  
  // Optional: Close dropdown if clicked outside
  window.addEventListener('click', function(event) {
    var dropdownMenu = document.getElementById('userDropdown');
    var profileDropdown = document.getElementById('profileDropdown');
    
    if (!profileDropdown.contains(event.target) && !dropdownMenu.contains(event.target)) {
      dropdownMenu.style.display = 'none';
    }
  });
</script>
@stack('js')

</body>
</html>