<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hubert Dashboard</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- ✅ Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body>
    Hubert Dashboard
    @include('admin.hubert.left_sidebar')

    <div class="container my-5">
        <div class="row g-4">

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
    </div>


    <!-- ✅ jQuery (Required) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- ✅ Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                            if (xhr.responseJSON?.message) {
                                toastr.error(xhr.responseJSON.message);
                            } else {
                                toastr.error('Something went wrong.');
                            }
                        }
                    });
                }
            });
        });
    </script>


    <!-- ✅ Show toast if session has success -->
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
    </script>
</body>
</html>
