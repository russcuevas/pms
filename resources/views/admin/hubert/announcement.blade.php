<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hubert Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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
    <div class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Announcement</h1>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAnnouncementModal">
                Add Announcement
            </button>
        </div>

        <!-- Table -->
        <table id="announcementsTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($announcements as $announcement)
                    <tr>
                        <td>{{ $announcement->announcement_subject }}</td>
                        <td>{{ $announcement->announcement_message }}</td>
                        <td>
                            @if ($announcement->is_approved == 0)
                                <span class="badge bg-warning">Pending</span>
                            @else
                                <span class="badge bg-success">Approved</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addAnnouncementModal" tabindex="-1" aria-labelledby="addAnnouncementLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.hubert.announcement.request') }}" class="needs-validation" novalidate>
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAnnouncementLabel">Add Announcement</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Announcement Subject</label>
                            <input type="text" class="form-control" name="announcement_subject" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Announcement Message</label>
                            <textarea class="form-control" name="announcement_message" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Announcement</button>
                    </div>
                </form>
            </div>
        </div>
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
            <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

            
            <script>
                $(document).ready(function () {
                    $('#announcementsTable').DataTable({
                        responsive: true,
                        pageLength: 10,
                    });
                });
            </script>
            <script>
                (() => {
                    'use strict'
                    const forms = document.querySelectorAll('.needs-validation')
                    Array.from(forms).forEach(form => {
                        form.addEventListener('submit', event => {
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
                @if (session('success'))
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "timeOut": "3000",
                        "positionClass": "toast-top-right"
                    };
                    toastr.success("{{ session('success') }}");
                @endif
        
                @if (session('error'))
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "timeOut": "3000",
                        "positionClass": "toast-top-right"
                    };
                    toastr.error("{{ session('error') }}");
                @endif
            </script>
        
</body>
</html>
