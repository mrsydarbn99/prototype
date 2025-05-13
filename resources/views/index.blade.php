<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modern Dashboard Layout</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/dist/css/app.css') }}">
</head>
<body>

<button class="navbar-toggler" id="sidebarToggle">
  <i class="fas fa-bars"></i>
</button>

<!-- Sidebar -->
<aside class="navbar-vertical" id="sidebar">
  <div class="navbar-brand">
    <img src="/api/placeholder/110/32" alt="Logo" />
  </div>
  
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link active" href="#">
        <i class="fas fa-home"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">
        <i class="fas fa-chart-bar"></i>
        <span>Analytics</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">
        <i class="fas fa-users"></i>
        <span>Customers</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">
        <i class="fas fa-file-invoice"></i>
        <span>Reports</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">
        <i class="fas fa-cog"></i>
        <span>Settings</span>
      </a>
    </li>
  </ul>
  
  <div class="navbar-footer">
    <span>© 2025 Your Company</span>
  </div>
</aside>

<!-- Main Content -->
<div class="page-wrapper">
  <!-- Page Header -->
    <header class="page-header">
        <h1 class="page-title">Dashboard</h1>
            <div class="dropdown" style="position: relative;">
                <a href="#" class="nav-link" id="profileDropdown" onclick="toggleDropdown(event)">
                <div class="avatar" style="background-image: url('/api/placeholder/38/38')"></div>
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
                <a class="dropdown-item text-danger" href="#">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
                </div>
            </div>
    </header>

  <!-- Page Body -->
  <div class="page-body">
    <!-- Stats Row -->
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-body">
            <div class="stats-card">
              <div class="stats-icon" style="background-color: rgba(74, 108, 247, 0.1); color: #4a6cf7;">
                <i class="fas fa-users"></i>
              </div>
              <div class="stats-info">
                <h3>2,451</h3>
                <p>Total Users</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <div class="card-body">
            <div class="stats-card">
              <div class="stats-icon" style="background-color: rgba(16, 185, 129, 0.1); color: #10b981;">
                <i class="fas fa-shopping-cart"></i>
              </div>
              <div class="stats-info">
                <h3>$12,438</h3>
                <p>Total Revenue</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <div class="card-body">
            <div class="stats-card">
              <div class="stats-icon" style="background-color: rgba(249, 115, 22, 0.1); color: #f97316;">
                <i class="fas fa-file-alt"></i>
              </div>
              <div class="stats-info">
                <h3>342</h3>
                <p>New Orders</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <div class="card-body">
            <div class="stats-card">
              <div class="stats-icon" style="background-color: rgba(139, 92, 246, 0.1); color: #8b5cf6;">
                <i class="fas fa-star"></i>
              </div>
              <div class="stats-info">
                <h3>98.3%</h3>
                <p>Satisfaction Rate</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Charts Row -->
    <div class="row" style="margin-top: 1rem;">
      <div class="col" style="flex: 2;">
        <div class="card">
          <div class="card-header">
            <h2 class="card-title">Revenue Overview</h2>
            <div>
              <select style="border: 1px solid var(--border-color); padding: 0.35rem; border-radius: 0.375rem; font-size: 0.875rem;">
                <option>Last 7 days</option>
                <option>Last 30 days</option>
                <option>Last 90 days</option>
              </select>
            </div>
          </div>
          <div class="card-body">
            <div class="chart-container">
              <!-- Chart placeholder -->
              <div style="width: 100%; height: 100%; background: linear-gradient(to right, #f1f5f9 50%, #e2e8f0 50%); opacity: 0.3; border-radius: 0.5rem;"></div>
              <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; color: #64748b;">
                <i class="fas fa-chart-line" style="font-size: 2rem; margin-bottom: 1rem;"></i>
                <p>Revenue Chart Visualization</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <div class="card-header">
            <h2 class="card-title">Top Products</h2>
          </div>
          <div class="card-body">
            <div class="chart-container">
              <!-- Chart placeholder -->
              <div style="width: 100%; height: 100%; background: radial-gradient(circle, #f1f5f9 0%, #e2e8f0 100%); opacity: 0.3; border-radius: 50%;"></div>
              <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; color: #64748b;">
                <i class="fas fa-chart-pie" style="font-size: 2rem; margin-bottom: 1rem;"></i>
                <p>Product Distribution</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Activity -->
    <div class="row" style="margin-top: 1rem;">
      <div class="col">
        <div class="card">
          <div class="card-header">
            <h2 class="card-title">Recent Activities</h2>
            <a href="#" style="text-decoration: none; color: var(--primary-color); font-size: 0.875rem; font-weight: 500;">View All</a>
          </div>
          <div class="card-body" style="padding: 0;">
            <div style="padding: 1rem; display: flex; align-items: center; border-bottom: 1px solid var(--border-color);">
              <div style="background-color: rgba(74, 108, 247, 0.1); color: var(--primary-color); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                <i class="fas fa-user-plus"></i>
              </div>
              <div style="flex: 1;">
                <div style="display: flex; justify-content: space-between;">
                  <p style="font-weight: 500; margin: 0;">New user registered</p>
                  <span style="font-size: 0.75rem; color: var(--text-muted);">2 min ago</span>
                </div>
                <p style="margin: 0; font-size: 0.875rem; color: var(--text-muted);">Jane Cooper has registered</p>
              </div>
            </div>
            <div style="padding: 1rem; display: flex; align-items: center; border-bottom: 1px solid var(--border-color);">
              <div style="background-color: rgba(16, 185, 129, 0.1); color: #10b981; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                <i class="fas fa-shopping-bag"></i>
              </div>
              <div style="flex: 1;">
                <div style="display: flex; justify-content: space-between;">
                  <p style="font-weight: 500; margin: 0;">New order placed</p>
                  <span style="font-size: 0.75rem; color: var(--text-muted);">1 hour ago</span>
                </div>
                <p style="margin: 0; font-size: 0.875rem; color: var(--text-muted);">Order #34522 has been placed</p>
              </div>
            </div>
            <div style="padding: 1rem; display: flex; align-items: center;">
              <div style="background-color: rgba(249, 115, 22, 0.1); color: #f97316; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                <i class="fas fa-comment"></i>
              </div>
              <div style="flex: 1;">
                <div style="display: flex; justify-content: space-between;">
                  <p style="font-weight: 500; margin: 0;">New comment</p>
                  <span style="font-size: 0.75rem; color: var(--text-muted);">3 hours ago</span>
                </div>
                <p style="margin: 0; font-size: 0.875rem; color: var(--text-muted);">Robert Fox commented on report</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

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

</body>
</html>