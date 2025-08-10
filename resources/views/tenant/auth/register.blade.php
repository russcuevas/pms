<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tenants Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body>
    <h1>AVA Tenants Register</h1>

    <form action="{{ route('tenants.register.request') }}" method="POST">
        @csrf
        <label>Fullname:</label><br>
        <input type="text" name="fullname" value="{{ old('fullname') }}">
        <br><br>

        <label>Username:</label><br>
        <input type="text" name="username" value="{{ old('username') }}">
        <br><br>

        <label>Password:</label><br>
        <input type="password" name="password"><br><br>

        <label>Email:</label><br>
        <input type="text" name="email" value="{{ old('email') }}"><br><br>

        <label>Phone number:</label><br>
        <input type="text" name="phone_number" value="{{ old('phone_number') }}"><br><br>

        <label>Address:</label><br>
        <input type="text" name="address" value="{{ old('address') }}"><br><br>

        <label>Move in:</label><br>
        <input type="date" name="move_in_date" value="{{ old('move_in_date') }}"><br><br>

        <label>Move out:</label><br>
        <input type="date" name="move_out_date" value="{{ old('move_out_date') }}"><br><br>

        <label>Property:</label><br>
        <select name="property_id">
            <option value="">-- Select Property --</option>
            @foreach ($properties as $property)
                <option value="{{ $property->id }}" {{ old('property_id') == $property->id ? 'selected' : '' }}>
                    {{ $property->property_name }}
                </option>
            @endforeach
        </select>
        <br><br>

        <label>Unit Name:</label><br>
        <input type="text" name="unit_name" id="unit_name" disabled placeholder="Select property first" value="{{ old('unit_name') }}">
        <br><br>

        <label>Advance and Deposit Payment:</label><br>
        <input type="text" name="advance_deposit" value="{{ old('advance_deposit') }}"><br><br>

        <label>Contact Person Fullname:</label><br>
        <input type="text" name="contact_fullname" value="{{ old('contact_fullname') }}"><br><br>

        <label>Contact Person Phone Number:</label><br>
        <input type="text" name="contact_phone_number" value="{{ old('contact_phone_number') }}"><br><br>

        <input type="submit" value="Done">
        <br><a href="{{ route('tenants.login.page') }}">Login here</a>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function () {
            $('select[name="property_id"]').on('change', function () {
                const propertyId = $(this).val();
                if(propertyId){
                    $('#unit_name').prop('disabled', false).attr('placeholder', 'Enter your unit name');
                } else {
                    $('#unit_name').prop('disabled', true).val('').attr('placeholder', 'Select property first');
                }
            });

            const selectedPropertyId = $('select[name="property_id"]').val();
            if(selectedPropertyId){
                $('#unit_name').prop('disabled', false).attr('placeholder', 'Enter your unit name');
            }

            $('#unit_name').on('focus', function(){
                $(this).val('');
            });
        });
    </script>


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
