<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>JJS1 Host Dashboard</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
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
            z-index: 1000;
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

        .btn-inline {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border: none;
            background: none;
            cursor: pointer;
            font-weight: 600;
            text-decoration: underline;
            margin-right: 8px;
            font-size: 0.875rem;
            border-radius: 4px;
        }

        .btn-inline.approve {
            color: #28a745;
        }

        .btn-inline.decline {
            color: #dc3545;
        }

        .status-received {
            color: #28a745;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <!-- TOP NAV BAR -->
    <div class="bg-dark text-white py-3 mb-4">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <small class="text-uppercase">JJS1 BLDG HOST PANEL</small>
                <div class="fw-bold">Host/Owner</div>
            </div>
            <div>
                <a href="{{ route('host.logout.request') }}" class="text-white text-decoration-none">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="container mb-5">
        <h2 class="mb-4">Turnover Records</h2>

            <table id="turnoversTable" class="table table-bordered table-striped nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Admin Fullname</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date Requested</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($turnOvers as $index => $turnOver)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $turnOver->admin_fullname }}</td>
                            <td>PHP {{ number_format($turnOver->turn_over_money, 2) }}</td>
                            <td>
                                @if ($turnOver->is_approved)
                                    <span class="badge bg-success">Received</span>
                                @else
                                    <form action="{{ route('host.jjs1.turnovers.approve', $turnOver->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success approve">Received</button>
                                    </form>

                                    <form action="{{ route('host.jjs1.turnovers.decline', $turnOver->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to decline this turnover?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger decline">Decline</button>
                                    </form>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($turnOver->created_at)->format('M d, Y h:i A') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </div>

    <!-- Bottom Navigation -->
    <div class="bottom-nav">
        <a href="{{ route('host.jjs1.dashboard.page') }}">
            <i class="fas fa-home"></i><br>Back to dashboard
        </a>
    </div>

    <!-- JS Dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#turnoversTable').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                language: {
                    emptyTable: "No turnover records found."
                },
                columnDefs: [
                    { responsivePriority: 1, targets: 0 }, // index column
                    { responsivePriority: 2, targets: 3 } // status column
                ]
            });
        });
    </script>

    <script>
        @if (session('success'))
            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: "toast-top-right",
                timeOut: 3000
            };
            toastr.success("{{ session('success') }}");
        @endif
    </script>

</body>
</html>
