@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <div class="icon">
            <i class="fas fa-user"></i>
        </div>
        <h3>Welcome Back</h3>
        <p>Sign in to continue to Paycardo Shop</p>
    </div>
    
    <div class="auth-body">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope me-2"></i>Email Address</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                       name="email" value="{{ old('email') }}" required autocomplete="email" autofocus 
                       placeholder="Enter your email">
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password"><i class="fas fa-lock me-2"></i>Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                       name="password" required autocomplete="current-password" 
                       placeholder="Enter your password">
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>
                @if (Route::has('password.request'))
                    <a class="forgot-link" href="{{ route('password.request') }}">Forgot Password?</a>
                @endif
            </div>

            <button type="submit" class="btn btn-auth">
                <i class="fas fa-sign-in-alt me-2"></i> Login
            </button>

            <div class="divider">
                <span>or continue with</span>
            </div>

            <div class="social-login">
                <a href="#" class="btn-social" title="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="btn-social" title="Google">
                    <i class="fab fa-google"></i>
                </a>
                <a href="#" class="btn-social" title="Twitter">
                    <i class="fab fa-twitter"></i>
                </a>
            </div>
        </form>
    </div>

    <div class="auth-footer">
        <p>Don't have an account? <a href="{{ route('register') }}">Create Account</a></p>
    </div>
</div>
@endsection
