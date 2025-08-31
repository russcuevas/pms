<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tenant Payment Details</title>

    <!-- Include CSS and JS for styling and table functionality -->
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
        <h2 class="mb-4">Payment History for Tenant: {{ $history_payments[0]->tenant_name }}</h2>
        <table class="table table-bordered table-striped" id="paymentDetailsTable">
            <thead>
                <tr>
                    <th>Unit</th>
                    <th>Amount</th>
                    <th>Month</th>
                    <th>Reference Number</th>
                    <th>Mode of Payment</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($history_payments as $payment)
                    <tr>
                        <td>{{ $payment->units_name }}</td>
                        <td>PHP {{ number_format($payment->amount, 2) }}</td>
                        <td>{{ $payment->for_the_month_of }}</td>
                        <td>{{ $payment->reference_number }}</td>
                        <td>{{ ucfirst($payment->mode_of_payment) }}</td>
                        <td>{{ ucfirst($payment->type) }}</td>
                        <td>{{ $payment->is_approved == 1 ? 'Approved' : 'Pending' }}</td>
                        <td>{{ $payment->created_at }}</td>
                        <td>{{ $payment->updated_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#paymentDetailsTable').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                language: {
                    emptyTable: "No payment records available for this tenant.",
                }
            });
        });
    </script>

</body>
</html>
