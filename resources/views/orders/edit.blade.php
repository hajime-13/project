@extends('layouts.app')

@section('title', 'Edit Order')
@section('page-title', 'Edit Order')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-pencil me-2 text-primary"></i>Edit Order #{{ $order->id }}
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('orders.update', $order) }}">
                    @csrf @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Customer Name</label>
                            <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror"
                                   value="{{ old('customer_name', $order->customer_name) }}" required>
                            @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Product Name</label>
                            <input type="text" name="product_name" class="form-control @error('product_name') is-invalid @enderror"
                                   value="{{ old('product_name', $order->product_name) }}" required>
                            @error('product_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Quantity</label>
                            <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror"
                                   value="{{ old('quantity', $order->quantity) }}" min="1" required>
                            @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Price (₱)</label>
                            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                                   value="{{ old('price', $order->price) }}" min="0" step="0.01" required>
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Status</label>
                            <select name="status" class="form-select" required>
                                @foreach(['Pending','Processing','Completed','Cancelled'] as $s)
                                    <option value="{{ $s }}" {{ old('status', $order->status) === $s ? 'selected' : '' }}>{{ $s }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-medium">Notes <span class="text-muted fw-normal">(optional)</span></label>
                            <textarea name="notes" class="form-control" rows="3">{{ old('notes', $order->notes) }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>Save Changes
                        </button>
                        <a href="{{ route('orders.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
