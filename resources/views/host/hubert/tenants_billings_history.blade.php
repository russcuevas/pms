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
    </style>
</head>
<body>

    <!-- TOP NAV BAR -->
    <div class="bg-dark text-white py-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6">
                    <div>
                        <small class="text-uppercase text-white">HUBERTS HOST PANEL</small>
                        <div class="fw-bold">Host/Owner</div>
                    </div>
                </div>
                <div class="col-6 text-end">
                    <a href="{{ route('host.huberts.change-password.form') }}" class="text-white text-decoration-none me-3">
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
        <h2 class="mb-4">Tenant Billing History</h2>

        <table id="billingTable" class="table table-bordered table-striped nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Tenant</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($historyData as $data)
                    <tr>
                        <td>{{ $data->tenant_name }}</td>
                        <td>{{ $data->tenant_phone_number }}</td>
                        <td>{{ $data->tenant_email }}</td>

                        <td>
                            <span class="badge bg-success">Moved out</span>
                        </td>
                        <td>
                            <a href="{{ route('host.hubert.view-tenant-history', ['tenant_code' => $data->tenant_code]) }}" class="btn btn-sm btn-secondary mb-1">
                                <i class="fas fa-history"></i> View History
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Bottom Navigation -->
    <div class="bottom-nav">
        <a href="{{ route('host.huberts.dashboard.page') }}">
            <i class="fas fa-home"></i><br>Back to dashboard
        </a>
    </div>

    <!-- Modals -->
    @foreach($historyData as $data)
    <div class="modal fade" id="billingModal{{ $data->id }}" tabindex="-1" aria-labelledby="billingModalLabel{{ $data->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Billing Summary - SOA No: {{ $data->soa_no }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Acct No</th>
                                <td>{{ $data->account_number }}</td>
                            </tr>
                            <tr>
                                <th>SOA No</th>
                                <td>{{ $data->soa_no }}</td>
                            </tr>
                            <tr>
                                <th>For the Month Of</th>
                                <td>{{ $data->for_the_month_of }}</td>
                            </tr>
                            <tr>
                                <th>Statement Date</th>
                                <td>{{ $data->statement_date }}</td>
                            </tr>
                            <tr>
                                <th>Due Date</th>
                                <td>{{ $data->due_date }}</td>
                            </tr>
                            <!-- Add more rows as needed -->
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
