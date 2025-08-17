<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hubert Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
                        <i class="fas fa-sign-out-alt fs-5"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Card -->
    <div class="container my-4">
        <div class="row g-4">
            <h1>Welcome Admin!</h1>
            <!-- Cash Payment -->
            <div class="col-md-4">
                <div class="card text-white bg-success h-100">
                    <div class="card-body">
                        <h5 class="card-title">Cash Payment</h5>
                        <h2 class="card-text">₱{{ number_format($totalCash ?? 0, 2) }}</h2>
                    </div>
                </div>
            </div>
            
            <!-- Online Payment -->
            <div class="col-md-4">
                <div class="card text-white bg-success h-100">
                    <div class="card-body">
                        <h5 class="card-title">Online Payment</h5>
                        <h2 class="card-text">₱{{ number_format($totalOnline ?? 0, 2) }}</h2>
                    </div>
                </div>
            </div>
            
                            <!-- Cash on Hand -->
                            <div class="col-md-4">
                                <div class="card text-white bg-success h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">Cash on Hand</h5>
            
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h2 class="card-text mb-0">₱{{ number_format($totalCashOnHand ?? 0, 2) }}</h2>
                                            @if(($totalCashOnHand ?? 0) > 0)
                                                <button class="btn btn-light btn-sm" id="turnOverBtn">TURN OVER</button>
                                            @endif
                                        </div>
            
                                    </div>
                                </div>
                            </div>
                    </div>

        <h5 class="mt-5 mb-3">Actions</h5>
        <div class="row quick-actions g-3">
            <!-- Dashboard -->
            <div class="col-6 col-md-3">
                <a href="{{ route('admin.huberts.dashboard.page') }}" style="text-decoration: none !important">
                    <div class="card text-center p-4">
                        <i class="fas fa-chart-line fa-2x mb-2"></i>
                        <div>Dashboard</div>
                    </div>
                </a>
            </div>
        
            <!-- Expenses -->
            <div class="col-6 col-md-3">
                <a href="{{ route('admin.huberts.expenses.page') }}" style="text-decoration: none !important">
                    <div class="card text-center p-4">
                        <i class="fas fa-receipt fa-2x mb-2"></i>
                        <div>Expenses</div>
                    </div>
                </a>
            </div>
        
            <!-- Units -->
            <div class="col-6 col-md-3">
                <a href="{{ route('admin.huberts.units.management.page') }}" style="text-decoration: none !important">
                    <div class="card text-center p-4">
                        <i class="fas fa-building fa-2x mb-2"></i>
                        <div>Units</div>
                    </div>
                </a>
            </div>
        
            <!-- Payment Proof -->
            <div class="col-6 col-md-3">
                <a href="{{ route('admin.hubert.paymemt.proof.page') }}" style="text-decoration: none !important">
                    <div class="card text-center p-4">
                        <i class="fas fa-money-check-alt fa-2x mb-2"></i>
                        <div>Payment Proof</div>
                    </div>
                </a>
            </div>
        
            <!-- Requests -->
            <div class="col-6 col-md-3">
                <a href="{{ route('admin.hubert.request.page') }}" style="text-decoration: none !important">
                    <div class="card text-center p-4">
                        <i class="fas fa-inbox fa-2x mb-2"></i>
                        <div>Requests</div>
                    </div>
                </a>
            </div>
        
            <!-- Request to Manager -->
            <div class="col-6 col-md-3">
                <a href="{{ route('admin.hubert.request_to_manager.page') }}" style="text-decoration: none !important">
                    <div class="card text-center p-4">
                        <i class="fas fa-user-tie fa-2x mb-2"></i>
                        <div>Request to Manager</div>
                    </div>
                </a>
            </div>
        


                        <!-- Announcements -->
                        <div class="col-6 col-md-3" >
                            <a href="{{ route('admin.hubert.announcement.page') }}" style="text-decoration: none !important">
                                <div class="card text-center p-4">
                                    <i class="fas fa-bullhorn fa-2x mb-2"></i>
                                    <div>Announcements</div>
                                </div>
                            </a>
                        </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $('#turnOverBtn').click(function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Enter Turn Over Amount',
                input: 'number',
                inputAttributes: {
                    min: 1,
                    step: 0.01
                },
                inputPlaceholder: 'Enter amount in PHP',
                showCancelButton: true,
                confirmButtonText: 'Submit',
                cancelButtonText: 'Cancel',
                inputValidator: (value) => {
                    if (!value || parseFloat(value) <= 0) {
                        return 'Please enter a valid amount';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    let amount = result.value;

                    $.ajax({
                        url: "{{ route('admin.huberts.turnover.request') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            turn_over_money: amount
                        },
                        success: function (response) {
                            toastr.success(response.message);
                            setTimeout(() => location.reload(), 1500);
                        },
                        error: function (xhr) {
                            toastr.error(xhr.responseJSON?.message || 'Something went wrong.');
                        }
                    });
                }
            });
        });

        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif
    </script>
</body>
</html>
