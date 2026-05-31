@extends('layouts.app')

@section('title', 'Orders List')
@section('page-title', 'Orders List')

@section('content')

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span><i class="bi bi-cart3 me-2 text-primary"></i>My Orders</span>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addOrderModal">
            <i class="bi bi-plus-lg me-1"></i>Add Order
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Notes</th>
                        <th>Date</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    @php
                        $colors = ['Pending'=>'warning','Processing'=>'info','Completed'=>'success','Cancelled'=>'danger'];
                        $color = $colors[$order->status] ?? 'secondary';
                    @endphp
                    <tr>
                        <td class="text-muted">{{ $loop->iteration }}</td>
                        <td class="fw-medium">{{ $order->customer_name }}</td>
                        <td>{{ $order->product_name }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>₱{{ number_format($order->price, 2) }}</td>
                        <td class="fw-semibold">₱{{ number_format($order->quantity * $order->price, 2) }}</td>
                        <td><span class="badge text-bg-{{ $color }} badge-status">{{ $order->status }}</span></td>
                        <td class="text-muted" style="max-width:150px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                            {{ $order->notes ?? '—' }}
                        </td>
                        <td class="text-muted">{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('orders.edit', $order) }}" class="btn btn-sm btn-outline-secondary me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('orders.destroy', $order) }}" class="d-inline"
                                  onsubmit="return confirm('Delete this order?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-2 d-block mb-2"></i>No orders yet. Add your first order!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Order Modal -->
<div class="modal fade" id="addOrderModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <form method="POST" action="{{ route('orders.store') }}">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Add New Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Customer Name</label>
                            <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror"
                                   value="{{ old('customer_name') }}" required>
                            @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Product Name</label>
                            <input type="text" name="product_name" class="form-control @error('product_name') is-invalid @enderror"
                                   value="{{ old('product_name') }}" required>
                            @error('product_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Quantity</label>
                            <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror"
                                   value="{{ old('quantity', 1) }}" min="1" required>
                            @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Price (₱)</label>
                            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                                   value="{{ old('price') }}" min="0" step="0.01" required>
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Status</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                @foreach(['Pending','Processing','Completed','Cancelled'] as $s)
                                    <option value="{{ $s }}" {{ old('status', 'Pending') === $s ? 'selected' : '' }}>{{ $s }}</option>
                                @endforeach
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-medium">Notes <span class="text-muted fw-normal">(optional)</span></label>
                            <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-1"></i>Add Order
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
        var modal = new bootstrap.Modal(document.getElementById('addOrderModal'));
        modal.show();
    @endif
</script>
@endpush
