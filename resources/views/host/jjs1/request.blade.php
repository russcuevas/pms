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
        <h2 class="mb-4">Requests</h2>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($requests->isEmpty())
        <div class="alert alert-info">No requests found.</div>
        @else
        <table id="requestsTable" class="table table-bordered table-striped nowrap" style="width:100%">
            <thead class="table-dark">
                <tr>
                    <th>Tenant</th>
                    <th>Unit</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Approval</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requests as $request)
                <tr>
                    <td>{{ $request->tenant_name }}</td>
                    <td>{{ $request->unit_name }}</td>
                    <td>{{ $request->subject_request }}</td>
                    <td>{{ $request->subject_message }}</td>
                    <td>
                        @if ($request->status === 'Waiting to address by the host')
                        <form method="POST" action="{{ route('host.jjs1.request.address', $request->id) }}" style="display:inline-block;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-success mb-1" name="action" value="addressed">
                                <i class="fas fa-check-circle"></i> Already Addressed
                            </button>
                        </form>

                        <form method="POST" action="{{ route('host.jjs1.request.delete', $request->id) }}" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger mb-1" name="action" value="not_addressed" onclick="return confirm('Are you sure you want to delete this request?');">
                                <i class="fas fa-times-circle"></i> Not Addressed
                            </button>
                        </form>
                        @else
                        <span class="badge bg-success">Already addressed</span>
                        @endif
                    </td>
                    <td>
                        @if($request->is_approved == 1 && $request->status === 'Already addressed')
                        <span class="badge bg-success">Already Addressed</span>
                        @elseif ($request->is_approved == 1)
                        <span class="badge bg-primary text-white">Approved by the admin</span>
                        @else
                        <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    <!-- Bottom Navigation -->
                <div class="bottom-nav" style="background-color: #44444E !important">
                    <a href="{{ route('host.jjs1.dashboard.page') }}" style="text-decoration: none">
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
            $('#requestsTable').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                language: {
                    emptyTable: "No requests available.",
                },
                columnDefs: [
                    { responsivePriority: 1, targets: -2 },  // Status
                    { responsivePriority: 2, targets: -1 }   // Approval
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

        @if (session('error'))
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 3000
        };
        toastr.error("{{ session('error') }}");
        @endif
    </script>
</body>

</html>
