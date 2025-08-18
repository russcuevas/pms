<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hubert Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            z-index: 9999 !important;
        }

        .bottom-nav a {
            color: #fff;
            text-align: center;
            font-size: 14px;
        }

        .bottom-nav a.active {
            color: #28a745;
        }
    </style>

</head>
<body>
        <div class="bg-dark text-white py-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6">
                    <div class="d-flex align-items-center">
                        <div>
                            <small class="text-uppercase text-white">HUBERTS ADMIN PANEL</small>
                            <div class="fw-bold">Admin: {{ Auth::user()->name ?? 'Admin User' }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 text-end">
                    <a href="{{ route('admin.logout.request') }}" class="text-white text-decoration-none">
                        <i class="fas fa-sign-out-alt fs-5"></i>Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
<div class="container mt-5">
    <h2>Balance Status</h2>
    <div class="mb-4">
        <a href="{{ route('admin.hubert.balance.page') }}" class="btn btn-info">All Billings</a>
        <a href="{{ route('admin.hubert.balance.paid.page') }}" class="btn btn-success">Paid</a>
        <a href="{{ route('admin.hubert.balance.delinquent.page') }}" class="btn btn-danger">Delinquent</a>
    </div>
    <div class="table-responsive">
    <table id="balanceTable" class="table table-bordered">
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
                <td>₱{{ $billing->total_balance_to_pay }}</td>
                <td>
                    @if ($billing->status === 'paid')
                        <span style="text-transform: capitalize" class="badge bg-success">{{ $billing->status }}</span>
                    @else
                        <span style="text-transform: capitalize" class="badge bg-danger">{{ $billing->status }}</span>
                    @endif
                </td>
                <td>
                    <!-- Trigger Modal -->
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
                                                        <li><strong>Total Electricity:</strong> {{ number_format($billing->total_electricity, 2) }}</li>
                                                    </ul>
                                                </td>
                                                <td class="col-6">
                                                    <strong>Water</strong>
                                                    <ul>
                                                        <li><strong>Current:</strong> {{ $billing->current_water }}</li>
                                                        <li><strong>Previous:</strong> {{ $billing->previous_water }}</li>
                                                        <li><strong>Consumption:</strong> {{ $billing->consumption_water }}</li>
                                                        <li><strong>Rate per cu.m:</strong> {{ $billing->rate_per_cu_water }}</li>
                                                        <li><strong>Total Water:</strong> {{ number_format($billing->total_water, 2) }}</li>
                                                    </ul>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Payment Computation</th>
                                                <td>
                                                    <strong>TO PAY:</strong> {{ number_format($billing->total_payment, 2) }}<br>
                                                    <strong>TENANT PAY AMOUNT:</strong> {{ number_format($billing->amount, 2) }}<br>
                                                    <hr>
                                                    <strong>Balance for that month:</strong> 
                                                    {{ number_format($billing->total_payment - $billing->amount, 2) }} - {{ ucfirst($billing->status) }}
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
</div>

            <!-- Bottom Navigation -->
            <div class="bottom-nav">
                <a href="{{ route('admin.huberts.dashboard.page') }}" style="text-decoration: none">
                    <i class="fas fa-home"></i><br>Back to dashboard
                </a>
            </div>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
            <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
            <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

            
            <script>
                $(document).ready(function () {
                    $('#balanceTable').DataTable({
                        responsive: true,
                        pageLength: 10,
                    });
                });
            </script>
</body>
</html>