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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">My Request</h2>
            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#requestModal">
                <i class="fas fa-plus me-1"></i> MAKE A REQUEST
            </button>
        </div>

        <div class="table-responsive">

<table id="requestTable" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Subject</th>
            <th>Message</th>
            <th>Status</th>
            <th>Approval</th>
        </tr>
        <tr>
            <th><input type="text" placeholder="Search Subject" class="form-control form-control-sm" /></th>
            <th><input type="text" placeholder="Search Message" class="form-control form-control-sm" /></th>
            <th><input type="text" placeholder="Search Status" class="form-control form-control-sm" /></th>
            <th><input type="text" placeholder="Search Approval" class="form-control form-control-sm" /></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($requests as $request)
            <tr>
                <td>{{ $request->subject_request }}</td>
                <td>{{ $request->subject_message }}</td>
                <td>
                    @if($request->status === 'Pending')
                        <span class="badge bg-warning text-dark">{{ $request->status }}</span>
                    @elseif($request->status === 'Already addressed')
                        <span class="badge bg-success">{{ $request->status }}</span>
                    @else
                        <span class="badge bg-secondary">{{ $request->status }}</span>
                    @endif
                </td>
                <td>
                    @if($request->is_approved === 0)
                        <span class="badge bg-warning text-dark">Wait for the approval of the admin</span>
                    @else
                        <span class="badge bg-success text-dark">Approved by the admin</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

        </div>
    </div>

    {{-- REQUEST MODAL --}}
    <div class="modal fade" id="requestModal" tabindex="-1" aria-labelledby="requestModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="needs-validation" novalidate action="{{ route('tenants.huberts.my-request.post') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header text-white" style="background-color: black;">
                        <h5 class="modal-title" id="requestModalLabel">Send a Request</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary">Submit Request</button>
                    </div>
                </div>
            </form>
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
                <a class="navbar-brand text-success text-center flex-fill border-end" href="{{ route('tenants.huberts.my-request.page') }}">
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
    {{-- SWEETALERT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- DATA TABLE --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <script>
        (function () {
            'use strict'

            const forms = document.querySelectorAll('.needs-validation')

            Array.from(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>

<script>
    $(document).ready(function () {
        var table = $('#requestTable').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            dom: 'lrtip'  // 🔍 Removes global search but keeps rest (length, info, pagination)
        });

        // Setup column search inputs
        $('#requestTable thead tr:eq(1) th').each(function (i) {
            var input = $('input', this);
            input.on('keyup change', function () {
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