@extends('layouts.app')

@section('title', 'Orders List')
@section('page-title', 'Orders List')

@section('content')

<div class="card">
    <div class="card-header">
        <span><i class="bi bi-cart3 me-2 text-primary"></i>My Orders</span>
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
                            <i class="bi bi-inbox fs-2 d-block mb-2"></i>No orders found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
