<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Records</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

    <h1>Billing Records</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tenant</th>
                <th>Unit</th>
                <th>Paid Amount</th>
                <th>Previous Balance</th>
                <th>Total Balance</th>
                <th>Billing</th>
                <th>For the Month Of</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($billings as $billing)
                <tr>
                    <td>{{ $billing->tenant_name }}</td>
                    <td>{{ $billing->unit_name }}</td>
                    <td>{{ number_format($billing->amount, 2) }}</td>
                    <td>{{ number_format($billing->previous_balance, 2) }}</td>
                    <td>{{ number_format($billing->total_balance_to_pay, 2) }}</td>
                    <td>{{ number_format($billing->total_payment, 2) }}</td>
                    <td>{{ $billing->for_the_month_of }}</td>
                    <td>{{ ucfirst($billing->status) }}</td>
                    <td>
                        <a href="{{ route('host.huberts.previous.billings', $billing->tenant_id) }}" class="btn btn-sm btn-secondary">
                            View Previous Billings
                        </a>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#billingModal{{ $billing->id }}">
                            View Summary
                        </button>

                        
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modals OUTSIDE the table -->
    @foreach ($billings as $billing)
    <div class="modal fade" id="billingModal{{ $billing->id }}" tabindex="-1" aria-labelledby="billingModalLabel{{ $billing->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Billing Summary - SOA No: {{ $billing->soa_no }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Table structure to match the layout from the image -->
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Acct No</th>
                                <td>{{ $billing->account_number }}</td>
                            </tr>
                            <tr>
                                <th>SOA No</th>
                                <td>{{ $billing->soa_no }}</td>
                            </tr>
                            <tr>
                                <th>For the Month Of</th>
                                <td>{{ $billing->for_the_month_of }}</td>
                            </tr>
                            <tr>
                                <th>Statement Date</th>
                                <td>{{ $billing->statement_date }}</td>
                            </tr>
                            <tr>
                                <th>Due Date</th>
                                <td>{{ $billing->due_date }}</td>
                            </tr>
                            <tr><td colspan="2"><strong>Billing Breakdown</strong></td></tr>
                            <tr>
                                <th>Rental</th>
                                <td>{{ number_format($billing->rental, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Water</th>
                                <td>{{ number_format($billing->water, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Electricity</th>
                                <td>{{ number_format($billing->electricity, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Parking</th>
                                <td>{{ number_format($billing->parking, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Foam</th>
                                <td>{{ number_format($billing->foam, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Previous Balance</th>
                                <td>{{ number_format($billing->previous_balance, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Total Balance To Pay</th>
                                <td>{{ number_format($billing->total_balance_to_pay, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Total Payment</th>
                                <td>{{ number_format($billing->total_payment, 2) }}</td>
                            </tr>
                            
                            <!-- Begin the Electricity and Water Section with Bootstrap Grid -->
                            <tr><td colspan="2"><strong>Electricity & Water Breakdown</strong></td></tr>
                            
                            <tr>
                                <td class="col-6">
                                    <!-- Electricity Info (Left) -->
                                    <strong>Electricity</strong>
                                    <ul>
                                        <li><strong>Current:</strong> {{ $billing->current_electricity }}</li>
                                        <li><strong>Previous:</strong> {{ $billing->previous_electricity }}</li>
                                        <li><strong>Consumption:</strong> {{ $billing->consumption_electricity }}</li>
                                        <li><strong>Rate per kWh:</strong> {{ number_format($billing->rate_per_kwh_electricity, 4) }}</li>
                                        <li><strong>Total Electricity:</strong> {{ number_format($billing->total_electricity, 2) }}</li>
                                    </ul>
                                </td>
                                <td class="col-6">
                                    <!-- Water Info (Right) -->
                                    <strong>Water</strong>
                                    <ul>
                                        <li><strong>Current:</strong> {{ $billing->current_water }}</li>
                                        <li><strong>Previous:</strong> {{ $billing->previous_water }}</li>
                                        <li><strong>Consumption:</strong> {{ $billing->consumption_water }}</li>
                                        <li><strong>Rate per cu.m:</strong> {{ number_format($billing->rate_per_cu_water, 4) }}</li>
                                        <li><strong>Total Water:</strong> {{ number_format($billing->total_water, 2) }}</li>
                                    </ul>
                                </td>
                            </tr>

                            <tr>
                                <th>Status</th>
                                <td>{{ ucfirst($billing->status) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
