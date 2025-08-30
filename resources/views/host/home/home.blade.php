<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AVA Host Dashboard</title>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            padding-top: 30px;
        }

        /* Header */
        h1 {
            font-size: 36px;
            font-weight: 600;
            color: #333;
        }

        /* Card Styling */
        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        .card-img {
            height: 250px;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .card-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 24px;
            font-weight: 600;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
            text-align: center;
        }

        .card-overlay a {
            color: white;
            text-decoration: none;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        .card-overlay a:hover {
            background-color: rgba(0, 0, 0, 0.9);
        }

        .row {
            margin-top: 40px;
        }

        .text-center {
            margin-top: 30px;
        }

        .btn-logout {
            padding: 10px 20px;
            font-size: 18px;
            border-radius: 30px;
            background-color: #e74c3c;
            color: white;
            transition: background-color 0.3s ease;
        }

        .btn-logout:hover {
            background-color: #c0392b;
        }

        /* Responsive Design for smaller screens */
        @media (max-width: 768px) {
            .card-img {
                height: 200px;
            }

            h1 {
                font-size: 28px;
            }

            .card-overlay {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Welcome to AVA Host</h1>

        <!-- Bootstrap Grid for 3 columns -->
        <div class="row">
            <!-- Column 1 -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-img" style="background-image: url('{{ asset('assets/huberts/hubert-banner.png') }}');">
                        <div class="card-overlay">
                            <a href="{{ route('host.huberts.dashboard.page') }}">Hubert</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Column 2 -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-img" style="background-image: url('{{ asset('assets/jjs1/jjs1.png') }}');">
                        <div class="card-overlay">
                            <a href="{{ route('host.jjs1.dashboard.page') }}">Jjs 1 Bldg</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Column 3 -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-img" style="background-image: url('{{ asset('assets/jjs2/jjs2.png') }}');">
                        <div class="card-overlay">
                            <a href="{{ route('host.jjs2.dashboard.page') }}">Jjs 2 Bldg</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Logout Link -->
        <div class="text-center">
            <a href="{{ route('host.logout.request') }}" class="btn btn-logout">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>

    <!-- jQuery and Toastr JS CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Toastr Success Message -->
    <script>
        @if (session('success'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "3000"
            };
            toastr.success("{{ session('success') }}");
        @endif
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</body>
</html>
