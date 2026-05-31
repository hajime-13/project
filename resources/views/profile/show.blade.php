@extends('layouts.app')

@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body text-center py-4">
                <!-- Profile Picture -->
                @if($user->profile_picture)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($user->profile_picture) }}"
                         class="rounded-circle mb-3 border border-3 border-primary"
                         style="width:100px;height:100px;object-fit:cover" alt="Profile">
                @else
                    <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center border border-3 border-primary"
                         style="width:100px;height:100px;background:linear-gradient(135deg,#4f46e5,#7c3aed);font-size:2.5rem;color:#fff;font-weight:700">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif

                <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                <span class="badge {{ $user->role === 'admin' ? 'text-bg-primary' : 'text-bg-secondary' }} mb-3">
                    {{ ucfirst($user->role) }}
                </span>
            </div>

            <div class="card-body border-top pt-3">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="text-muted" style="font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em">Email</div>
                        <div class="fw-medium">{{ $user->email }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted" style="font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em">Phone</div>
                        <div class="fw-medium">{{ $user->phone ?? '—' }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted" style="font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em">Gender</div>
                        <div class="fw-medium">{{ $user->gender ?? '—' }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted" style="font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em">Member Since</div>
                        <div class="fw-medium">{{ $user->created_at->format('F d, Y') }}</div>
                    </div>
                    <div class="col-12">
                        <div class="text-muted" style="font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em">Address</div>
                        <div class="fw-medium">{{ $user->address ?? '—' }}</div>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-transparent border-top-0 pb-3 px-3">
                <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-1"></i>Edit Profile
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
