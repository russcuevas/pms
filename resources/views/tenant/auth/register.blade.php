<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tenants Register</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- Toastr CSS -->
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
            max-width: 720px;
            overflow-y: auto;
            max-height: 90vh;
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
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.6);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            text-align: center;
        }

    </style>
</head>
<body>

<!-- Loading overlay -->
<div id="loading-overlay">
    <div>
        <div class="spinner-border text-light mb-3" role="status">
            <span class="visually-hidden">Loading...</span>
        </div><br>
        Please wait processing your request...
    </div>
</div>

<div class="register-container">
    <h2 class="text-center mb-4" style="font-weight: 700">AVA Tenants Register</h2>

    <form action="{{ route('tenants.register.request') }}" method="POST" class="row g-3 novalidate" novalidate>
        @csrf

        <div class="col-md-6">
            <label for="fullname" class="form-label">Fullname</label>
            <input type="text" class="form-control" id="fullname" name="fullname" value="{{ old('fullname') }}" required>
            <div class="invalid-feedback">Please enter your fullname.</div>
        </div>

        <div class="col-md-6">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
            <div class="invalid-feedback">Please enter your username.</div>
        </div>

        <div class="col-md-6">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
            <div class="invalid-feedback">Please enter your password.</div>
        </div>

        <div class="col-md-6">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
            <div class="invalid-feedback">Please enter a valid email address.</div>
        </div>

        <div class="col-md-6">
            <label for="phone_number" class="form-label">Phone number</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required>
            <div class="invalid-feedback">Please enter your phone number.</div>
        </div>

        <div class="col-md-6">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required>
            <div class="invalid-feedback">Please enter your address.</div>
        </div>

        <div class="col-md-6">
            <label for="move_in_date" class="form-label">Move in</label>
            <input type="date" class="form-control" id="move_in_date" name="move_in_date" value="{{ old('move_in_date') }}" required>
            <div class="invalid-feedback">Please select your move-in date.</div>
        </div>

        <div class="col-md-6">
            <label for="move_out_date" class="form-label">Move out</label>
            <input type="date" class="form-control" id="move_out_date" name="move_out_date" value="{{ old('move_out_date') }}" required>
            <div class="invalid-feedback">Please select your move-out date.</div>
        </div>

        <div class="col-md-6">
            <label for="property_id" class="form-label">Property</label>
            <select class="form-select" id="property_id" name="property_id" required>
                <option value="">-- Select Property --</option>
                @foreach ($properties as $property)
                    <option value="{{ $property->id }}" {{ old('property_id') == $property->id ? 'selected' : '' }}>
                        {{ $property->property_name }}
                    </option>
                @endforeach
            </select>
            <div class="invalid-feedback">Please select a property.</div>
        </div>

        <div class="col-md-6">
            <label for="unit_name" class="form-label">Unit Name</label>
            <input type="text" class="form-control" id="unit_name" name="unit_name" disabled placeholder="Select property first" value="{{ old('unit_name') }}">
            <div class="invalid-feedback">Please enter your unit name.</div>
        </div>

        <div class="col-md-6">
            <label for="advance_deposit" class="form-label">Advance and Deposit Payment</label>
            <input type="text" class="form-control" id="advance_deposit" name="advance_deposit" value="{{ old('advance_deposit') }}" required>
        </div>

        <div class="col-md-6">
            <label for="contact_fullname" class="form-label">Contact Person Fullname</label>
            <input type="text" class="form-control" id="contact_fullname" name="contact_fullname" value="{{ old('contact_fullname') }}" required>
        </div>

        <div class="col-md-6">
            <label for="contact_phone_number" class="form-label">Contact Person Phone Number</label>
            <input type="text" class="form-control" id="contact_phone_number" name="contact_phone_number" value="{{ old('contact_phone_number') }}" required>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary w-100" style="background-color: #68d391; font-weight: 700;">Done</button>
        </div>

        <div class="col-12 text-center">
            <a style="color: #68d391;" href="{{ route('tenants.login.page') }}">Login here</a>
        </div>
    </form>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(document).ready(function () {
        $('#property_id').on('change', function () {
            const propertyId = $(this).val();
            if(propertyId){
                $('#unit_name').prop('disabled', false).attr('placeholder', 'Enter your unit name');
            } else {
                $('#unit_name').prop('disabled', true).val('').attr('placeholder', 'Select property first');
            }
        });

        if($('#property_id').val()){
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

<!-- Bootstrap validation with loader -->
<script>
(() => {
    'use strict'
    const forms = document.querySelectorAll('.novalidate')
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            } else {
                // Show loading overlay on valid submit
                document.getElementById('loading-overlay').style.display = 'flex';
            }
            form.classList.add('was-validated')
        }, false)
    })
})()
</script>

</body>
</html>
