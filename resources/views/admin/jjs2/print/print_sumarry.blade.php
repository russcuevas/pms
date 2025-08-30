<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JJS2 Admin Dashboard</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background-color: #e9ecef;
        }
        .confirmation-card {
            max-width: 600px;
            margin: auto;
            margin-top: 100px;
        }

        .bottom-nav {
            position: fixed;
            bottom: 0;
            width: 100%;
            background: #000;
            display: flex;
            justify-content: space-around;
            padding: 10px 0;
            z-index: 9999;
        }

        .bottom-nav a {
            color: #fff;
            text-align: center;
            font-size: 14px;
            text-decoration: none;
        }

        .bottom-nav a.active {
            color: #28a745;
        }
    </style>
</head>
<body>

    <!-- Header Bar -->
    <div class="bg-dark text-white py-3" style="background-color: #44444E !important">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6">
                    <div class="d-flex align-items-center">
                        <div>
                            <small class="text-uppercase text-white">JJS2 BLDG ADMIN PANEL</small>
                            <div class="fw-bold">Admin: {{ Auth::guard('admins')->user()->fullname ?? 'Admin User' }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 text-end">
                    <a href="{{ route('admin.logout.request') }}" class="text-white text-decoration-none">
                        <i class="fas fa-sign-out-alt fs-5"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Card -->
    <div class="container confirmation-card">
        <div class="card shadow-lg border-0">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                </div>
                <h3 class="mb-3">Tenant Successfully Moved Out</h3>
                <p class="text-muted mb-4">You can now print the tenant’s billing and payment summaries below.</p>

                <div class="d-grid gap-3 d-md-flex justify-content-md-center">
                    <a href="{{ route('admin.jjs2.print.billings') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-file-invoice-dollar me-2"></i> Print Billings PDF
                    </a>
                    <a href="{{ route('admin.jjs2.print.payments') }}" class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-file-alt me-2"></i> Print Payments PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

                <!-- Bottom Navigation -->
                <div class="bottom-nav" style="background-color: #44444E !important">
                    <a href="{{ route('admin.jjs2.dashboard.page') }}" style="text-decoration: none">
                        <i class="fas fa-home"></i><br>Back to dashboard
                    </a>
                </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
