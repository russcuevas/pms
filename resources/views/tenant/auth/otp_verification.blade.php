<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OTP Verification</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body>
    <h1>OTP Verification</h1>

    <form action="{{ route('tenants.verify.otp') }}" method="POST">
        @csrf
        <label for="otp_code">Enter OTP:</label><br>
        <input type="number" name="otp_code" required><br><br>

        <input type="submit" value="Verify OTP">
    </form>

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
