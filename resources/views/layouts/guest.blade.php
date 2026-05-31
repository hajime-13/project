<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'OrderTrack')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1e1b4b 0%, #4f46e5 50%, #7c3aed 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-card {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 440px;
            padding: 2.5rem;
        }

        .auth-logo {
            text-align: center;
            margin-bottom: 1.75rem;
        }

        .auth-logo .logo-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border-radius: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.75rem;
        }

        .auth-logo h4 {
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }

        .auth-logo p {
            color: #64748b;
            font-size: 0.875rem;
            margin: 0;
        }

        .form-control {
            border-radius: 0.625rem;
            border: 1.5px solid #e2e8f0;
            padding: 0.65rem 1rem;
            font-size: 0.9rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79,70,229,0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border: none;
            border-radius: 0.625rem;
            padding: 0.7rem;
            font-weight: 600;
            font-size: 0.9rem;
            transition: opacity 0.2s, transform 0.1s;
        }

        .btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .form-label {
            font-weight: 500;
            font-size: 0.875rem;
            color: #374151;
        }

        .toast-container {
            position: fixed;
            top: 1.25rem;
            right: 1.25rem;
            z-index: 9999;
        }
    </style>
</head>
<body>

    <div class="auth-card">
        <div class="auth-logo">
            <div class="logo-icon">
                <i class="bi bi-box-seam text-white fs-4"></i>
            </div>
            <h4>OrderTrack</h4>
            <p>@yield('subtitle', 'Management System')</p>
        </div>

        @yield('content')
    </div>

    <!-- Toast Notifications -->
    <div class="toast-container">
        @if(session('toast_success'))
        <div class="toast align-items-center text-bg-success border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle me-2"></i>{{ session('toast_success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.toast').forEach(function(toastEl) {
            var toast = new bootstrap.Toast(toastEl, { delay: 4000 });
            toast.show();
        });
    </script>
</body>
</html>
