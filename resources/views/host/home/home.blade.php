<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <!-- Toastr CSS CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body>
    <h1>Welcome AVA Host</h1>
    <a href="{{ route('host.huberts.dashboard.page') }}">Hubert Residence</a>
    <a href="{{ route('host.jjs1.dashboard.page') }}">Jjs 1 Bldg</a>
    <a href="{{ route('host.jjs2.dashboard.page')}}">Jjs 2 Bldg</a>
    <a href="{{ route('host.logout.request') }}">Logout</a>

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
</body>
</html>
