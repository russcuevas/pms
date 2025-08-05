<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h2>Create Payment</h2>
    <form action="{{ route('admin.hubert.payments.request') }}" method="POST">
        @csrf

        <input type="hidden" name="unit_id" value="{{ $unit->id }}">
        <input type="hidden" name="tenant_id" value="{{ $tenant->id }}">
        <input type="hidden" name="property_id" value="{{ $tenant->property_id }}">
        <input type="hidden" name="billings_id" value="{{ $billing->id ?? '' }}">

        <div class="mb-3">
            <label>Tenant Name:</label>
            <input type="text" class="form-control" value="{{ $tenant->fullname }}" disabled>
        </div>

        <div class="mb-3">
            <label>For the Month Of:</label>
            <input type="month" name="for_the_month_of" class="form-control" value="{{ $billing->for_the_month_of ?? '' }}" required>
        </div>

        <div class="mb-3">
            <label>Amount:</label>
            <input type="number" name="amount" class="form-control" step="0.01" required>
        </div>

        <div class="mb-3">
            <label>Reference Number:</label>
            <input type="text" name="reference_number" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Mode of Payment:</label>
            <select name="mode_of_payment" class="form-control" required>
                <option value="">-- Select --</option>
                <option value="cash">Cash</option>
                <option value="online payment">Online Payment</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Payment Type:</label>
            <select name="type" class="form-control" required>
                <option value="">-- Select --</option>
                <option value="advance">Advance</option>
                <option value="deposit">Deposit</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Submit Payment</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
