<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>JJS1 Host Dashboard</title>
    <!-- CSS Dependencies -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" />

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
            z-index: 1050;
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
    <h2>Requests</h2>

    <table id="requestsTable" class="table table-bordered table-striped nowrap" style="width:100%">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Status</th>
                <th>Approval</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($request_to_managers as $request)
            <tr>
                <td>{{ $request->admin_name }}</td>
                <td>{{ $request->request_subject }}</td>
                <td>{{ $request->request_message }}</td>
                <td>
                    @if ($request->is_approved)
                        <span class="badge bg-success">Approved</span>
                    @else
                        <span class="badge bg-warning text-dark">Pending</span>
                    @endif
                </td>
            <td>
                @if (!$request->is_approved)
                    <form action="{{ route('host.jjs1.request_to_manager.approve', $request->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-success">Approve</button>
                    </form>
                    <form action="{{ route('host.jjs1.request_to_manager.decline', $request->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Decline</button>
                    </form>
                @else
                    <form action="{{ route('host.jjs1.request_to_manager.delete', $request->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this request?')">
                            Delete
                        </button>
                    </form>
                @endif
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
        $('#requestsTable').DataTable({
            responsive: true,
            autoWidth: false,
            pageLength: 10,
            language: {
                emptyTable: "No requests found."
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
