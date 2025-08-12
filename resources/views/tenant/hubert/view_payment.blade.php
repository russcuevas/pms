<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Huberts Dashboard</title>
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
        .form-control-sm {
            font-size: 13px;
        }
        #paymentTable input {
            min-width: 80px;
        }
    }

    </style>

</head>
<body class="bg-light">
    <!-- Header -->
    <div class="bg-success text-white py-3" style="background-color: black !important">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6">
                    <div class="d-flex align-items-center">
                        <div>
                            <small class="text-uppercase" style="color: white !important">MY UNIT: {{ $unit->units_name }}</small>
                            <div class="fw-bold">{{ $tenant->fullname ?? 'Tenant Name' }}</div>
                        </div>
                    </div>
                </div>
                    <div class="col-6 text-end position-relative">
                        <span class="position-relative me-3" id="notif-toggle" style="cursor: pointer;">
                            <i class="fas fa-bell fs-5"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
                        </span>
                        <a href="{{ route('tenants.logout.request') }}" class="text-white text-decoration-none">
                            <i class="fas fa-sign-out-alt fs-5"></i>
                        </a>

                        <!-- Notification Dropdown -->
                        <div id="notif-dropdown" class="notif-dropdown shadow hidden">
                            <div class="notif-header">
                                <span>Notifications</span>
                            </div>

                            <div class="notif-content">
                                <div class="notif-item new">
                                    <div class="notif-text">
                                        <p><b>Paymaya</b> payment confirmed.</p>
                                    </div>
                                    <i class="fas fa-trash notif-delete" onclick="deleteNotif(this)"></i>
                                </div>

                                <div class="notif-item">
                                    <div class="notif-text">
                                        <p><b>Paymaya</b> payment confirmed.</p>
                                    </div>
                                    <i class="fas fa-trash notif-delete" onclick="deleteNotif(this)"></i>
                                </div>

                                <div class="notif-item">
                                    <div class="notif-text">
                                        <p><b>Paymaya</b> payment confirmed.</p>
                                    </div>
                                    <i class="fas fa-trash notif-delete" onclick="deleteNotif(this)"></i>
                                </div>                                
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <div class="container py-4">
    <h2 class="mb-4">My Payments</h2>

    <div class="table-responsive">

    <table id="paymentTable" class="table">
    <thead>
            <tr>
                <th>Reference No.</th>
                <th>Amount</th>
                <th>For Month</th>
                <th>Mode of Payment</th>
                <th>Type</th>
                {{-- <th>Unit</th>
                <th>SOA No</th> --}}
                <th>Status</th>
            </tr>
            <tr>
                <th><input type="text" placeholder="Search Ref" class="form-control form-control-sm" /></th>
                <th><input type="text" placeholder="Search Amount" class="form-control form-control-sm" /></th>
                <th><input type="text" placeholder="Search Month" class="form-control form-control-sm" /></th>
                <th><input type="text" placeholder="Search Mode" class="form-control form-control-sm" /></th>
                <th><input type="text" placeholder="Search Type" class="form-control form-control-sm" /></th>
                {{-- <th><input type="text" placeholder="Search Unit" class="form-control form-control-sm" /></th>
                <th><input type="text" placeholder="Search SOA No" class="form-control form-control-sm" /></th> --}}
                <th><input type="text" placeholder="Search Status" class="form-control form-control-sm" /></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
                <tr>
                    <td>{{ $payment->reference_number }}</td>
                    <td>₱{{ number_format($payment->amount, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($payment->for_the_month_of)->format('F Y') }}</td>
                    <td style="text-transform: uppercase">{{ $payment->mode_of_payment }}</td>
                    <td style="text-transform: uppercase">{{ $payment->type }}</td>
                    {{-- <td>{{ $payment->unit_name }}</td>
                    <td>{{ $payment->soa_no }}</td> --}}
                    <td>
                        @if ($payment->is_approved)
                            <span class="text-success" style="font-weight: 700">Approved</span>
                        @else
                            <span class="text-warning" style="font-weight: 700">Pending</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
    <!-- Bottom Navigation -->
    <nav class="navbar fixed-bottom navbar-light bg-white border-top" style="background-color: black !important">
        <div class="container-fluid">
            <div class="d-flex w-100 justify-content-around">
                <a class="navbar-brand text-white text-center flex-fill border-end" href="{{ route('tenants.huberts.dashboard.page') }}">
                    <div><i class="fas fa-home"></i></div>
                    <small>Home</small>
                </a>
                <a class="navbar-brand text-white text-center flex-fill border-end" href="#">
                    <div><i class="fas fa-file-alt"></i></div>
                    <small>Requests</small>
                </a>
                <a class="navbar-brand text-white text-center flex-fill" href="#">
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
        let table = $('#paymentTable').DataTable({
            responsive: {
                details: {
                    type: 'inline',
                    target: 'tr'
                }
            },
            orderCellsTop: true,
            fixedHeader: true,
            dom: 'lrtip',
            columnDefs: [
                { responsivePriority: 1, targets: 2 },
                { responsivePriority: 2, targets: 5 },

                { responsivePriority: 10001, targets: 0 }, 
                { responsivePriority: 10002, targets: 1 }, 
                { responsivePriority: 10003, targets: 3 }, 
                { responsivePriority: 10004, targets: 4 }, 
            ]
        });

        $('#paymentTable thead tr:eq(1) th').each(function (i) {
            $('input', this).on('keyup change', function () {
                if (table.column(i).search() !== this.value) {
                    table.column(i).search(this.value).draw();
                }
            });
        });

        table.on('responsive-resize', function (e, datatable, columns) {
            $('#paymentTable thead tr:eq(1) th').each(function (i) {
                $(this).toggle(columns[i]);
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