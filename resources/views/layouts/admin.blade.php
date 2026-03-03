<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Quản trị Mandi Health')</title>
  
  {{-- Bootstrap 5 & FontAwesome --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

  {{-- Vite Assets --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    :root {
      --sidebar-width: 260px;
      --primary-color: #1e3a8a; /* Xanh đậm y tế */
      --active-bg: #ffffff;
      --active-text: #1e3a8a;
      --hover-bg: rgba(255, 255, 255, 0.1);
    }

    body {
      font-family: 'Nunito', sans-serif;
      background-color: #f8fafc; /* Slate 50 */
    }

    /* --- SIDEBAR STYLE --- */
    .sidebar {
      width: var(--sidebar-width);
      background: linear-gradient(180deg, #1e40af, #3b82f6);
      color: #fff;
      position: fixed;
      top: 0;
      left: 0;
      bottom: 0;
      z-index: 1000;
      box-shadow: 4px 0 20px rgba(0,0,0,0.1);
      display: flex;
      flex-direction: column;
      overflow-y: auto;
      transition: all 0.3s;
    }

    .sidebar-header {
      padding: 25px 20px;
      border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .brand-logo {
      font-size: 24px;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 1px;
      display: flex;
      align-items: center;
      gap: 10px;
      color: white;
      text-decoration: none;
    }

    /* User Info Card */
    .user-profile {
      background: rgba(0,0,0,0.2);
      border-radius: 12px;
      padding: 15px;
      margin: 20px;
      display: flex;
      align-items: center;
      gap: 12px;
      border: 1px solid rgba(255,255,255,0.1);
    }
    
    .avatar-circle {
      width: 40px;
      height: 40px;
      background: white;
      color: var(--primary-color);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 800;
      font-size: 18px;
    }

    /* Menu Items */
    .menu-group {
      padding: 0 15px;
      margin-bottom: 25px;
    }

    .menu-label {
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      color: #bfdbfe;
      margin-bottom: 10px;
      padding-left: 12px;
      letter-spacing: 1px;
    }

    .nav-link {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 15px;
      color: #e2e8f0;
      text-decoration: none;
      border-radius: 10px;
      margin-bottom: 5px;
      font-weight: 600;
      font-size: 15px;
      transition: all 0.2s ease;
    }

    .nav-link i {
      width: 20px;
      text-align: center;
      font-size: 16px;
    }

    .nav-link:hover {
      background: var(--hover-bg);
      color: white;
      transform: translateX(3px);
    }

    .nav-link.active {
      background: var(--active-bg);
      color: var(--active-text);
      font-weight: 700;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    /* Logout Button */
    .sidebar-footer {
      margin-top: auto;
      padding: 20px;
      border-top: 1px solid rgba(255,255,255,0.1);
    }

    .btn-logout {
      width: 100%;
      padding: 12px;
      background: rgba(255,255,255,0.1);
      border: 1px solid rgba(255,255,255,0.2);
      color: white;
      border-radius: 10px;
      font-weight: 600;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 8px;
      transition: all 0.3s;
    }
    
    .btn-logout:hover {
      background: #ef4444;
      border-color: #ef4444;
    }

    /* --- MAIN CONTENT AREA --- */
    .main-content {
      margin-left: var(--sidebar-width);
      padding: 30px;
      min-height: 100vh;
      width: calc(100% - var(--sidebar-width));
    }
  </style>
</head>
<body>

  <aside class="sidebar">
    <div class="sidebar-header">
      <a href="{{ route('admin.dashboard') }}" class="brand-logo">
        <i class="fa-solid fa-heart-pulse"></i> MANDI
      </a>
    </div>

    <div class="user-profile">
      <div class="avatar-circle">
        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
      </div>
      <div style="line-height: 1.3;">
        <div class="fw-bold text-truncate" style="max-width: 140px;">{{ Auth::user()->name ?? 'Admin' }}</div>
        <div class="text-white-50 small">Quản trị viên</div>
      </div>
    </div>

    <nav class="flex-grow-1">
      
      <div class="menu-group">
        <div class="menu-label">Hệ thống</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
          <i class="fa-solid fa-gauge-high"></i> <span>Tổng quan</span>
        </a>
        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
          <i class="fa-solid fa-users-gear"></i> <span>Người dùng</span>
        </a>
      
    <a class="nav-link" href="{{ route('admin.posts.index') }}">
        <i class="fas fa-fw fa-newspaper"></i>
        <span>Bài viết</span>
    </a>
    <a class="nav-link" href="{{ route('admin.reviews.index') }}">
        <i class="fas fa-fw fa-star"></i>
        <span>  Đánh giá</span>
    </a>
    


    <a href="{{ route('admin.orders.index') }}" class="nav-link">
        <i class="nav-icon fas fa-shopping-bag"></i>
        <p>Đơn hàng</p>
    </a>

<a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
            <i class="fa-solid fa-chart-pie"></i> <span>Báo cáo thống kê</span>
        </a>
      </div>

      <div class="menu-group">
        <div class="menu-label">Y tế & Dịch vụ</div>
        
        <a href="{{ route('admin.doctors.index') }}" class="nav-link {{ request()->routeIs('admin.doctors.*') ? 'active' : '' }}">
          <i class="fa-solid fa-user-doctor"></i> <span>Đội ngũ Bác sĩ</span>
        </a>

        <a href="{{ route('admin.appointments.index') }}" class="nav-link {{ request()->routeIs('admin.appointments.*') ? 'active' : '' }}">
          <i class="fa-solid fa-calendar-check"></i> <span>Lịch tư vấn</span>
        </a>

       

        <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
    <i class="fa-solid fa-pills"></i> <span>Kho thuốc</span>
</a>

      </div>

      <div class="menu-group">
        <div class="menu-label">Lối tắt</div>
        <a href="{{ route('dashboard') }}" class="nav-link">
          <i class="fa-solid fa-arrow-up-right-from-square"></i> <span>Xem trang chủ</span>
        </a>
      </div>

    </nav>

    <div class="sidebar-footer">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="btn-logout">
          <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
        </button>
      </form>
    </div>
  </aside>

  <main class="main-content">
    
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-3 mb-4" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-3 mb-4" role="alert">
        <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @yield('content')
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>