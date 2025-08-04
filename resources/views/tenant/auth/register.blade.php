<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tenants Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body>
    <h1>AVA Tenants Register</h1>

    <form action="" method="POST">
        @csrf
        <label>Fullname:</label><br>
        <input type="text" name="fullname"><br><br>

        <label>Username:</label><br>
        <input type="text" name="username"><br><br>

        <label>Password:</label><br>
        <input type="password" name="password"><br><br>

        <label>Email:</label><br>
        <input type="text" name="email"><br><br>

        <label>Phone number:</label><br>
        <input type="text" name="phone_number"><br><br>

        <label>Address:</label><br>
        <input type="text" name="address"><br><br>

        <label>Property:</label><br>
        <select name="property_id">
            <option value="">-- Select Property --</option>
            @foreach ($properties as $property)
                <option style="text-transform: capitalize" value="{{ $property->id }}">{{ $property->property_name }}</option>
            @endforeach
        </select><br><br>

        <input type="submit" value="Done">
        <br><a href="">Login here</a>
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
