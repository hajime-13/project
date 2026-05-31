@extends('layouts.guest')

@section('title', 'Login — OrderTrack')
@section('subtitle', 'Sign in to your account')

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Email Address</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
               placeholder="Your password" required>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4 d-flex align-items-center justify-content-between">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label" for="remember" style="font-size:0.875rem">Remember me</label>
        </div>
    </div>

    <button type="submit" class="btn btn-primary w-100">
        <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
    </button>
</form>

<p class="text-center mt-3 mb-0" style="font-size:0.875rem; color:#64748b">
    Don't have an account?
    <a href="{{ route('register') }}" class="text-decoration-none fw-semibold" style="color:#4f46e5">Register</a>
</p>
@endsection
