<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Account') - {{ settings('site_name', 'Paycardo Shop') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--dark) 0%, var(--secondary) 100%);
            min-height: 100vh;
        }
        .mobile-header {
            display: flex;
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
            width: 100%;
        }
        .mobile-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
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
        .mobile-nav {
            display: flex;
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
            width: 100%;
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
        }
        .mobile-nav-link i {
            font-size: 20px;
        }
        .mobile-nav-link.active, .mobile-nav-link:hover {
            color: var(--primary);
        }
        .auth-container {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            padding: 80px 20px 100px;
        }
        .auth-card {
            background: var(--card);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        }
        .auth-header {
            padding: 30px 25px 20px;
            text-align: center;
            background: linear-gradient(135deg, rgba(255, 107, 0, 0.1) 0%, transparent 50%);
        }
        .auth-header h3 {
            color: white;
            font-weight: 700;
            margin: 0;
            font-size: 24px;
        }
        .auth-header p {
            color: var(--text-secondary);
            margin: 8px 0 0;
            font-size: 14px;
        }
        .auth-body {
            padding: 25px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            color: var(--text-primary);
            font-weight: 500;
            margin-bottom: 8px;
            display: block;
            font-size: 14px;
        }
        .form-control {
            background: var(--secondary);
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 14px 16px;
            color: var(--text-primary);
            font-size: 15px;
            transition: all 0.3s;
            width: 100%;
        }
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(255, 107, 0, 0.2);
            outline: none;
            background: var(--secondary);
            color: var(--text-primary);
        }
        .form-control::placeholder {
            color: var(--text-secondary);
        }
        .btn-google {
            background: white;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 12px 20px;
            color: #333;
            font-weight: 600;
            font-size: 14px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s;
            text-decoration: none;
        }
        .btn-google:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }
        .divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border-color);
        }
        .divider span {
            padding: 0 15px;
            color: var(--text-secondary);
            font-size: 13px;
        }
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary), #ff8c00);
            border: none;
            border-radius: 12px;
            padding: 14px 30px;
            color: white;
            font-weight: 600;
            font-size: 15px;
            width: 100%;
            transition: all 0.3s;
        }
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 107, 0, 0.4);
            color: white;
        }
        .form-check-label {
            color: var(--text-secondary);
            font-size: 13px;
        }
        .form-check-input {
            background-color: var(--secondary);
            border-color: var(--border-color);
        }
        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        .forgot-link {
            color: var(--primary);
            text-decoration: none;
            font-size: 13px;
        }
        .forgot-link:hover {
            color: #ff8c00;
        }
        .auth-footer {
            text-align: center;
            padding: 20px 25px;
            background: rgba(26, 26, 46, 0.5);
            border-top: 1px solid rgba(255,255,255,0.05);
        }
        .auth-footer p {
            color: var(--text-secondary);
            margin: 0;
            font-size: 14px;
        }
        .auth-footer a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }
        .auth-footer a:hover {
            color: #ff8c00;
        }
        .invalid-feedback {
            color: #ff6b6b;
            font-size: 12px;
            margin-top: 6px;
        }
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 14px;
            margin-bottom: 20px;
            transition: color 0.3s;
        }
        .back-link:hover {
            color: var(--primary);
        }
        @media (min-width: 769px) {
            .mobile-header, .mobile-nav {
                display: none;
            }
            body {
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
            }
            .auth-container {
                padding: 0;
                margin: 0;
            }
            .auth-card {
                max-width: 450px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <header class="mobile-header">
        <div class="mobile-header-content">
            <a href="{{ url('/') }}" class="mobile-logo">
                <div class="mobile-logo-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <span class="mobile-logo-text">{{ settings('site_name', 'TopUp Hut') }}</span>
            </a>
        </div>
    </header>

    <div class="auth-container">
        <a href="{{ url('/') }}" class="back-link d-md-none">
            <i class="fas fa-arrow-left"></i> Back to Home
        </a>
        @yield('content')
    </div>

    <nav class="mobile-nav">
        <ul class="mobile-nav-items">
            <li class="mobile-nav-item">
                <a href="{{ url('/') }}" class="mobile-nav-link">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
            </li>
            <li class="mobile-nav-item">
                <a href="{{ route('shop') }}" class="mobile-nav-link">
                    <i class="fas fa-shopping-bag"></i>
                    <span>TopUp</span>
                </a>
            </li>
            <li class="mobile-nav-item">
                <a href="{{ route('account.index') }}" class="mobile-nav-link">
                    <i class="fas fa-user"></i>
                    <span>Account</span>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @if(session('success'))
    <script>toastr.success('{{ session('success') }}', 'Success');</script>
    @endif
    @if(session('error'))
    <script>toastr.error('{{ session('error') }}', 'Error');</script>
    @endif
    @stack('scripts')
</body>
</html>