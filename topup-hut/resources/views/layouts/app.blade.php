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
    <style>
        :root {
            --primary: #6c5ce7;
            --secondary: #a29bfe;
            --accent: #fd79a8;
            --dark: #0d0d1a;
            --dark-bg: #1a1a2e;
            --card-bg: #1e1e3f;
            --text-primary: #ffffff;
            --text-secondary: #b0b0c0;
            --border-color: #2d2d5a;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--dark) 0%, var(--dark-bg) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .auth-container {
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }
        .auth-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        }
        .auth-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .auth-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .auth-header h3 {
            color: white;
            font-weight: 700;
            margin: 0;
            font-size: 28px;
            position: relative;
            z-index: 1;
        }
        .auth-header p {
            color: rgba(255,255,255,0.8);
            margin: 10px 0 0;
            font-size: 14px;
            position: relative;
            z-index: 1;
        }
        .auth-header .icon {
            width: 70px;
            height: 70px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            position: relative;
            z-index: 1;
        }
        .auth-header .icon i {
            font-size: 32px;
            color: white;
        }
        .auth-body {
            padding: 40px 30px;
        }
        .form-group {
            margin-bottom: 25px;
        }
        .form-group label {
            color: var(--text-primary);
            font-weight: 500;
            margin-bottom: 8px;
            display: block;
            font-size: 14px;
        }
        .form-control {
            background: var(--dark-bg);
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 14px 18px;
            color: var(--text-primary);
            font-size: 15px;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(108, 92, 231, 0.2);
            outline: none;
        }
        .form-control::placeholder {
            color: var(--text-secondary);
        }
        .input-group-text {
            background: var(--dark-bg);
            border: 2px solid var(--border-color);
            border-right: none;
            border-radius: 12px 0 0 12px;
            color: var(--text-secondary);
        }
        .input-group .form-control {
            border-left: none;
            border-radius: 0 12px 12px 0;
        }
        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control {
            border-color: var(--primary);
        }
        .btn-auth {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border: none;
            border-radius: 12px;
            padding: 14px 30px;
            color: white;
            font-weight: 600;
            font-size: 16px;
            width: 100%;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .btn-auth:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(108, 92, 231, 0.4);
            color: white;
        }
        .form-check-label {
            color: var(--text-secondary);
            font-size: 14px;
        }
        .form-check-input {
            background-color: var(--dark-bg);
            border-color: var(--border-color);
        }
        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        .forgot-link {
            color: var(--primary);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s;
        }
        .forgot-link:hover {
            color: var(--secondary);
        }
        .auth-footer {
            text-align: center;
            padding: 25px 30px;
            background: var(--dark-bg);
            border-top: 1px solid var(--border-color);
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
            color: var(--secondary);
        }
        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
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
            font-size: 14px;
        }
        .social-login {
            display: flex;
            gap: 15px;
            justify-content: center;
        }
        .btn-social {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--border-color);
            background: var(--dark-bg);
            color: var(--text-primary);
            transition: all 0.3s;
        }
        .btn-social:hover {
            border-color: var(--primary);
            background: var(--primary);
            transform: translateY(-3px);
        }
        .invalid-feedback {
            color: #ff6b6b;
            font-size: 13px;
            margin-top: 8px;
        }
        .back-home {
            position: absolute;
            top: 20px;
            left: 20px;
        }
        .back-home a {
            color: var(--text-primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            transition: color 0.3s;
        }
        .back-home a:hover {
            color: var(--primary);
        }
    </style>
</head>
<body>
    <div class="back-home">
        <a href="{{ url('/') }}">
            <i class="fas fa-arrow-left"></i> Back to Home
        </a>
    </div>
    <div class="auth-container">
        @yield('content')
    </div>
</body>
</html>
