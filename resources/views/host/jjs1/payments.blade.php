<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>JJS1 Host Dashboard</title>

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
    </style>
</head>

<body>

    <!-- TOP NAV BAR -->
    <div class="bg-dark text-white py-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6">
                    <small class="text-uppercase text-white">JJS1 BLDG HOST PANEL</small>
                    <div class="fw-bold">Host/Owner</div>
                </div>
                <div class="col-6 text-end">
                    <a href="{{ route('host.logout.request') }}" class="text-white text-decoration-none">
                        <i class="fas fa-sign-out-alt fs-5"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="container my-5">
        <h2 class="mb-4">Tenant Payments</h2>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($payments->isEmpty())
        <div class="alert alert-info">No payment records found.</div>
        @else
        <table id="paymentsTable" class="table table-bordered table-striped nowrap" style="width:100%">
            <thead class="table-dark">
                <tr>
                    <th>Tenant</th>
                    <th>Unit</th>
                    <th>Amount</th>
                    <th>For the Month Of</th>
                    <th>Reference #</th>
                    <th>Mode of Payment</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Actions</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $payment)
                <tr id="payment-row-{{ $payment->id }}">
                    <td>{{ $payment->tenant_name }}</td>
                    <td>{{ $payment->unit_name }}</td>
                    <td>PHP {{ number_format($payment->amount, 2) }}</td>
                    <td>{{ $payment->for_the_month_of }}</td>
                    <td>{{ $payment->reference_number }}</td>
                    <td>{{ ucfirst($payment->mode_of_payment) }}</td>
                    <td>{{ ucfirst($payment->type) }}</td>
                    <td>
                        @if ($payment->is_approved == 1)
                        <span class="badge bg-success">Approved</span>
                        @else
                        <span class="badge bg-warning text-dark">Pending</span>
                        @endif
                    </td>
                    <td>
                        @if ($payment->is_approved != 1)
                        <form action="{{ route('host.huberts.payments.approve', $payment->id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success mb-1">
                                <i class="fas fa-check"></i> Approve
                            </button>
                        </form>
                        <form action="{{ route('host.huberts.payments.decline', $payment->id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger mb-1">
                                <i class="fas fa-times"></i> Decline
                            </button>
                        </form>
                        @else
                        <small class="text-muted">No actions</small>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('M d, Y h:i A') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    <!-- Bottom Navigation -->
    <div class="bottom-nav">
        <a href="{{ route('host.huberts.dashboard.page') }}">
            <i class="fas fa-home"></i><br />Back to dashboard
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
            $('#paymentsTable').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                language: {
                    emptyTable: "No payment records available.",
                },
                columnDefs: [
                    { responsivePriority: 1, targets: -1 },  // Actions highest priority
                    { responsivePriority: 2, targets: -2 }   // Status second highest priority
                ]
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
