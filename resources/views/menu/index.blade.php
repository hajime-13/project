@extends('layouts.app')

@section('title', 'Menu List')
@section('page-title', 'Menu List')

@section('content')

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span><i class="bi bi-journal-text me-2 text-primary"></i>My Menu Items</span>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addMenuModal">
            <i class="bi bi-plus-lg me-1"></i>Add Item
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Availability</th>
                        <th>Date Added</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menu as $menu)
                    <tr>
                        <td class="text-muted">{{ $loop->iteration }}</td>
                        <td class="fw-medium">{{ $menu->name }}</td>
                        <td>
                            <span class="badge text-bg-light text-dark border">{{ $menu->category }}</span>
                        </td>
                        <td class="fw-semibold">₱{{ number_format($menu->price, 2) }}</td>
                        <td class="text-muted" style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                            {{ $menu->description ?? '—' }}
                        </td>
                        <td>
                            <span class="badge {{ $menu->availability === 'Available' ? 'text-bg-success' : 'text-bg-danger' }} badge-status">
                                {{ $menu->availability }}
                            </span>
                        </td>
                        <td class="text-muted">{{ $menu->created_at->format('M d, Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('menu.edit', $menu) }}" class="btn btn-sm btn-outline-secondary me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('menu.destroy', $menu) }}" class="d-inline"
                                  onsubmit="return confirm('Remove {{ addslashes($menu->name) }} from menu?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            <i class="bi bi-journal-x fs-2 d-block mb-2"></i>No menu items yet. Add your first item!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Menu Item Modal -->
<div class="modal fade" id="addMenuModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <form method="POST" action="{{ route('menu.store') }}">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Add Menu Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Item Name</label>
                            <input type="text" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" placeholder="e.g. Chicken Adobo" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Category</label>
                            <input type="text" name="category"
                                   class="form-control @error('category') is-invalid @enderror"
                                   value="{{ old('category') }}" placeholder="e.g. Main Course, Drinks" required>
                            @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Price (₱)</label>
                            <input type="number" name="price"
                                   class="form-control @error('price') is-invalid @enderror"
                                   value="{{ old('price') }}" min="0" step="0.01" placeholder="0.00" required>
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Availability</label>
                            <select name="availability" class="form-select" required>
                                <option value="Available" {{ old('availability', 'Available') === 'Available' ? 'selected' : '' }}>Available</option>
                                <option value="Unavailable" {{ old('availability') === 'Unavailable' ? 'selected' : '' }}>Unavailable</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-medium">Description <span class="text-muted fw-normal">(optional)</span></label>
                            <textarea name="description" class="form-control" rows="2"
                                      placeholder="Brief description of the item...">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-1"></i>Add Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    @if($errors->any())
        var modal = new bootstrap.Modal(document.getElementById('addMenuModal'));
        modal.show();
    @endif
</script>
@endpush
