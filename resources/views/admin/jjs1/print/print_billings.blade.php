<!DOCTYPE html>
<html>
<head>
    <title>BILLINGS</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 8px; border: 1px solid #ccc; text-align: left; }
        h2 { text-align: center; margin-bottom: 20px; }
        .section-title { margin-top: 20px; font-weight: bold; text-transform: uppercase; }
    </style>
</head>
<body>

<h2>Statement of Account - Unit: {{ $billing->units_name }}</h2>
<table>
    <tr><td>Tenant Name</td><td>{{ $billing->tenant_name ?? 'N/A' }}</td></tr>
    <tr><td>Phone Number</td><td>{{ $billing->tenant_phone_number ?? 'N/A' }}</td></tr>
    <tr><td>Email</td><td>{{ $billing->tenant_email ?? 'N/A' }}</td></tr>
</table>

<table>
    <tr><td>Acct No</td><td>{{ $billing->account_number }}</td></tr>
    <tr><td>SOA No</td><td>{{ $billing->soa_no }}</td></tr>
    <tr><td>For the Month Of</td><td>{{ $billing->for_the_month_of }}</td></tr>
    <tr><td>Statement Date</td><td>{{ $billing->statement_date }}</td></tr>
    <tr><td>Due Date</td><td>{{ $billing->due_date }}</td></tr>
</table>

<div class="section-title">Billing Breakdown</div>
<table>
    <tr><td>Rental</td><td>{{ number_format($billing->rental, 2) }}</td></tr>
    <tr><td>Water</td><td>{{ number_format($billing->water, 2) }}</td></tr>
    <tr><td>Electricity</td><td>{{ number_format($billing->electricity, 2) }}</td></tr>
    <tr><td>Parking</td><td>{{ number_format($billing->parking, 2) }}</td></tr>
    <tr><td>Foam</td><td>{{ number_format($billing->foam, 2) }}</td></tr>
    <tr><td>Previous Balance</td><td>{{ number_format($billing->previous_balance, 2) }}</td></tr>
    <tr><td>Total Payment</td><td>{{ number_format($billing->total_payment, 2) }}</td></tr>
</table>

<div class="section-title">Electricity & Water Breakdown</div>
<table>
    <tr>
        <th>Electricity</th>
        <th>Water</th>
    </tr>
    <tr>
        <td>
            • Current: {{ number_format($billing->current_electricity, 2) }}<br>
            • Previous: {{ number_format($billing->previous_electricity, 2) }}<br>
            • Consumption: {{ number_format($billing->consumption_electricity, 2) }}<br>
            • Rate per kWh: {{ number_format($billing->rate_per_kwh_electricity, 4) }}<br>
            • Total: {{ number_format($billing->total_electricity, 2) }}
        </td>
        <td>
            • Current: {{ number_format($billing->current_water, 2) }}<br>
            • Previous: {{ number_format($billing->previous_water, 2) }}<br>
            • Consumption: {{ number_format($billing->consumption_water, 2) }}<br>
            • Rate per cu.m: {{ number_format($billing->rate_per_cu_water, 4) }}<br>
            • Total: {{ number_format($billing->total_water, 2) }}
        </td>
    </tr>
</table>

<div class="section-title">Payment Computation</div>
<table>
    <tr><td>AMOUNT</td><td>{{ number_format($billing->amount, 2) }} - {{ ucfirst($billing->status) }}</td></tr>
</table>

</body>
</html>
