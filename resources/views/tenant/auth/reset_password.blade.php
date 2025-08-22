<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>

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

        .login-container {
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
            border-color: #007bff;
        }

        .text-center a {
            text-decoration: none;
            color: #68d391;
        }

        .text-center a:hover {
            text-decoration: underline;
        }

        button.btn-success {
            background-color: #68d391;
            font-weight: 700;
            border: none;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2 class="text-center mb-4" style="font-weight: 700">Reset Password</h2>

    <form action="{{ route('tenants.reset.password') }}" method="POST" novalidate>
        @csrf
        <input type="hidden" name="forgot_code" value="{{ $forgot_code }}">

        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <input type="password" class="form-control" name="password" id="password" required>
            <div class="invalid-feedback">Please enter your new password.</div>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
            <div class="invalid-feedback">Please confirm your new password.</div>
        </div>

        <div class="d-grid mb-2">
            <button type="submit" class="btn btn-success">Reset Password</button>
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

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    @endif

    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "3000"
    };

    // Bootstrap validation
    (() => {
        'use strict';
        const form = document.querySelector('form');
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    })();
</script>


</body>
</html>
