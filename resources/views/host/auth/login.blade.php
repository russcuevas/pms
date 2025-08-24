<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Host Login</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

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
        }

        .text-center a:hover {
            text-decoration: underline;
        }

        #loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 9999;
            color: white;
            font-size: 1.5rem;
            text-align: center;

            align-items: center;
            justify-content: center;
        }

        #loading-overlay.show {
            display: flex;
        }
    </style>
</head>

<body>
    <div id="loading-overlay">
        <div>
            <div class="spinner-border text-light" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div style="margin-top: 1rem;">Processing your request...</div>
        </div>
    </div>

    <div class="login-container">
        <h2 class="text-center mb-4" style="font-weight: 700">
            AVA Host Login
        </h2>

        <form action="{{ route('host.login.request') }}" method="POST" class="novalidate" novalidate>
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" id="username" value="{{ old('username') }}" required />
                <div class="invalid-feedback">Please enter your username.</div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" required />
                <div class="invalid-feedback">Please enter your password.</div>
            </div>

            <div class="d-grid mb-2">
                <button type="submit" id="loginSubmitBtn" class="btn btn-primary" style="background-color: #68d391; font-weight: 700;">
                    Login
                </button>
                <button type="button" id="loginLoadingBtn" class="btn btn-success" style="display: none;" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Logging in...
                </button>
            </div>

            <div class="text-center">
                {{-- Optional: add any links if needed here --}}
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
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: "3000",
        };
    </script>

    <script>
        (() => {
            "use strict";
            const forms = document.querySelectorAll("form.novalidate");
            Array.from(forms).forEach((form) => {
                form.addEventListener(
                    "submit",
                    (event) => {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        } else {
                            // Show loading
                            document.getElementById("loginSubmitBtn").style.display = "none";
                            document.getElementById("loginLoadingBtn").style.display = "inline-block";
                        }
                        form.classList.add("was-validated");
                    },
                    false
                );
            });
        })();
    </script>
</body>

</html>
