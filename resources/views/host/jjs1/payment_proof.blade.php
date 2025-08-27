<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>JJS1 Host Dashboard</title>

    <!-- CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
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
        <h2 class="mb-4">Payment Proofs</h2>

        @if($paymentProofs->isEmpty())
            <div class="alert alert-info">No payment proofs found.</div>
        @else
            <table id="paymentProofsTable" class="table table-bordered table-striped nowrap" style="width:100%">
                <thead class="table-dark">
                    <tr>
                        <th>Records</th> <!-- Responsive control column -->
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Unit</th>
                        <th>Proof</th>
                        <th>Uploaded At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paymentProofs as $proof)
                        <tr>
                            <td>Payments</td> <!-- Control column cell for responsive -->
                            <td>{{ $proof->fullname }}</td>
                            <td>{{ $proof->email }}</td>
                            <td>{{ $proof->phone_number }}</td>
                            <td>{{ $proof->unit }}</td>
                            <td>
                                @if($proof->payment_proof)
                                    <button class="btn btn-sm btn-primary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#proofModal{{ $proof->id }}">
                                        View Proof
                                    </button>

                                    <div class="modal fade" id="proofModal{{ $proof->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Payment Proof - {{ $proof->fullname }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    @php 
                                                        $filePath = asset('assets/jjs1/proof_of_payment/'.$proof->payment_proof); 
                                                    @endphp

                                                    @if(Str::endsWith($proof->payment_proof, ['.jpg','.jpeg','.png','.gif','.webp']))
                                                        <img src="{{ $filePath }}" class="img-fluid rounded" alt="Payment Proof" />
                                                    @elseif(Str::endsWith($proof->payment_proof, ['.pdf']))
                                                        <embed src="{{ $filePath }}" type="application/pdf" width="100%" height="600px" />
                                                    @else
                                                        <a href="{{ $filePath }}" target="_blank" class="btn btn-success">Download File</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">No file</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($proof->created_at)->format('M d, Y h:i A') }}</td>
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

    <!-- SCRIPTS -->
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
    $('#paymentProofsTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        language: {
            emptyTable: "No proof records"
        },
        columnDefs: [
            { responsivePriority: 1, targets: 5 }, // Proof column - highest priority
            { responsivePriority: 2, targets: 1 }, // Full Name next important
            { responsivePriority: 3, targets: -1 } // Uploaded At
        ]
    });
});

    </script>
    <!-- Toastr notifications -->
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
