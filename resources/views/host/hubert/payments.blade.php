<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h1>Tenant Payments</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tenant</th>
                <th>Unit</th>
                <th>Amount</th>
                <th>For the Month Of</th>
                <th>Reference #</th>
                <th>Mode of Payment</th>
                <th>Type</th>
                <th>Actions</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
                <tr id="payment-row-{{ $payment->id }}">
                    <td>{{ $payment->tenant_name }}</td>
                    <td>{{ $payment->unit_name }}</td>
                    <td>{{ number_format($payment->amount, 2) }}</td>
                    <td>{{ $payment->for_the_month_of }}</td>
                    <td>{{ $payment->reference_number }}</td>
                    <td>{{ ucfirst($payment->mode_of_payment) }}</td>
                    <td>{{ ucfirst($payment->type) }}</td>
                    <td>
                        @if ($payment->is_approved == 1)
                            <p class="text-success">Approved</p>
                        @else
                            <form action="{{ route('host.huberts.payments.approve', $payment->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Approve</button>
                            </form>
                            <form action="{{ route('host.huberts.payments.decline', $payment->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Decline</button>
                            </form>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
