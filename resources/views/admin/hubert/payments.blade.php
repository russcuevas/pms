<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Payment</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
</head>
<body>
<div class="container my-5">
    <h5>Create Payment</h5>

    <div class="mb-4">
        <h5 class="mb-0">
            For: <strong>{{ $tenant->fullname }}</strong> |
            Unit: <strong>{{ $unit->units_name }}</strong>
        </h5>

        <div class="alert alert-info mt-3">
            Balance <strong>₱{{ number_format($billing->total_balance_to_pay, 2) }}</strong>
        </div>
    </div>

    <form class="needs-validation" novalidate action="{{ route('admin.hubert.payments.request') }}" method="POST">
        @csrf

        <input type="hidden" name="unit_id" value="{{ $unit->id }}">
        <input type="hidden" name="tenant_id" value="{{ $tenant->id }}">
        <input type="hidden" name="property_id" value="{{ $tenant->property_id }}">
        <input type="hidden" name="billings_id" value="{{ $billing->id ?? '' }}">

        <div class="mb-3">
            <label>For the Month Of:</label>
            <input type="month" name="for_the_month_of" class="form-control" value="{{ $billing->for_the_month_of ?? '' }}" required>
            <div class="invalid-feedback">Please select a month.</div>
        </div>

        <div class="mb-3">
            <label>Amount:</label>
            <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror" step="0.01" required value="{{ old('amount') }}">
            @error('amount')
                <div class="invalid-feedback">{{ $message }}</div>
            @else
                <div class="invalid-feedback">Please enter a valid amount.</div>
            @enderror
        </div>


        <div class="mb-3">
            <label>Reference Number:</label>
            <input type="text" name="reference_number" class="form-control" required>
            <div class="invalid-feedback">Please provide a reference number.</div>
        </div>

        <div class="mb-3">
            <label>Mode of Payment:</label>
            <select name="mode_of_payment" class="form-control" required>
                <option value="">-- Select --</option>
                <option value="cash">Cash</option>
                <option value="online payment">Online Payment</option>
            </select>
            <div class="invalid-feedback">Please select a payment mode.</div>
        </div>

        <div class="mb-3">
            <label>Payment Type:</label>
            <select name="type" class="form-control" required>
                <option value="">-- Select --</option>
                <option value="advance payment">Advance Payment</option>
                <option value="deposit payment">Deposit Payment</option>
                <option value="ontime payment">Ontime Payment</option>
                <option value="late payment">Late Payment</option>

            </select>
            <div class="invalid-feedback">Please select a payment type.</div>
        </div>

        <a href="{{ route('admin.huberts.units.management.page') }}" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-success">Submit Payment</button>
    </form>
</div>

<script>
(() => {
    'use strict';
    const forms = document.querySelectorAll('.needs-validation');

    Array.from(forms).forEach(form => {
        form.addEventListener('submit', e => {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();
</script>
</body>
</html>
