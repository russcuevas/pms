<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JJS1 Host Dashboard</title>

    <!-- CSS Links -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
                    <a href="{{ route('host.jjs1.change-password.form') }}" class="text-white text-decoration-none me-3">
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
        <h2 class="mb-4">Announcement Management</h2>

        <table id="announcementTable" class="table table-bordered table-striped nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($announcements as $announcement)
                    <tr>
                        <td>{{ $announcement->admin_name }}</td>
                        <td>{{ $announcement->announcement_subject }}</td>
                        <td>{{ $announcement->announcement_message }}</td>
                        <td> 
                            @if ($announcement->is_approved == 0)
                                <span class="badge bg-warning">Pending</span>
                            @else
                                <span class="badge bg-success">Approved</span>
                            @endif
                        </td>
                        <td>
                            @if ($announcement->is_approved == 0)
                                <form action="{{ route('host.jjs1.announcements.approve', $announcement->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button class="btn btn-success btn-sm">Approve</button>
                                </form>
                                <form action="{{ route('host.jjs1.announcements.decline', $announcement->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button class="btn btn-danger btn-sm">Decline</button>
                                </form>
                            @else
                                <form action="{{ route('host.jjs1.announcements.delete', $announcement->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this announcement?')">
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

    <!-- JS Links -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- DataTable Init -->
    <script>
        $(document).ready(function () {
            $('#announcementTable').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                language: {
                    emptyTable: "No announcements available.",
                }
            });
        });
    </script>

    <!-- Toastr -->
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
