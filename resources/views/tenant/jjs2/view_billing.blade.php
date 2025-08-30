<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JJS2 Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    {{-- CUSTOM CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/tenants/dashboard.css') }}">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    {{-- SWEETALERT CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <style>
        .clean-table, 
        .clean-table th, 
        .clean-table td, 
        .clean-table thead, 
        .clean-table tbody, 
        .clean-table tr {
            border: none !important;
        }

        @media (max-width: 576px) {
    .table-responsive table td,
    .table-responsive table th {
        white-space: nowrap;
    }
}

    </style>

</head>
<body class="bg-light">
    <!-- Header -->
        @include('tenant.jjs2.header')


<div class="container py-4">
    <h2 class="mb-4">My Billing Records</h2>
    <div class="table-responsive">

<table id="billingTable" class="table table-borderless align-middle text-center clean-table">
    <thead>
        <tr>
            <th>Month & Year</th>
            <th>Actions</th>
        </tr>
        <tr>
            <th>
                <input type="text" id="searchMonth" placeholder="Search Month Or Year" class="form-control form-control-sm">
            </th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($billings as $billing)
            <tr>
                <td style="font-weight: 600">{{ \Carbon\Carbon::parse($billing->for_the_month_of)->format('F Y') }}</td>
                <td>
                    <button type="button" 
                        class="btn btn-sm btn-warning" 
                        data-bs-toggle="modal" 
                        data-bs-target="#billingModal{{ $billing->id }}">
                        <i class="bi bi-eye"></i> View Summary
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
    </div>


    {{-- Modals outside the table --}}
    @foreach ($billings as $billing)
        <div class="modal fade" id="billingModal{{ $billing->id }}" tabindex="-1" aria-labelledby="billingModalLabel{{ $billing->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header text-white" style="background-color: #715A5A !important">
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

                            <tr><td colspan="2"><strong>ELECTRICTY & WATER BREAKDOWN</strong></td></tr>
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
                                    <strong>YOU PAY AMOUNT:</strong> {{ number_format($billing->amount, 2) }}<br>
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
    @endforeach
</div>
    <!-- Bottom Navigation -->
    <nav class="navbar fixed-bottom navbar-light bg-white border-top" style="background-color: #715A5A !important">
        <div class="container-fluid">
            <div class="d-flex w-100 justify-content-around">
                <a class="navbar-brand text-white text-center flex-fill border-end" href="{{ route('tenants.jjs2.dashboard.page') }}">
                    <div><i class="fas fa-home"></i></div>
                    <small>Home</small>
                </a>
                <a class="navbar-brand text-white text-center flex-fill border-end" href="{{ route('tenants.jjs2.my-request.page') }}">
                    <div><i class="fas fa-file-alt"></i></div>
                    <small>Requests</small>
                </a>
                <a class="navbar-brand text-white text-center flex-fill" href="{{ route('tenants.jjs2.announcement.page') }}">
                    <div><i class="fas fa-bullhorn"></i></div>
                    <small>Announcement</small>
                </a>
            </div>
        </div>
    </nav>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <script>
    $(document).ready(function () {
        let table = $('#billingTable').DataTable({
            responsive: true,
            orderCellsTop: true,
            fixedHeader: true,
            dom: 'lrtip'
        });

        $('#billingTable thead tr:eq(1) th').each(function (i) {
            $('input', this).on('keyup change', function () {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });
    });
    </script>



    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif
    </script>

    <script>
        document.getElementById('notif-toggle').addEventListener('click', function () {
        document.getElementById('notif-dropdown').classList.toggle('hidden');
        });

        window.addEventListener('click', function (e) {
            if (!e.target.closest('#notif-toggle') && !e.target.closest('#notif-dropdown')) {
                document.getElementById('notif-dropdown').classList.add('hidden');
            }
        });
    </script>
</body>
</html>