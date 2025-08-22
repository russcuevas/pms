<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Tenants Login</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <!-- Toastr CSS -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
      rel="stylesheet"
    />

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
            background: rgba(0,0,0,0.6);
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
            <div
              class="spinner-border text-light"
              role="status"
              style="width: 3rem; height: 3rem;"
            >
                <span class="visually-hidden">Loading...</span>
            </div>
            <div style="margin-top: 1rem;">Processing your request...</div>
        </div>
    </div>
    <div class="login-container">
        <h2 class="text-center mb-4" style="font-weight: 700">
            AVA Tenants Login
        </h2>

        <form
          action="{{ route('tenants.login.request') }}"
          method="POST"
          class="novalidate"
          novalidate
        >
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input
                  type="text"
                  class="form-control"
                  name="username"
                  id="username"
                  required
                />
                <div class="invalid-feedback">Please enter your username.</div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input
                  type="password"
                  class="form-control"
                  name="password"
                  id="password"
                  required
                />
                <div class="invalid-feedback">Please enter your password.</div>
            </div>

            <div class="d-grid mb-2">
                <button
                  type="submit"
                  id="loginSubmitBtn"
                  class="btn btn-primary"
                  style="background-color: #68d391; font-weight: 700;"
                >
                    Login
                </button>
                <button
                  type="button"
                  id="loginLoadingBtn"
                  class="btn btn-success"
                  style="display: none;"
                  disabled
                >
                    <span
                      class="spinner-border spinner-border-sm"
                      role="status"
                      aria-hidden="true"
                    ></span>
                    Logging in...
                </button>
            </div>

            <div class="text-center">
                <a
                  style="color: #68d391; cursor:pointer;"
                  data-bs-toggle="modal"
                  data-bs-target="#forgotPasswordModal"
                  >Forgot password?</a
                >
                <br />
                <a style="color: #68d391" href="{{ route('tenants.register.page') }}"
                  >Create an account</a
                >
            </div>
        </form>
    </div>

    <!-- Forgot Password Modal -->
    <div
      class="modal fade"
      id="forgotPasswordModal"
      tabindex="-1"
      aria-labelledby="forgotPasswordLabel"
      aria-hidden="true"
    >
        <div class="modal-dialog">
            <form
              id="forgotPasswordForm"
              method="POST"
              action="{{ route('tenants.forgot.password.request') }}"
              novalidate
            >
                @csrf
                <div
                  class="modal-content"
                  style="background: black; color: #68d391;"
                >
                    <div class="modal-header">
                        <h5 class="modal-title" id="forgotPasswordLabel">
                            Forgot Password
                        </h5>
                        <button
                          type="button"
                          class="btn-close btn-close-white"
                          data-bs-dismiss="modal"
                          aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label
                              for="forgot_username"
                              class="form-label"
                              >Enter your Username or Email</label
                            >
                            <input
                              type="text"
                              class="form-control"
                              id="forgot_username"
                              name="forgot_username"
                              required
                            />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                          type="submit"
                          id="forgotSubmitBtn"
                          class="btn"
                          style="background-color: #68d391; font-weight: 700;"
                        >
                            Send Reset Code
                        </button>
                        <button
                          type="button"
                          id="loadingBtn"
                          class="btn btn-success"
                          style="display: none;"
                          disabled
                        >
                            <span
                              class="spinner-border spinner-border-sm"
                              role="status"
                              aria-hidden="true"
                            ></span>
                            Sending...
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    ></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
    ></script>

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
                        }
                        form.classList.add("was-validated");
                    },
                    false
                );
            });
        })();
    </script>

    <script>
        document
          .getElementById("forgotPasswordForm")
          .addEventListener("submit", function (event) {
              const input = document.getElementById("forgot_username");
              if (!input.value.trim()) {
                  input.classList.add("is-invalid");
                  event.preventDefault();
                  return;
              } else {
                  input.classList.remove("is-invalid");
              }

              document.getElementById("forgotSubmitBtn").style.display = "none";
              document.getElementById("loadingBtn").style.display = "inline-block";
              document
                .getElementById("loading-overlay")
                .classList.add("show");
          });

        document
          .querySelector('form[action="{{ route('tenants.login.request') }}"]')
          .addEventListener("submit", function (event) {
              if (!this.checkValidity()) {
                  event.preventDefault();
                  event.stopPropagation();
                  this.classList.add("was-validated");
                  return;
              }

              document.getElementById("loginSubmitBtn").style.display = "none";
              document.getElementById("loginLoadingBtn").style.display = "inline-block";
          });
        </script>

</body>
</html>