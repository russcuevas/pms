<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OTP Verification</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <style>
        body {
            background-image: url('{{ asset('assets/auth/login-bg.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-color: #e9ecef;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #68d391;
        }

        .otp-container {
            background: black;
            padding: 2rem 2.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 420px;
        }

        .form-label {
            font-weight: 500;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #68d391;
        }

        .btn-primary {
            background-color: #68d391;
            font-weight: 700;
            border: none;
        }

        .btn-primary:hover {
            background-color: #57b87f;
        }
    </style>
</head>
<body>

<div class="otp-container">
    <h2 class="text-center mb-4" style="font-weight: 700;">OTP Verification</h2>

    <form action="{{ route('tenants.verify.otp') }}" method="POST" class="needs-validation" novalidate>
        @csrf
        <div class="mb-3">
            <label for="otp_code" class="form-label">Enter OTP:</label>
            <input type="number" class="form-control" id="otp_code" name="otp_code" required>
            <div class="invalid-feedback">
                Please enter the OTP code.
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">Verify OTP</button>
        <div class="col-12 text-center">
            <a style="color: #68d391; text-decoration: none;" href="{{ route('tenants.login.page') }}">Go back</a>
        </div>
    </form>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    @if (session('error'))
        toastr.error("{{ session('error') }}");
    @endif

    @if (session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "3000"
    };

    // Bootstrap validation
    (() => {
        'use strict'
        const form = document.querySelector('.needs-validation')
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })()
</script>

</body>
</html>
