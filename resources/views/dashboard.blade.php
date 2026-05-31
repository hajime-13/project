@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
    .stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 0.875rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
    }
</style>
@endpush

@section('content')

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:#ede9fe; color:#7c3aed">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-size:0.8rem">Total Users</div>
                    <div class="fw-bold fs-4">{{ $totalUsers }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:#dbeafe; color:#2563eb">
                    <i class="bi bi-cart-fill"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-size:0.8rem">My Orders</div>
                    <div class="fw-bold fs-4">{{ $totalOrders }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:#dcfce7; color:#16a34a">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-size:0.8rem">Completed</div>
                    <div class="fw-bold fs-4">{{ $ordersByStatus['Completed'] ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:#fef9c3; color:#ca8a04">
                    <i class="bi bi-clock-fill"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-size:0.8rem">Pending</div>
                    <div class="fw-bold fs-4">{{ $ordersByStatus['Pending'] ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-3 mb-4">
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-bar-chart me-2 text-primary"></i>Orders Per Month</span>
            </div>
            <div class="card-body">
                <canvas id="ordersChart" height="120"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-pie-chart me-2 text-primary"></i>Orders by Status
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                <canvas id="statusChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span><i class="bi bi-clock-history me-2 text-primary"></i>Recent Orders</span>
        <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
    </div>
    <div class="card-body p-0">
        @if($recentOrders->isEmpty())
            <div class="text-center py-4 text-muted">
                <i class="bi bi-inbox fs-2 d-block mb-2"></i>No orders yet.
            </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Customer</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    <tr>
                        <td class="fw-medium">{{ $order->customer_name }}</td>
                        <td>{{ $order->product_name }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>₱{{ number_format($order->quantity * $order->price, 2) }}</td>
                        <td>
                            @php
                                $colors = ['Pending'=>'warning','Processing'=>'info','Completed'=>'success','Cancelled'=>'danger'];
                                $color = $colors[$order->status] ?? 'secondary';
                            @endphp
                            <span class="badge text-bg-{{ $color }} badge-status">{{ $order->status }}</span>
                        </td>
                        <td class="text-muted">{{ $order->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
    // Orders per month bar chart
    const monthLabels = @json($ordersPerMonth->pluck('month'));
    const monthCounts = @json($ordersPerMonth->pluck('count'));

    new Chart(document.getElementById('ordersChart'), {
        type: 'bar',
        data: {
            labels: monthLabels.length ? monthLabels : ['No data'],
            datasets: [{
                label: 'Orders',
                data: monthCounts.length ? monthCounts : [0],
                backgroundColor: 'rgba(79, 70, 229, 0.7)',
                borderColor: '#4f46e5',
                borderWidth: 1,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });

    // Status doughnut chart
    const statusData = @json($ordersByStatus);
    const statusLabels = Object.keys(statusData);
    const statusCounts = Object.values(statusData);

    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: statusLabels.length ? statusLabels : ['No data'],
            datasets: [{
                data: statusCounts.length ? statusCounts : [1],
                backgroundColor: ['#f59e0b','#3b82f6','#22c55e','#ef4444'],
                borderWidth: 2,
                borderColor: '#fff',
            }]
        },
        options: {
            responsive: true,
            cutout: '65%',
            plugins: {
                legend: { position: 'bottom', labels: { padding: 15, font: { size: 12 } } }
            }
        }
    });
</script>
@endpush
