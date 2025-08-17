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

    <div class="container my-4 pb-5">
        <div class="card border-0 text-white mb-4" 
        style="background-image: url('{{ asset('assets/huberts/hubert-banner.png') }}'); 
            background-repeat: no-repeat; 
            background-position: center; 
            background-size: cover; 
            width: 100%; 
            height: auto; 
            min-height: 300px;">
            <div class="card-body p-4" style="color: black !important">
                <h5 class="card-title mb-3">My Outstanding Balance</h5>
                <div class="display-4 fw-bold mb-3">
                    @if (!$billing)
                        PHP 0.00
                    @else
                        PHP {{ number_format($billing->total_balance_to_pay, 2) }}
                    @endif
                </div>
                <div class="mb-3">
                    <small class="opacity-75" style="font-weight: 700">Account Number</small>
                    <div class="fw-bold">
                        @if ($billing)
                            {{ $billing->account_number }}
                        @else
                            Not Available
                        @endif
                    </div>
                </div>
                <div class="mb-3">
                    <small class="opacity-75" style="font-weight: 700">Advance & Deposit Payment</small>
                    <div class="fw-bold">
                        PHP {{ number_format($tenant->advance_deposit ?? 0, 2) }}
                    </div>
                </div>
                <div class="row align-items-end">
                    <div class="col-12 col-md-12 text-end mt-3 mt-md-0">
                        <button id="payNowBtn" class="btn btn-warning btn-sm px-3 fw-bold me-2">PAY NOW</button>
                        <button class="btn btn-warning btn-sm px-3 fw-bold me-2" data-bs-toggle="modal" data-bs-target="#proofOfPaymentModal">
                            SEND PROOF OF PAYMENT
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- SEND PROOF MODAL --}}
        <div class="modal fade" id="proofOfPaymentModal" tabindex="-1" aria-labelledby="proofOfPaymentLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white" style="background-color: black !important">
                        <h5 class="modal-title" id="proofOfPaymentLabel">Send Proof of Payment</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('tenant.huberts.payment.proof.request') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="fullname" value="{{ $tenant->fullname }}">
                            <input type="hidden" name="unit" value="{{ $unit->units_name }}">
                            <input type="hidden" name="email" value="{{ $tenant->email }}">
                            <input type="hidden" name="phone_number" value="{{ $tenant->phone_number }}">

                            <div class="mb-4 p-3 border rounded bg-light">
                                <h6 class="mb-3 fw-bold text-dark">Details:</h6>
                                <p class="mb-1"><strong>Full Name:</strong> {{ $tenant->fullname }}</p>
                                <p class="mb-1"><strong>Unit:</strong> {{ $unit->units_name }}</p>
                                <p class="mb-1"><strong>Email:</strong> {{ $tenant->email }}</p>
                                <p class="mb-0"><strong>Phone Number:</strong> {{ $tenant->phone_number }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Upload Proof (Screenshot or Receipt)</label>
                                <input type="file" name="payment_proof" id="paymentProofInput" class="form-control" accept="image/*,.pdf" required>
                            </div>

                            <div class="mt-3" id="imagePreviewContainer" style="display: none;">
                                <img id="imagePreview" src="" alt="Preview" class="img-fluid border rounded" style="max-height: 300px;">
                            </div>


                            <div class="text-end">
                                <button type="submit" class="btn btn-success">Submit</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Quick Actions -->
        <h5 class="mb-3 text-dark">My Quick Actions</h5>
        <div class="row g-3 mb-5">
            <div class="col-6 col-md-3" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#myProfileModal">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="bg-success text-white rounded p-3 mb-3 d-inline-block" style="background-color: black !important">
                            <i class="fas fa-user fs-4"></i>
                        </div>
                        <div class="fw-bold small">My<br>Profile</div>
                    </div>
                </div>
            </div>

            <!-- My Profile Modal -->
            <div class="modal fade" id="myProfileModal" tabindex="-1" aria-labelledby="myProfileModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="myProfileModalLabel">My Profile</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <!-- Top Section -->
                    <div class="mb-4">
                        <h3 class="fw-bold">{{ $property->property_name ?? 'Property' }}</h3>
                        <p class="mb-1"><strong>Unit:</strong> {{ $unit->units_name ?? 'N/A' }}</p>
                        <p class="mb-0">
                            <strong>Move In:</strong> {{ $tenant->move_in_date }} | 
                            <strong>Move Out:</strong> {{ $tenant->move_out_date ?? 'N/A' }}
                        </p>
                    </div>


                    <!-- Details & Emergency Contact -->
                    <div class="row"> 
                    <!-- Details -->
                    <div class="col-md-6">
                        <h5 class="fw-bold mb-3">My Details</h5>
                        <p><strong>Full Name:</strong> {{ $tenant->fullname }}</p>
                        <p><strong>Username:</strong> {{ $tenant->username }}</p>
                        <p><strong>Email:</strong> {{ $tenant->email }}</p>
                        <p><strong>Phone:</strong> {{ $tenant->phone_number }}</p>
                        <p><strong>Address:</strong> {{ $tenant->address }}</p>
                    </div>

                    <!-- Emergency Contact -->
                    <div class="col-md-6">
                        <h5 class="fw-bold mb-3">My Emergency Contact</h5>
                        <p><strong>Full Name:</strong> {{ $tenant->contact_fullname }}</p>
                        <p><strong>Phone Number:</strong> {{ $tenant->contact_phone_number }}</p>
                    </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>

                </div>
            </div>
            </div>



            <div class="col-6 col-md-3" 
                style="cursor: pointer" 
                onclick="window.location.href='{{ route('tenants.huberts.my-billing.page') }}'">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="bg-success text-white rounded p-3 mb-3 d-inline-block" style="background-color: black !important">
                            <i class="fas fa-search fs-4"></i>
                        </div>
                        <div class="fw-bold small">View<br>Billing</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3" style="cursor: pointer" onclick="window.location.href='{{ route('tenants.huberts.my-payment.page') }}'">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="bg-success text-white rounded p-3 mb-3 d-inline-block" style="background-color: black !important">
                            <i class="fas fa-chart-bar fs-4"></i>
                        </div>
                        <div class="fw-bold small">Account<br>History</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#helpSupportModal">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="bg-success text-white rounded p-3 mb-3 d-inline-block" style="background-color: black !important">
                            <i class="fas fa-folder fs-4"></i>
                        </div>
                        <div class="fw-bold small">Help &<br>Support</div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="helpSupportModal" tabindex="-1" aria-labelledby="helpSupportLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header bg-success text-white" style="background-color: black !important">
                        <h5 class="modal-title" id="helpSupportLabel">Help & Support</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Property Name:</strong> {{ $property->property_name ?? 'Not Available' }}</p>
                        <p><strong>Email:</strong> <a style="text-decoration: none" href="mailto:{{ $property->property_email }}">{{ $property->property_email ?? 'Not Available' }}</a></p>
                        <p><strong>Phone:</strong> <a style="text-decoration: none" href="tel:{{ $property->property_phone_number }}">{{ $property->property_phone_number ?? 'Not Available' }}</a></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Navigation -->
    <nav class="navbar fixed-bottom navbar-light bg-white border-top" style="background-color: black !important">
        <div class="container-fluid">
            <div class="d-flex w-100 justify-content-around">
                <a class="navbar-brand text-success text-center flex-fill border-end" href="{{ route('tenants.huberts.dashboard.page') }}">
                    <div><i class="fas fa-home"></i></div>
                    <small>Home</small>
                </a>
                <a class="navbar-brand text-white text-center flex-fill border-end" href="{{ route('tenants.huberts.my-request.page') }}">
                    <div><i class="fas fa-file-alt"></i></div>
                    <small>Requests</small>
                </a>
                <a class="navbar-brand text-white text-center flex-fill" href="{{ route('tenants.huberts.announcement.page') }}">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.getElementById('payNowBtn').addEventListener('click', function () {
        showPaymentOptions();
    });

    function showPaymentOptions() {
        Swal.fire({
            title: 'Choose Payment Method',
            icon: 'question',
            showCancelButton: true,
            showConfirmButton: false,
            cancelButtonText: 'Cancel',
            html: `
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" onclick="selectPayment('Gcash')">Gcash</button>
                    <button class="btn btn-info text-white" onclick="selectPayment('Paymaya')">Paymaya</button>
                    <button class="btn btn-success" onclick="selectPayment('BDO')">BDO</button>
                </div>
            `
        });
    }

    function selectPayment(method) {
        let qrImage = '';

        if (method === 'Gcash') {
            qrImage = "{{ asset('assets/huberts/gcash.jpg') }}";
        } else if (method === 'Paymaya') {
            qrImage = "{{ asset('assets/huberts/paymaya.png') }}";
        } else if (method === 'BDO') {
            qrImage = "{{ asset('assets/huberts/bdo.jpg') }}";
        }

        Swal.fire({
            title: method + ' - Scan to Pay',
            html: `
                <p><strong>📌 Please scan the QR code to make your payment.</strong></p>
                <img src="${qrImage}" alt="${method} QR Code" style="width:300px; height:370px; margin-bottom: 15px;">
                <p style="margin-top:10px; font-size:14px; color: red;">
                    Make sure to take a screenshot of your proof of payment and send it to send payment proof after the transaction.
                </p>
            `,
            showCancelButton: true,
            confirmButtonText: 'OK',
            cancelButtonText: 'Back',
        }).then((result) => {
            if (result.dismiss === Swal.DismissReason.cancel) {
                showPaymentOptions();
            }
        });
    }
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

    <script>
    document.getElementById('paymentProofInput').addEventListener('change', function (e) {
        const file = e.target.files[0];
        const preview = document.getElementById('imagePreview');
        const container = document.getElementById('imagePreviewContainer');

        if (file) {
            const fileType = file.type;

            // Show image preview only for image files
            if (fileType.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    container.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                container.style.display = 'none';
            }
        } else {
            preview.src = '';
            container.style.display = 'none';
        }
    });
</script>

</body>
</html>