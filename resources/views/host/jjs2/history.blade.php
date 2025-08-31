<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tenant History</title>

    <!-- CSS Dependencies -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <style>
        body {
            background-color: #e9ecef;
        }

        .bottom-nav {
            position: fixed;
            bottom: 0;
            width: 100%;
            background: #000;
            display: flex;
            justify-content: space-around;
            padding: 10px 0;
            z-index: 1030;
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

        .badge {
            font-size: 12px;
        }

        .info-box {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .info-box:hover {
            transform: scale(1.05);
        }

        .info-box i {
            font-size: 40px;
            margin-bottom: 10px;
        }

        .info-box h4 {
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- TOP NAV BAR -->
    <div class="text-white py-3" style="background-color: #715A5A">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6">
                    <div>
                        <small class="text-uppercase text-white">JJS2 HOST PANEL</small>
                        <div class="fw-bold">Host/Owner</div>
                    </div>
                </div>
                <div class="col-6 text-end">
                    <a href="{{ route('host.jjs2.change-password.form') }}" class="text-white text-decoration-none me-3">
                        <i class="fas fa-user-circle fs-5"></i> Profile
                    </a>
                    <a href="{{ route('host.logout.request') }}" class="text-white text-decoration-none">
                        <i class="fas fa-sign-out-alt fs-5"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="container my-5">
        <h2 class="mb-4">TENANT MOVED OUT HISTORY</h2>

        <!-- Two-column Layout with Card Style -->
        <div class="row">
            <!-- Tenant Billings -->
            <div class="col-md-6 mb-4">
                <div class="info-box" onclick="window.location='{{ route('host.jjs2.tenant-billing-history.page') }}'">
                    <i class="fas fa-file-invoice"></i>
                    <h4>TENANT BILLINGS</h4>
                    <p>View moved out tenant billing history</p>
                </div>
            </div>

            <!-- Tenant Payments -->
            <div class="col-md-6 mb-4">
                <div class="info-box" onclick="window.location='{{ route('host.jjs2.tenant-payment-history.page') }}'">
                    <i class="fas fa-money-check-alt"></i>
                    <h4>TENANT PAYMENTS</h4>
                    <p>View moved out tenant payment history</p>
                </div>
            </div>
        </div>

    </div>

    <!-- Bottom Navigation -->
                <div class="bottom-nav" style="background-color: #715A5A !important">
                    <a href="{{ route('host.jjs2.dashboard.page') }}" style="text-decoration: none">
                        <i class="fas fa-home"></i><br>Back to dashboard
                    </a>
                </div>

    <!-- JS Dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#billingTable').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                language: {
                    emptyTable: "No billing records available.",
                }
            });
        });

        @if (session('success'))
            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-right',
                timeOut: 3000
            };
            toastr.success("{{ session('success') }}");
        @endif
    </script>

</body>
</html>
