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
    {{-- DATATABLE --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
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
    <div class="row g-4">
        @if($announcements->isEmpty())
            <div class="col-12">
                <div class="alert alert-info text-center mb-0">
                    <h1>No announcement posted</h1>
                </div>
            </div>
        @else
            @foreach($announcements as $announcement)
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <img src="https://t3.ftcdn.net/jpg/03/30/15/02/360_F_330150256_7hOerJ1QMSsh8vglCQJ7ZWwlhVPPh4Je.jpg" 
                            class="card-img-top" 
                            alt="Announcement Image">
                        <div class="card-body">
                            <h5 class="card-title">{{ $announcement->announcement_subject }}</h5>
                            <p class="card-text">{{ $announcement->announcement_message }}</p>
                        </div>
                        <div class="card-footer text-muted">
                            <small>
                                Posted by {{ $announcement->admin_name }}<br>
                                Posted At: {{ \Carbon\Carbon::parse($announcement->updated_at)->format('M d, Y h:i A') }}
                            </small>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
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
                <a class="navbar-brand text-white text-center flex-fill border-end" href="{{ route('tenants.huberts.my-request.page') }}">
                    <div><i class="fas fa-file-alt"></i></div>
                    <small>Requests</small>
                </a>
                <a class="navbar-brand text-success text-center flex-fill" href="{{ route('tenants.huberts.announcement.page') }}">
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
    {{-- SWEETALERT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- DATA TABLE --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

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