<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FinalProj') — OrderTrack</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 250px;
            --primary: #4f46e5;
            --primary-dark: #3730a3;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
        }

        /* Sidebar */
        #sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: linear-gradient(180deg, #1e1b4b 0%, #312e81 100%);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: transform 0.3s ease;
        }

        #sidebar .sidebar-brand {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        #sidebar .sidebar-brand h5 {
            color: #fff;
            font-weight: 700;
            font-size: 1.1rem;
            margin: 0;
        }

        #sidebar .sidebar-brand small {
            color: #a5b4fc;
            font-size: 0.75rem;
        }

        #sidebar .nav-link {
            color: #c7d2fe;
            padding: 0.65rem 1.25rem;
            border-radius: 0.5rem;
            margin: 0.1rem 0.75rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        #sidebar .nav-link:hover,
        #sidebar .nav-link.active {
            background: rgba(255,255,255,0.15);
            color: #fff;
        }

        #sidebar .nav-link i {
            font-size: 1rem;
            width: 1.25rem;
            text-align: center;
        }

        #sidebar .nav-section {
            color: #818cf8;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 1rem 1.25rem 0.25rem;
        }

        /* Main content */
        #main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top navbar */
        #topbar {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.75rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .page-content {
            padding: 1.75rem 1.5rem;
            flex: 1;
        }

        /* Cards */
        .stat-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        }

        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #f1f5f9;
            border-radius: 1rem 1rem 0 0 !important;
            padding: 1rem 1.25rem;
            font-weight: 600;
        }

        /* Tables */
        .table th {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            border-bottom: 2px solid #f1f5f9;
        }

        .table td {
            vertical-align: middle;
            font-size: 0.875rem;
        }

        /* Badges */
        .badge-status {
            font-size: 0.75rem;
            padding: 0.35em 0.75em;
            border-radius: 2rem;
            font-weight: 500;
        }

        /* Toast container */
        .toast-container {
            position: fixed;
            top: 1.25rem;
            right: 1.25rem;
            z-index: 9999;
        }

        /* Avatar */
        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
        }

        .avatar-placeholder {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--primary);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.875rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            #sidebar {
                transform: translateX(-100%);
            }
            #sidebar.show {
                transform: translateX(0);
            }
            #main-content {
                margin-left: 0;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- Sidebar -->
    <nav id="sidebar">
        <div class="sidebar-brand">
            <h5><i class="bi bi-box-seam me-2"></i>OrderTrack</h5>
            <small>Management System</small>
        </div>

        <div class="pt-2 pb-3">
            <div class="nav-section">Main</div>
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <div class="nav-section">Management</div>
            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Users
            </a>
            <a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                <i class="bi bi-cart3"></i> Orders
            </a>

            <div class="nav-section">Account</div>
            <a href="{{ route('profile.show') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i> My Profile
            </a>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="nav-link w-100 border-0 bg-transparent text-start">
                    <i class="bi bi-box-arrow-left"></i> Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    <div id="main-content">

        <!-- Topbar -->
        <div id="topbar" class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm btn-light d-md-none" id="sidebarToggle">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <h6 class="mb-0 fw-600">@yield('page-title', 'Dashboard')</h6>
            </div>
            <div class="d-flex align-items-center gap-2">
                @if(Auth::user()->profile_picture)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url(Auth::user()->profile_picture) }}" class="avatar" alt="Profile">
                @else
                    <div class="avatar-placeholder">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                @endif
                <div class="d-none d-sm-block">
                    <div class="fw-semibold" style="font-size:0.875rem; line-height:1.2">{{ Auth::user()->name }}</div>
                    <div class="text-muted" style="font-size:0.75rem">{{ ucfirst(Auth::user()->role) }}</div>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <div class="page-content">
            @yield('content')
        </div>

    </div>

    <!-- Toast Notifications -->
    <div class="toast-container">
        @if(session('toast_success'))
        <div class="toast align-items-center text-bg-success border-0 show" role="alert" id="toastSuccess">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle me-2"></i>{{ session('toast_success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        @endif

        @if(session('toast_error'))
        <div class="toast align-items-center text-bg-danger border-0 show" role="alert" id="toastError">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-exclamation-circle me-2"></i>{{ session('toast_error') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        @endif
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Auto-dismiss toasts after 4 seconds
        document.querySelectorAll('.toast').forEach(function(toastEl) {
            var toast = new bootstrap.Toast(toastEl, { delay: 4000 });
            toast.show();
        });

        // Sidebar toggle for mobile
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });
    </script>

    @stack('scripts')
</body>
</html>
