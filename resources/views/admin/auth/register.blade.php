<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Register</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
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

        .register-container {
            background: black;
            padding: 2rem 2.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
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
        }

        .text-center a:hover {
            text-decoration: underline;
        }

        label {
            color: #ffffff;
        }
    </style>
</head>
<body>

<div class="register-container">
    <h2 class="text-center mb-4" style="font-weight: 700">AVA Admin Register</h2>

    <form action="{{ route('admin.register.request') }}" method="POST" class="novalidate" novalidate>
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Fullname</label>
                    <input type="text" class="form-control" name="fullname" required>
                    <div class="invalid-feedback">Please enter your full name.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" required>
                    <div class="invalid-feedback">Please enter a username.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                    <div class="invalid-feedback">Please enter a password.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required>
                    <div class="invalid-feedback">Please enter a valid email.</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" class="form-control" name="phone_number" required>
                    <div class="invalid-feedback">Please enter your phone number.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" class="form-control" name="address" required>
                    <div class="invalid-feedback">Please enter your address.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Property</label>
                    <select class="form-select" name="property_id" required>
                        <option value="">-- Select Property --</option>
                        @foreach ($properties as $property)
                            <option value="{{ $property->id }}" style="text-transform: capitalize">
                                {{ $property->property_name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Please select a property.</div>
                </div>
            </div>
        </div>

        <div class="d-grid mb-2">
            <button type="submit" class="btn" style="background-color: #68d391; font-weight: 700;">Register</button>
        </div>

        <div class="text-center">
            <a style="color: #68d391" href="{{ route('admin.login.page') }}">
                Click here if you already have an account
            </a>
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
</script>

<script>
    (() => {
        'use strict'
        const forms = document.querySelectorAll('.novalidate')
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

</body>
</html>
