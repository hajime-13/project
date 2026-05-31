@extends('layouts.app')

@section('title', 'Edit Menu Item')
@section('page-title', 'Edit Menu Item')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-pencil me-2 text-primary"></i>Edit — {{ $menu->name }}
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('menus.update', $menu) }}">
                    @csrf @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Item Name</label>
                            <input type="text" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $menu->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Category</label>
                            <input type="text" name="category"
                                   class="form-control @error('category') is-invalid @enderror"
                                   value="{{ old('category', $menu->category) }}" required>
                            @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Price (₱)</label>
                            <input type="number" name="price"
                                   class="form-control @error('price') is-invalid @enderror"
                                   value="{{ old('price', $menu->price) }}" min="0" step="0.01" required>
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Availability</label>
                            <select name="availability" class="form-select" required>
                                <option value="Available" {{ old('availability', $menu->availability) === 'Available' ? 'selected' : '' }}>Available</option>
                                <option value="Unavailable" {{ old('availability', $menu->availability) === 'Unavailable' ? 'selected' : '' }}>Unavailable</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-medium">Description <span class="text-muted fw-normal">(optional)</span></label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $menu->description) }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>Save Changes
                        </button>
                        <a href="{{ route('menus.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
