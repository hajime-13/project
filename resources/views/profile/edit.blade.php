@extends('layouts.app')

@section('title', 'Edit Profile')
@section('page-title', 'Edit Profile')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-person-gear me-2 text-primary"></i>Update Your Profile
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <!-- Profile Picture -->
                    <div class="mb-4 text-center">
                        @if($user->profile_picture)
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($user->profile_picture) }}"
                                 class="rounded-circle mb-2 border border-3 border-primary"
                                 style="width:80px;height:80px;object-fit:cover" id="previewImg" alt="Profile">
                        @else
                            <div class="mx-auto mb-2 rounded-circle d-flex align-items-center justify-content-center"
                                 style="width:80px;height:80px;background:linear-gradient(135deg,#4f46e5,#7c3aed);font-size:2rem;color:#fff;font-weight:700"
                                 id="previewPlaceholder">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <img src="" class="rounded-circle mb-2 border border-3 border-primary d-none"
                                 style="width:80px;height:80px;object-fit:cover" id="previewImg" alt="Profile">
                        @endif
                        <div>
                            <label for="profile_picture" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-camera me-1"></i>Change Photo
                            </label>
                            <input type="file" name="profile_picture" id="profile_picture" class="d-none"
                                   accept="image/*" onchange="previewPhoto(this)">
                            @error('profile_picture')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Full Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $user->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $user->email) }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Phone</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone', $user->phone) }}" placeholder="+63 9XX XXX XXXX">
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="">— Select —</option>
                                @foreach(['Male','Female','Other'] as $g)
                                    <option value="{{ $g }}" {{ old('gender', $user->gender) === $g ? 'selected' : '' }}>{{ $g }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-medium">Address</label>
                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                                   value="{{ old('address', $user->address) }}" placeholder="Street, City, Province">
                            @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Change Password Section -->
                    <hr class="my-4">
                    <h6 class="fw-semibold mb-3">Change Password <span class="text-muted fw-normal">(optional)</span></h6>

                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-medium">Current Password</label>
                            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror">
                            @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">New Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>Save Changes
                        </button>
                        <a href="{{ route('profile.show') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var img = document.getElementById('previewImg');
            var placeholder = document.getElementById('previewPlaceholder');
            img.src = e.target.result;
            img.classList.remove('d-none');
            if (placeholder) placeholder.classList.add('d-none');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
