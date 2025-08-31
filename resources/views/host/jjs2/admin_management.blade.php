<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JJS2 Host Dashboard</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <style>
        body {
            background-color: #e9ecef;
        }

        .top-bar {
            background: #000;
            color: white;
            padding: 15px 30px;
            font-weight: bold;
        }

        .hero-card {
            background-image: url('{{ asset('assets/images/building.jpg') }}');
            background-size: cover;
            background-position: center;
            color: #000;
            border-radius: 10px;
            padding: 30px;
            position: relative;
            height: 250px;
        }

        .hero-overlay {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            height: 100%;
        }

        .action-buttons .btn {
            margin-right: 10px;
            font-weight: bold;
        }

        .quick-actions .card {
            border: none;
            border-radius: 12px;
            transition: all 0.3s;
        }

        .quick-actions .card:hover {
            background-color: #f1f1f1;
            transform: translateY(-5px);
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
        }

        .bottom-nav a.active {
            color: #28a745;
        }
    </style>
</head>
<body>

    <!-- TOP NAV BAR -->
    <div class="text-white py-3" style="background-color: #715A5A">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6">
                    <div>
                        <small class="text-uppercase text-white">JJS2 HOST PANEL</small>
                        <div class="fw-bold">Host/Owner</div>
                    </div>
                </div>
                <div class="col-6 text-end">
                    <a href="{{ route('host.jjs2.change-password.form') }}" class="text-white text-decoration-none me-3">
                        <i class="fas fa-user-circle fs-5"></i> Profile
                    </a>
                    <a href="{{ route('host.logout.request') }}" class="text-white text-decoration-none">
                        <i class="fas fa-sign-out-alt fs-5"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>


    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Admin Management</h1>
        </div>

            <table id="adminTable" class="table table-bordered table-striped nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($admins as $admin)
                        <tr>
                            <td>{{ $admin->username }}</td>
                            <td>{{ $admin->fullname }}</td>
                            <td>{{ $admin->phone_number }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->address }}</td>
                            <td>
                                @if ($admin->is_approved == 0)
                                    <form action="{{ route('host.jjs2.update.admin.approval', $admin->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" name="action" class="btn btn-success" value="approve">Approve</button>
                                        <button type="submit" name="action" class="btn btn-danger" value="decline">Decline</button>
                                    </form>
                                @else
                                    <span class="badge bg-success">Approved</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No admins found for JJS2 Bldg.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
    </div>


    

                    <!-- Bottom Navigation -->
                <div class="bottom-nav" style="background-color: #715A5A !important">
                    <a href="{{ route('host.jjs2.dashboard.page') }}" style="text-decoration: none">
                        <i class="fas fa-home"></i><br>Back to dashboard
                    </a>
                </div>

    <!-- jQuery and Toastr JS CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#adminTable').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                language: {
                    emptyTable: "No admins found for jjs2 Bldg.",
                }
            });
        });
    </script>

    <!-- Toastr Success Message -->
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
