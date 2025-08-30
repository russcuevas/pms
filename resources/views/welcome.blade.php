<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AVA</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" />

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

</head>
<body class="bg-light">

    <!-- Welcome Section -->
    <div class="container mt-5">
        <h1 class="text-center text-success mb-4">WELCOME TO AVA</h1>

        <div class="row justify-content-center">
            <!-- Host Login Card -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h3 class="card-title mb-3">Host Login</h3>
                        <p class="card-text mb-3">Access your host dashboard manage properties and tenants.</p>
                        <a href="{{ route('host.login.page') }}" class="btn btn-success w-100">Login as Host</a>
                    </div>
                </div>
            </div>

            <!-- Admin Login Card -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h3 class="card-title mb-3">Admin Login</h3>
                        <p class="card-text mb-3">Login to manage users and system settings.</p>
                        <a href="{{ route('admin.login.page') }}" class="btn btn-success w-100">Login as Admin</a>
                    </div>
                </div>
            </div>

            <!-- Tenant Login Card -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h3 class="card-title mb-3">Tenant Login</h3>
                        <p class="card-text mb-3">Login to view your rental details and make payments.</p>
                        <a href="{{ route('tenants.login.page') }}" class="btn btn-success w-100">Login as Tenant</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toastr Success Message -->
    <script>
        @if (session('success'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "3000"
            };
            toastr.success("{{ session('success') }}");
        @endif
    </script>

</body>
</html>
