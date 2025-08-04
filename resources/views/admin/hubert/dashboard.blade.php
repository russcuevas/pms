<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hubert Dashboard</title>

    <!-- ✅ Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body>
    Hubert Dashboard
    @include('admin.hubert.left_sidebar')

    <!-- ✅ jQuery (Required) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- ✅ Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

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
