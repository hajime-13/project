@extends('layouts.guest')

@section('title', 'Register — OrderTrack')
@section('subtitle', 'Create your account')

@section('content')
<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name') }}" placeholder="Juan Dela Cruz" required autofocus>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Email Address</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email') }}" placeholder="you@example.com" required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
               placeholder="Minimum 6 characters" required>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control"
               placeholder="Repeat your password" required>
    </div>

    <button type="submit" class="btn btn-primary w-100">
        <i class="bi bi-person-plus me-2"></i>Create Account
    </button>
</form>

<p class="text-center mt-3 mb-0" style="font-size:0.875rem; color:#64748b">
    Already have an account?
    <a href="{{ route('login') }}" class="text-decoration-none fw-semibold" style="color:#4f46e5">Sign in</a>
</p>
@endsection
