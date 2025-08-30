<!DOCTYPE html>
<html>
<head>
    <title>PAYMENTS</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 8px; border: 1px solid #ccc; }
        h2 { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>

<h2>Tenant Payment Receipt</h2>

<table>
    <tr><td>Tenant Name</td><td>{{ $payment->tenant_name }}</td></tr>
    <tr><td>Phone Number</td><td>{{ $payment->tenant_phone_number }}</td></tr>
    <tr><td>Email</td><td>{{ $payment->tenant_email }}</td></tr>
    <tr><td>Type</td><td><span style="text-transform: capitalize">{{ $payment->type }}</span></td></tr>
    <tr><td>Unit</td><td>{{ $payment->units_name ?? 'N/A' }}</td></tr>
    <tr><td>For the Month Of</td><td>{{ $payment->for_the_month_of }}</td></tr>
    <tr><td>Amount</td><td>{{ number_format($payment->amount, 2) }}</td></tr>
    <tr><td>Reference #</td><td>{{ $payment->reference_number }}</td></tr>
    <tr><td>Mode</td><td>{{ ucfirst($payment->mode_of_payment) }}</td></tr>
    <tr><td>Status</td><td>{{ $payment->is_approved ? 'Paid' : 'Pending' }}</td></tr>
</table>

</body>
</html>
