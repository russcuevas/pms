<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Huberts Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body>
    <h1>Huberts Residence</h1>
    <p>Welcome, {{ $tenant->fullname }}</p>
    <p>Your Property: {{ $property->property_name }} (ID: {{ $tenant->property_id }})</p>
    <p>Your Unit: {{ $unit->units_name }} (Unit ID: {{ $tenant->unit_id }})</p>
    <a href="{{ route('tenants.logout.request') }}">Logout</a>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
</body>
</html>
