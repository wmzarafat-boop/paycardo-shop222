<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - {{ settings('site_name', 'TopUp Hut') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        :root {
            --primary-color: #6c5ce7;
            --secondary-color: #a29bfe;
            --dark-bg: #1a1a2e;
            --sidebar-bg: #16213e;
            --card-bg: #0f3460;
        }
        body {
            background-color: #f5f6fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar {
            background: var(--sidebar-bg);
            min-height: 100vh;
            position: fixed;
            width: 250px;
            padding-top: 20px;
            color: #fff;
        }
        .sidebar .logo {
            text-align: center;
            padding: 15px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }
        .sidebar .logo h4 {
            color: #fff;
            margin: 0;
            font-weight: 700;
        }
        .sidebar .nav-item {
            padding: 12px 25px;
            transition: all 0.3s;
        }
        .sidebar .nav-item:hover {
            background: rgba(255,255,255,0.1);
        }
        .sidebar .nav-item.active {
            background: var(--primary-color);
        }
        .sidebar .nav-link {
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sidebar .nav-link i {
            width: 25px;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .topbar {
            background: #fff;
            padding: 15px 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }
        .card-header {
            background: var(--primary-color);
            color: #fff;
            border-radius: 10px 10px 0 0;
            padding: 15px 20px;
        }
        .btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }
        .btn-primary:hover {
            background: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                padding: 0;
                overflow: hidden;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <h4><i class="fas fa-shopping-cart"></i> {{ settings('site_name', 'TopUp Hut') }}</h4>
            <small class="text-muted">Admin Panel</small>
        </div>
        <nav class="nav flex-column">
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="nav-link"><i class="fas fa-home"></i> Dashboard</span>
            </a>
            <a href="{{ route('admin.categories.index') }}" class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <span class="nav-link"><i class="fas fa-folder"></i> Categories</span>
            </a>
            <a href="{{ route('admin.products.index') }}" class="nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <span class="nav-link"><i class="fas fa-box"></i> Products</span>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <span class="nav-link"><i class="fas fa-shopping-cart"></i> Orders</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <span class="nav-link"><i class="fas fa-users"></i> Customers</span>
            </a>
            <a href="{{ route('admin.pages.index') }}" class="nav-item {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                <span class="nav-link"><i class="fas fa-file-alt"></i> Pages</span>
            </a>
            <a href="{{ route('admin.settings') }}" class="nav-item {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                <span class="nav-link"><i class="fas fa-cog"></i> Settings</span>
            </a>
            <hr class="bg-secondary mx-3">
            <a href="{{ route('home') }}" class="nav-item">
                <span class="nav-link"><i class="fas fa-external-link-alt"></i> View Website</span>
            </a>
            <a href="{{ route('logout') }}" class="nav-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <span class="nav-link"><i class="fas fa-sign-out-alt"></i> Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </nav>
    </div>

    <div class="main-content">
        <div class="topbar">
            <div>
                <h5 class="mb-0">@yield('page_title', 'Dashboard')</h5>
                <small class="text-muted">{{ date('d M Y, l') }}</small>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="dropdown">
                    <a class="dropdown-toggle text-dark text-decoration-none" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle fa-lg"></i>
                        <span class="ms-2">{{ auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('admin.settings') }}"><i class="fas fa-cog me-2"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @if(session('success'))
    <script>
        toastr.success('{{ session('success') }}', 'Success');
    </script>
    @endif
    @if(session('error'))
    <script>
        toastr.error('{{ session('error') }}', 'Error');
    </script>
    @endif
    @stack('scripts')
</body>
</html>
