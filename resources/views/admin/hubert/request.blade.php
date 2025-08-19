<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hubert Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
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

    <div class="container">
        <h1 class="mb-4 mt-4">Requests</h1>

        <table id="requestsTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Tenant</th>
                    <th>Unit</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>For Approval</th>
                    {{-- <th>Created At</th> --}}
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
                            @if ($request->status === 'pending')
                                <span class="badge bg-warning">{{ $request->status }}</span>
                            @else
                                <span class="badge bg-success">{{ $request->status }}</span>
                            @endif
                        </td>
                        <td>
                            @if (!$request->is_approved)
                                <form action="{{ route('admin.hubert.request.approve', $request->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-success btn-sm" onclick="return confirm('Approve this request?')">Approve</button>
                                </form>

                                <form action="{{ route('admin.hubert.request.decline', $request->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to decline this request?')">Decline</button>
                                </form>
                            @else
                                <span class="badge bg-success">Approved</span>
                            @endif
                        </td>
                        {{-- <td>{{ \Carbon\Carbon::parse($request->created_at)->format('Y-m-d H:i') }}</td> --}}
                    </tr>
                @endforeach
            </tbody>

        </table>
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
            
            <script>
                $(document).ready(function () {
                    $('#requestsTable').DataTable({
                        responsive: true,
                        pageLength: 10,
                    });
                });
            </script>
            
</body>
</html>
