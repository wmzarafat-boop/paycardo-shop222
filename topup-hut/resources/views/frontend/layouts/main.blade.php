<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', settings('site_name', 'TopUp Hut')) - {{ settings('site_name', 'TopUp Hut') }}</title>
    <meta name="description" content="@yield('meta_description', settings('site_tagline', 'Your Trusted Online Store'))">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #FF6B00;
            --primary-dark: #e66000;
            --secondary: #1a1a2e;
            --dark: #0f0f1a;
            --card: #16213e;
            --text-primary: #ffffff;
            --text-secondary: #9ca3af;
            --border-color: #374151;
        }
        
        * {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, #0f0f1a 0%, #1a1a2e 100%);
            color: var(--text-primary);
            min-height: 100vh;
        }
        
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #1a1a2e;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #FF6B00;
            border-radius: 4px;
        }
        
        .bg-primary { background-color: var(--primary) !important; }
        .bg-secondary-custom { background-color: var(--secondary) !important; }
        .bg-dark-custom { background-color: var(--dark) !important; }
        .bg-card { background-color: var(--card) !important; }
        .text-primary-custom { color: var(--primary) !important; }
        .text-muted-custom { color: var(--text-secondary) !important; }
        
        a { text-decoration: none; }
        
        .product-card {
            transition: all 0.3s ease;
            background: var(--card);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 1rem;
            overflow: hidden;
        }
        
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(255, 107, 0, 0.2);
            border-color: rgba(255, 107, 0, 0.3);
        }
        
        .product-card .card-img-top {
            aspect-ratio: 1;
            object-fit: cover;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary), #ff8c00);
            border: none;
            color: white;
            padding: 10px 25px;
            border-radius: 50px;
            transition: all 0.3s;
            font-weight: 600;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 107, 0, 0.4);
            color: white;
        }
        
        .btn-outline-custom {
            background: var(--secondary);
            border: 1px solid var(--border-color);
            color: white;
            padding: 10px 25px;
            border-radius: 50px;
            transition: all 0.3s;
        }
        
        .btn-outline-custom:hover {
            border-color: var(--primary);
            background: var(--primary);
        }
        
        .glow-btn {
            box-shadow: 0 0 20px rgba(255, 107, 0, 0.5);
            transition: all 0.3s;
        }
        
        .glow-btn:hover {
            box-shadow: 0 0 40px rgba(255, 107, 0, 0.8);
            transform: scale(1.05);
        }
        
        .nav-link-custom {
            position: relative;
            color: var(--text-secondary);
            transition: color 0.3s;
        }
        
        .nav-link-custom:hover {
            color: var(--primary);
        }
        
        .discount-badge {
            background: linear-gradient(135deg, var(--primary), #ff8c00);
        }
        
        .section-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1.5rem;
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, rgba(255, 107, 0, 0.1) 0%, transparent 50%);
        }
        
        .navbar-custom {
            background: rgba(15, 15, 26, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        
        .topbar {
            background: rgba(26, 26, 46, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        
        .filter-btn {
            padding: 8px 20px;
            border-radius: 50px;
            border: 1px solid var(--border-color);
            background: transparent;
            color: var(--text-secondary);
            font-size: 0.875rem;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .filter-btn:hover, .filter-btn.active {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }
        
        .feature-card {
            background: var(--card);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 1rem;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            border-color: rgba(255, 107, 0, 0.3);
        }
        
        .footer-custom {
            background: rgba(26, 26, 46, 0.5);
            border-top: 1px solid rgba(255,255,255,0.05);
        }
        
        .social-icon {
            width: 40px;
            height: 40px;
            background: var(--card);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            transition: all 0.3s;
        }
        
        .social-icon:hover {
            background: var(--primary);
            color: white;
        }
        
        .payment-badge {
            background: var(--card);
            padding: 10px 20px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .whatsapp-float {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 56px;
            height: 56px;
            background: #25D366;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 28px;
            box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
            transition: all 0.3s;
            z-index: 1000;
        }
        
        .whatsapp-float:hover {
            background: #20bd5a;
            transform: scale(1.1);
        }
        
        .cart-sidebar {
            position: fixed;
            top: 0;
            right: 0;
            width: 100%;
            max-width: 400px;
            height: 100%;
            background: var(--dark);
            z-index: 1050;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            box-shadow: -10px 0 30px rgba(0,0,0,0.5);
        }
        
        .cart-sidebar.open {
            transform: translateX(0);
        }
        
        .cart-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.7);
            z-index: 1040;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
        }
        
        .cart-overlay.open {
            opacity: 1;
            visibility: visible;
        }
        
        .logo-gradient {
            background: linear-gradient(135deg, var(--primary), #ff8c00);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .form-control-custom {
            background: var(--secondary);
            border: 1px solid var(--border-color);
            border-radius: 50px;
            padding: 12px 20px;
            color: white;
            width: 100%;
        }
        
        .form-control-custom:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(255, 107, 0, 0.2);
        }
        
        .form-control-custom::placeholder {
            color: var(--text-secondary);
        }
        
        .product-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: var(--primary);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .product-hot-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #ef4444;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .product-discount-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: var(--primary);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }
        
        .product-soldout-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #6b7280;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        @media (max-width: 768px) {
            .section-title {
                font-size: 1.5rem;
            }
        }
        
        /* MOBILE-FIRST RESPONSIVE STYLES */
        .mobile-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--dark);
            border-top: 1px solid var(--border-color);
            padding: 10px 0;
            z-index: 1000;
            box-shadow: 0 -5px 20px rgba(0,0,0,0.3);
        }
        
        .mobile-nav-items {
            display: flex;
            justify-content: space-around;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        
        .mobile-nav-item {
            text-align: center;
            flex: 1;
        }
        
        .mobile-nav-link {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            transition: color 0.3s;
        }
        
        .mobile-nav-link i {
            font-size: 20px;
        }
        
        .mobile-nav-link.active,
        .mobile-nav-link:hover {
            color: var(--primary);
        }
        
        .install-popup {
            display: none;
            position: fixed;
            bottom: 80px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 16px 20px;
            z-index: 999;
            box-shadow: 0 10px 40px rgba(0,0,0,0.4);
            max-width: 90%;
            width: 350px;
            animation: slideUp 0.5s ease;
        }
        
        @keyframes slideUp {
            from { opacity: 0; transform: translateX(-50%) translateY(20px); }
            to { opacity: 1; transform: translateX(-50%) translateY(0); }
        }
        
        .install-popup-content {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .install-popup-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary), #ff8c00);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
        }
        
        .install-popup-text {
            flex: 1;
        }
        
        .install-popup-text h6 {
            color: white;
            margin: 0 0 4px 0;
            font-size: 14px;
        }
        
        .install-popup-text p {
            color: var(--text-secondary);
            margin: 0;
            font-size: 12px;
        }
        
        .install-btn {
            background: linear-gradient(135deg, var(--primary), #ff8c00);
            border: none;
            color: white;
            padding: 8px 20px;
            border-radius: 25px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .install-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 20px rgba(255, 107, 0, 0.4);
        }
        
        .close-popup {
            position: absolute;
            top: -10px;
            right: -10px;
            background: var(--card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 14px;
        }
        
        .mobile-header {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(15, 15, 26, 0.95);
            backdrop-filter: blur(10px);
            padding: 12px 15px;
            z-index: 1001;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        
        .mobile-header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .mobile-logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .mobile-logo-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--primary), #ff8c00);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }
        
        .mobile-logo-text {
            font-size: 16px;
            font-weight: 700;
            color: white;
        }
        
        .mobile-header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .mobile-header-btn {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            position: relative;
        }
        
        .promo-banner {
            background: linear-gradient(135deg, var(--primary) 0%, #ff8c00 50%, #ffaa33 100%);
            padding: 20px;
            border-radius: 16px;
            margin: 15px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .promo-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 60%);
            animation: shimmer 3s infinite;
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }
        
        .promo-banner h3 {
            color: white;
            font-size: 20px;
            font-weight: 700;
            margin: 0 0 8px 0;
            position: relative;
        }
        
        .promo-banner p {
            color: rgba(255,255,255,0.9);
            font-size: 14px;
            margin: 0;
            position: relative;
        }
        
        .product-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            padding: 15px;
        }
        
        .product-card-new {
            background: var(--card);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }
        
        .product-card-new:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(255, 107, 0, 0.2);
        }
        
        .product-card-image {
            position: relative;
            aspect-ratio: 1;
            overflow: hidden;
        }
        
        .product-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }
        
        .product-card-new:hover .product-card-image img {
            transform: scale(1.1);
        }
        
        .product-card-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: linear-gradient(135deg, var(--primary), #ff8c00);
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
        }
        
        .product-card-discount {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #ef4444;
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
        }
        
        .product-card-content {
            padding: 12px;
        }
        
        .product-card-title {
            color: white;
            font-size: 14px;
            font-weight: 600;
            margin: 0 0 8px 0;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .product-card-price {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
        }
        
        .current-price {
            color: var(--primary);
            font-size: 16px;
            font-weight: 700;
        }
        
        .original-price {
            color: var(--text-secondary);
            font-size: 12px;
            text-decoration: line-through;
        }
        
        .product-card-btn {
            width: 100%;
            background: linear-gradient(135deg, var(--primary), #ff8c00);
            border: none;
            color: white;
            padding: 10px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .product-card-btn:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 20px rgba(255, 107, 0, 0.4);
        }
        
        @media (max-width: 991px) {
            .mobile-nav, .mobile-header, .install-popup {
                display: block;
            }
            
            .topbar, header.navbar-custom, footer, .whatsapp-float {
                display: none;
            }
            
            body {
                padding-top: 60px;
                padding-bottom: 70px;
            }
            
            .promo-banner {
                margin: 15px;
            }
        }
        
        @media (min-width: 992px) {
            .product-grid {
                grid-template-columns: repeat(4, 1fr);
                gap: 20px;
                padding: 20px;
            }
            
            .product-card-new {
                border-radius: 20px;
            }
            
            .product-card-content {
                padding: 15px;
            }
            
            .product-card-title {
                font-size: 15px;
            }
            
            .current-price {
                font-size: 18px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Top Bar -->
    <div class="topbar py-2">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-4">
                    <span class="text-muted-custom small">
                        <i class="fas fa-clock me-2"></i>Support: 24/7
                    </span>
                    <span class="text-muted-custom small d-none d-md-inline">
                        <i class="fas fa-envelope me-2"></i>{{ settings('email', 'info@paycardoshop.com') }}
                    </span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ settings('facebook', '#') }}" class="text-muted-custom" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="{{ settings('youtube', '#') }}" class="text-muted-custom" target="_blank"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="text-muted-custom"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-muted-custom"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="navbar-custom sticky-top py-3">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between gap-4">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="d-flex align-items-center gap-3 text-decoration-none">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-orange-600 rounded-xl d-flex align-items-center justify-center">
                        <i class="fas fa-shopping-cart text-2xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="h5 mb-0 fw-bold logo-gradient">{{ settings('site_name', 'TopUp Hut') }}</h1>
                        <small class="text-muted-custom">{{ settings('site_tagline', 'Trusted Online Store') }}</small>
                    </div>
                </a>

                <!-- Search Bar -->
                <div class="flex-grow-1 d-none d-md-block mx-4" style="max-width: 500px;">
                    <form action="{{ route('shop.search') }}" method="GET" class="position-relative">
                        <input type="text" name="q" placeholder="Search for products..." class="form-control-custom pe-5" style="padding-right: 50px;">
                        <button type="submit" class="btn btn-primary position-absolute top-50 end-0 translate-middle-y me-2" style="border-radius: 50%; width: 40px; height: 40px; padding: 0;">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>

                <!-- Actions -->
                <div class="d-flex align-items-center gap-4">
                    <a href="#" class="text-white position-relative" onclick="toggleCart(); return false;">
                        <i class="fas fa-shopping-cart fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary" style="font-size: 10px;" id="cartBadge">{{ cart_count() }}</span>
                    </a>
                    
                    @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-custom d-none d-md-flex align-items-center gap-2">
                        <i class="fas fa-user text-muted-custom"></i>
                        <span class="small">Login / Register</span>
                    </a>
                    @else
                    <div class="dropdown">
                        <a class="btn btn-outline-custom dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i> {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" style="background: var(--card); border: 1px solid var(--border-color);">
                            <li><a class="dropdown-item" href="{{ route('account.index') }}" style="color: var(--text-primary);"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('account.orders') }}" style="color: var(--text-primary);"><i class="fas fa-box me-2"></i> My Orders</a></li>
                            <li><hr class="dropdown-divider" style="border-color: var(--border-color);"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: var(--text-primary);">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                            </li>
                        </ul>
                    </div>
                    @endguest
                    
                    <button class="btn d-md-none text-white" onclick="toggleMobileMenu()">
                        <i class="fas fa-bars fs-5"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Search -->
            <div class="mt-3 d-md-none">
                <form action="{{ route('shop.search') }}" method="GET">
                    <input type="text" name="q" placeholder="Search..." class="form-control-custom">
                </form>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="d-none d-md-block mt-3" style="background: rgba(26, 26, 46, 0.5); border-top: 1px solid rgba(255,255,255,0.03);">
            <div class="container">
                <ul class="nav justify-content-center py-2 mb-0" style="gap: 5px;">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom px-3 py-2 text-white bg-primary rounded-full" href="{{ url('/') }}">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom px-3 py-2 rounded-full" href="{{ route('shop') }}">SHOP</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-link-custom px-3 py-2 rounded-full dropdown-toggle" href="#" data-bs-toggle="dropdown">SMM SERVICES</a>
                        <ul class="dropdown-menu" style="background: var(--card); border: 1px solid var(--border-color);">
                            <li><a class="dropdown-item" href="{{ route('shop.category', 'facebook') }}" style="color: var(--text-primary);">Facebook</a></li>
                            <li><a class="dropdown-item" href="{{ route('shop.category', 'youtube') }}" style="color: var(--text-primary);">YouTube</a></li>
                            <li><a class="dropdown-item" href="{{ route('shop.category', 'instagram') }}" style="color: var(--text-primary);">Instagram</a></li>
                            <li><a class="dropdown-item" href="{{ route('shop.category', 'tiktok') }}" style="color: var(--text-primary);">TikTok</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom px-3 py-2 rounded-full" href="{{ route('shop.category', 'visa-card') }}">VISA CARD</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom px-3 py-2 rounded-full" href="{{ route('shop.category', 'subscriptions') }}">SUBSCRIPTION</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom px-3 py-2 rounded-full" href="{{ route('shop.category', 'gift-cards') }}">GIFT CARDS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom px-3 py-2 rounded-full" href="{{ route('shop.category', 'games-top-up') }}">GAMES TOP UP</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="position-fixed inset-0" style="background: rgba(15, 15, 26, 0.98); z-index: 1060; display: none;">
        <div class="p-4 d-flex justify-content-between align-items-center border-bottom" style="border-color: var(--border-color) !important;">
            <h2 class="h5 fw-bold text-primary-custom mb-0">Menu</h2>
            <button onclick="toggleMobileMenu()" class="btn text-white"><i class="fas fa-times fs-4"></i></button>
        </div>
        <nav class="p-4">
            <ul class="list-unstyled mb-0">
                <li class="mb-2"><a href="{{ url('/') }}" class="d-block py-3 px-4 text-white bg-primary rounded">HOME</a></li>
                <li class="mb-2"><a href="{{ route('shop') }}" class="d-block py-3 px-4 text-muted-custom rounded" style="background: var(--card);">SHOP</a></li>
                <li class="mb-2"><a href="{{ route('shop.category', 'smm-services') }}" class="d-block py-3 px-4 text-muted-custom rounded" style="background: var(--card);">SMM SERVICES</a></li>
                <li class="mb-2"><a href="{{ route('shop.category', 'visa-card') }}" class="d-block py-3 px-4 text-muted-custom rounded" style="background: var(--card);">VISA CARD</a></li>
                <li class="mb-2"><a href="{{ route('shop.category', 'subscriptions') }}" class="d-block py-3 px-4 text-muted-custom rounded" style="background: var(--card);">SUBSCRIPTION</a></li>
                <li class="mb-2"><a href="{{ route('shop.category', 'gift-cards') }}" class="d-block py-3 px-4 text-muted-custom rounded" style="background: var(--card);">GIFT CARDS</a></li>
                <li class="mb-2"><a href="{{ route('shop.category', 'games-top-up') }}" class="d-block py-3 px-4 text-muted-custom rounded" style="background: var(--card);">GAMES TOP UP</a></li>
            </ul>
        </nav>
    </div>

    <!-- Cart Sidebar -->
    <div class="cart-overlay" id="cartOverlay" onclick="toggleCart()"></div>
    <div class="cart-sidebar" id="cartSidebar">
        <div class="p-4 h-100 d-flex flex-column">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h5 fw-bold text-white mb-0">Shopping Cart</h2>
                <button onclick="toggleCart()" class="btn text-muted-custom"><i class="fas fa-times fs-4"></i></button>
            </div>
            <div class="flex-grow-1 d-flex align-items-center justify-content-center" id="cartContent">
                <div class="text-center text-muted-custom">
                    <i class="fas fa-shopping-cart fs-1 mb-3 opacity-50"></i>
                    <p>Your cart is empty</p>
                </div>
            </div>
            <div class="border-top pt-4" style="border-color: var(--border-color) !important;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted-custom">Subtotal:</span>
                    <span class="text-white fw-bold fs-5">{{ settings('currency_symbol', '৳') }}<span id="cartSubtotal">0</span></span>
                </div>
                <a href="{{ route('checkout') }}" class="btn btn-primary-custom w-100">Checkout</a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-custom pt-5 pb-4">
        <div class="container">
            <div class="row g-4 mb-4">
                <!-- Logo & About -->
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-primary to-orange-600 rounded-xl d-flex align-items-center justify-center">
                            <i class="fas fa-shopping-cart text-lg text-white"></i>
                        </div>
                        <h3 class="h5 fw-bold text-white mb-0">{{ settings('site_name', 'TopUp Hut') }}</h3>
                    </div>
                    <p class="text-muted-custom small mb-3">{{ settings('site_tagline', 'Your Trusted Online Store') }}</p>
                    <div class="d-flex gap-2">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6">
                    <h5 class="text-white fw-semibold mb-3">Quick Links</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><a href="{{ url('/') }}" class="text-muted-custom small">Home</a></li>
                        <li class="mb-2"><a href="{{ route('shop') }}" class="text-muted-custom small">Shop</a></li>
                        <li class="mb-2"><a href="{{ route('page', 'about-us') }}" class="text-muted-custom small">About Us</a></li>
                        <li class="mb-2"><a href="{{ route('page', 'contact-us') }}" class="text-muted-custom small">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Information -->
                <div class="col-lg-2 col-md-6">
                    <h5 class="text-white fw-semibold mb-3">Information</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><a href="{{ route('page', 'privacy-policy') }}" class="text-muted-custom small">Privacy Policy</a></li>
                        <li class="mb-2"><a href="{{ route('page', 'terms-conditions') }}" class="text-muted-custom small">Terms & Conditions</a></li>
                        <li class="mb-2"><a href="{{ route('page', 'refund-policy') }}" class="text-muted-custom small">Refund Policy</a></li>
                        <li class="mb-2"><a href="{{ route('page', 'faq') }}" class="text-muted-custom small">FAQ</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-white fw-semibold mb-3">Contact Us</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2 d-flex align-items-center gap-2 text-muted-custom small">
                            <i class="fas fa-envelope text-primary-custom"></i>
                            {{ settings('email', 'info@paycardoshop.com') }}
                        </li>
                        <li class="mb-2 d-flex align-items-center gap-2 text-muted-custom small">
                            <i class="fab fa-whatsapp text-primary-custom"></i>
                            {{ settings('phone', '+880 1XXX-XXXXXX') }}
                        </li>
                        <li class="mb-2 d-flex align-items-start gap-2 text-muted-custom small">
                            <i class="fas fa-map-marker-alt text-primary-custom mt-1"></i>
                            {{ settings('address', 'Dhaka, Bangladesh') }}
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="border-top py-4 mb-4" style="border-color: rgba(255,255,255,0.05) !important;">
                <h5 class="text-white fw-semibold mb-3 text-center">Payment Methods</h5>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <div class="payment-badge">
                        <i class="fas fa-money-bill-wave text-primary-custom"></i>
                        <span class="text-muted-custom small">bKash</span>
                    </div>
                    <div class="payment-badge">
                        <i class="fas fa-money-bill-wave text-primary-custom"></i>
                        <span class="text-muted-custom small">Nagad</span>
                    </div>
                    <div class="payment-badge">
                        <i class="fas fa-credit-card text-primary-custom"></i>
                        <span class="text-muted-custom small">Rocket</span>
                    </div>
                    <div class="payment-badge">
                        <i class="fab fa-cc-visa text-primary-custom"></i>
                        <span class="text-muted-custom small">Visa</span>
                    </div>
                    <div class="payment-badge">
                        <i class="fab fa-cc-mastercard text-primary-custom"></i>
                        <span class="text-muted-custom small">Mastercard</span>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="text-center text-muted-custom small border-top pt-4" style="border-color: rgba(255,255,255,0.05) !important;">
                <p class="mb-0">&copy; {{ date('Y') }} {{ settings('site_name', 'TopUp Hut') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Mobile Header -->
    <div class="mobile-header">
        <div class="mobile-header-content">
            <div class="mobile-logo">
                <div class="mobile-logo-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <span class="mobile-logo-text">{{ settings('site_name', 'TopUp Hut') }}</span>
            </div>
            <div class="mobile-header-actions">
                <button class="mobile-header-btn" onclick="toggleSearch()">
                    <i class="fas fa-search"></i>
                </button>
                <button class="mobile-header-btn" onclick="toggleCart()">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary" style="font-size: 10px;">{{ cart_count() }}</span>
                </button>
                <a href="{{ route('account.index') }}" class="mobile-header-btn">
                    <i class="fas fa-user"></i>
                </a>
            </div>
        </div>
        <div class="mt-3" id="mobileSearch" style="display: none;">
            <form action="{{ route('shop.search') }}" method="GET">
                <input type="text" name="q" placeholder="Search products..." class="form-control-custom">
            </form>
        </div>
    </div>

    <!-- Install App Popup -->
    <div class="install-popup" id="installPopup">
        <span class="close-popup" onclick="closeInstallPopup()"><i class="fas fa-times"></i></span>
        <div class="install-popup-content">
            <div class="install-popup-icon">
                <i class="fas fa-mobile-alt"></i>
            </div>
            <div class="install-popup-text">
                <h6>Install Our App</h6>
                <p>Get the best experience</p>
            </div>
            <button class="install-btn" onclick="installApp()">Install</button>
        </div>
    </div>

    <!-- Mobile Bottom Navigation -->
    <nav class="mobile-nav">
        <ul class="mobile-nav-items">
            <li class="mobile-nav-item">
                <a href="{{ url('/') }}" class="mobile-nav-link {{ request()->is('/') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
            </li>
            <li class="mobile-nav-item">
                <a href="{{ route('shop') }}" class="mobile-nav-link {{ request()->is('shop*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-bag"></i>
                    <span>TopUp</span>
                </a>
            </li>
            <li class="mobile-nav-item">
                <a href="{{ route('account.index') }}" class="mobile-nav-link">
                    <i class="fas fa-user"></i>
                    <span>My Account</span>
                </a>
            </li>
            <li class="mobile-nav-item">
                <a href="{{ route('page', 'contact-us') }}" class="mobile-nav-link">
                    <i class="fas fa-envelope"></i>
                    <span>Contact</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- WhatsApp Float Button -->
    <a href="https://wa.me/{{ str_replace(['+', '-', ' '], '', settings('phone', '8801850603187')) }}" target="_blank" class="whatsapp-float">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    @if(session('success'))
    <script>toastr.success('{{ session('success') }}', 'Success');</script>
    @endif
    @if(session('error'))
    <script>toastr.error('{{ session('error') }}', 'Error');</script>
    @endif
    
<script>
        var installPopupDisplayed = false;

        function toggleSearch() {
            const search = document.getElementById('mobileSearch');
            search.style.display = search.style.display === 'none' ? 'block' : 'none';
        }

        function closeInstallPopup() {
            document.getElementById('installPopup').style.display = 'none';
            localStorage.setItem('installPopupShown', 'true');
            sessionStorage.setItem('installSession', 'true');
        }

        function installApp() {
            alert('To install: Add to Home Screen from browser menu');
            localStorage.setItem('installPopupShown', 'true');
            sessionStorage.setItem('installSession', 'true');
            document.getElementById('installPopup').style.display = 'none';
        }

        (function() {
            if (installPopupDisplayed) return;
            if (window.innerWidth > 768) return;
            if (localStorage.getItem('installPopupShown')) return;
            
            installPopupDisplayed = true;
            setTimeout(function() {
                document.getElementById('installPopup').style.display = 'block';
            }, 3000);
        })();
    </script>
    
    @stack('scripts')
</body>
</html>
