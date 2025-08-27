<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JJS1 Host Dashboard</title>

    <!-- CSS Dependencies -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

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
        }

        .bottom-nav a {
            color: #fff;
            text-align: center;
            font-size: 14px;
            text-decoration: none;
        }

        .bottom-nav a.active {
            color: #dc3545;
        }
    </style>
</head>
<body>

    <!-- TOP NAV BAR -->
    <div class="bg-dark text-white py-3" style="background-color: #44444E !important">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6">
                    <div>
                        <small class="text-uppercase text-white">JJS1 BLDG HOST PANEL</small>
                        <div class="fw-bold">Host/Owner</div>
                    </div>
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
        <h2>Delinquent Billings</h2>

        <!-- Filter Buttons -->
        <div class="mb-4">
            <a href="{{ route('host.jjs1.balance.page') }}" class="btn btn-info">All Billings</a>
            <a href="{{ route('host.jjs1.balance.paid.page') }}" class="btn btn-success">Paid</a>
            <a href="{{ route('host.jjs1.balance.delinquent.page') }}" class="btn btn-danger">Delinquent</a>
        </div>

        <table id="balanceTable" class="table table-bordered table-striped nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>SOA No.</th>
                    <th>Name</th>
                    <th>Unit</th>
                    <th>Balance</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($billings as $billing)
                <tr>
                    <td>{{ $billing->soa_no }}</td>
                    <td>{{ $billing->fullname }}</td>
                    <td>{{ $billing->units_name }}</td>
                    <td>₱{{ number_format($billing->total_balance_to_pay, 2) }}</td>
                    <td>
                        @if ($billing->status === 'paid')
                            <span class="badge bg-success">{{ ucfirst($billing->status) }}</span>
                        @else
                            <span class="badge bg-danger">{{ ucfirst($billing->status) }}</span>
                        @endif
                    </td>
                    <td>
                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#billingModal{{ $billing->id }}">
                            View Details
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="billingModal{{ $billing->id }}" tabindex="-1" aria-labelledby="billingModalLabel{{ $billing->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header text-white" style="background-color: black">
                                        <h5 class="modal-title">Billing Summary - SOA No: {{ $billing->soa_no }}</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h5>Unit: {{ $billing->units_name }}</h5>
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr><th>Acct No</th><td>{{ $billing->account_number }}</td></tr>
                                                <tr><th>SOA No</th><td>{{ $billing->soa_no }}</td></tr>
                                                <tr><th>For the Month Of</th><td>{{ $billing->for_the_month_of }}</td></tr>
                                                <tr><th>Statement Date</th><td>{{ $billing->statement_date }}</td></tr>
                                                <tr><th>Due Date</th><td>{{ $billing->due_date }}</td></tr>
                                                <tr><td colspan="2"><strong>BILLING BREAKDOWN</strong></td></tr>
                                                <tr><th>Rental</th><td>{{ number_format($billing->rental, 2) }}</td></tr>
                                                <tr><th>Water</th><td>{{ number_format($billing->water, 2) }}</td></tr>
                                                <tr><th>Electricity</th><td>{{ number_format($billing->electricity, 2) }}</td></tr>
                                                <tr><th>Parking</th><td>{{ number_format($billing->parking, 2) }}</td></tr>
                                                <tr><th>Foam</th><td>{{ number_format($billing->foam, 2) }}</td></tr>
                                                <tr><th>Previous Balance</th><td>{{ number_format($billing->previous_balance, 2) }}</td></tr>
                                                <tr><th>Total Payment</th><td>{{ number_format($billing->total_payment, 2) }}</td></tr>

                                                <tr><td colspan="2"><strong>ELECTRICITY & WATER BREAKDOWN</strong></td></tr>
                                                <tr>
                                                    <td class="col-6">
                                                        <strong>Electricity</strong>
                                                        <ul>
                                                            <li><strong>Current:</strong> {{ $billing->current_electricity }}</li>
                                                            <li><strong>Previous:</strong> {{ $billing->previous_electricity }}</li>
                                                            <li><strong>Consumption:</strong> {{ $billing->consumption_electricity }}</li>
                                                            <li><strong>Rate per kWh:</strong> {{ $billing->rate_per_kwh_electricity }}</li>
                                                            <li><strong>Total:</strong> {{ number_format($billing->total_electricity, 2) }}</li>
                                                        </ul>
                                                    </td>
                                                    <td class="col-6">
                                                        <strong>Water</strong>
                                                        <ul>
                                                            <li><strong>Current:</strong> {{ $billing->current_water }}</li>
                                                            <li><strong>Previous:</strong> {{ $billing->previous_water }}</li>
                                                            <li><strong>Consumption:</strong> {{ $billing->consumption_water }}</li>
                                                            <li><strong>Rate per cu.m:</strong> {{ $billing->rate_per_cu_water }}</li>
                                                            <li><strong>Total:</strong> {{ number_format($billing->total_water, 2) }}</li>
                                                        </ul>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Payment Computation</th>
                                                    <td>
                                                        <strong>TO PAY:</strong> {{ number_format($billing->total_payment, 2) }}<br>
                                                        <strong>TENANT PAID:</strong> {{ number_format($billing->amount, 2) }}<br>
                                                        <hr>
                                                        <strong>Balance:</strong> 
                                                        {{ number_format($billing->total_payment - $billing->amount, 2) }} - 
                                                        <span class="text-uppercase">{{ $billing->status }}</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Modal -->
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Bottom Navigation -->
                <div class="bottom-nav" style="background-color: #44444E !important">
                    <a href="{{ route('host.jjs1.dashboard.page') }}" style="text-decoration: none">
                        <i class="fas fa-home"></i><br>Back to dashboard
                    </a>
                </div>

    <!-- JS Dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- DataTable Init -->
    <script>
        $(document).ready(function () {
            $('#balanceTable').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                language: {
                    emptyTable: "No delinquent billing records found."
                },
                columnDefs: [
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: -1 }
                ]
            });
        });
    </script>

    <!-- Toastr Success -->
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
