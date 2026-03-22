@extends('layouts.app')
@section('title', 'Register')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <div class="icon">
            <i class="fas fa-user-plus"></i>
        </div>
        <h3>Create Account</h3>
        <p>Join Paycardo Shop today</p>
    </div>
    
    <div class="auth-body">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="form-group">
                <label for="name"><i class="fas fa-user me-2"></i>Full Name</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                       name="name" value="{{ old('name') }}" required autocomplete="name" autofocus 
                       placeholder="Enter your name">
                @error('name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email"><i class="fas fa-envelope me-2"></i>Email Address</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                       name="email" value="{{ old('email') }}" required autocomplete="email" 
                       placeholder="Enter your email">
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone"><i class="fas fa-phone me-2"></i>Phone Number</label>
                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" 
                       name="phone" value="{{ old('phone') }}" required autocomplete="tel" 
                       placeholder="01XXX-XXXXXX">
                @error('phone')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password"><i class="fas fa-lock me-2"></i>Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                       name="password" required autocomplete="new-password" 
                       placeholder="Create a password">
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password-confirm"><i class="fas fa-lock me-2"></i>Confirm Password</label>
                <input id="password-confirm" type="password" class="form-control" 
                       name="password_confirmation" required autocomplete="new-password" 
                       placeholder="Confirm your password">
            </div>

            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" id="terms" required>
                <label class="form-check-label" for="terms">
                    I agree to the <a href="{{ route('page', 'terms-conditions') }}" class="forgot-link">Terms & Conditions</a>
                </label>
            </div>

            <button type="submit" class="btn btn-auth">
                <i class="fas fa-user-plus me-2"></i> Create Account
            </button>

            <div class="divider">
                <span>or sign up with</span>
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
        <p>Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
    </div>
</div>
@endsection
