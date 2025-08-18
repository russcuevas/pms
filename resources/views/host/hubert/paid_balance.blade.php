<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paid Billings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Paid Billings</h2>

    <!-- Filter Buttons -->
    <div class="mb-3">
        <a href="{{ route('host.hubert.balance.page') }}" class="btn btn-info">All Billings</a>
        <a href="{{ route('host.hubert.balance.paid.page') }}" class="btn btn-success">Paid</a>
        <a href="{{ route('host.hubert.balance.delinquent.page') }}" class="btn btn-danger">Delinquent</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SOA No.</th>
                <th>Name</th>
                <th>Unit</th>
                <th>Balance</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($billings as $billing)
            <tr>
                <td>{{ $billing->soa_no }}</td>
                <td>{{ $billing->fullname }}</td>
                <td>{{ $billing->units_name }}</td>
                <td>₱{{ $billing->total_balance_to_pay }}</td>
                <td>
                    @if ($billing->status === 'paid')
                        <span class="badge bg-success">{{ $billing->status }}</span>
                    @else
                        <span class="badge bg-danger">{{ $billing->status }}</span>
                    @endif
                </td>
                <td>
                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#billingModal{{ $billing->id }}">
                        View Details
                    </button>

<!-- Modal -->
                    <div class="modal fade" id="billingModal{{ $billing->id }}" tabindex="-1" aria-labelledby="billingModalLabel{{ $billing->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header text-white" style="background-color: black">
                <h5 class="modal-title">Billing Summary - SOA No: {{ $billing->soa_no }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h5>Unit: {{ $billing->units_name }}</h5>
                <table class="table table-bordered">
                    <tbody>
                        <tr><th>Acct No</th><td>{{ $billing->account_number }}</td></tr>
                        <tr><th>SOA No</th><td>{{ $billing->soa_no }}</td></tr>
                        <tr><th>For the Month Of</th><td>{{ $billing->for_the_month_of }}</td></tr>
                        <tr><th>Statement Date</th><td>{{ $billing->statement_date }}</td></tr>
                        <tr><th>Due Date</th><td>{{ $billing->due_date }}</td></tr>
                        <tr><td colspan="2"><strong>BILLING BREAKDOWN</strong></td></tr>
                        <tr><th>Rental</th><td>{{ number_format($billing->rental, 2) }}</td></tr>
                        <tr><th>Water</th><td>{{ number_format($billing->water, 2) }}</td></tr>
                        <tr><th>Electricity</th><td>{{ number_format($billing->electricity, 2) }}</td></tr>
                        <tr><th>Parking</th><td>{{ number_format($billing->parking, 2) }}</td></tr>
                        <tr><th>Foam</th><td>{{ number_format($billing->foam, 2) }}</td></tr>
                        <tr><th>Previous Balance</th><td>{{ number_format($billing->previous_balance, 2) }}</td></tr>
                        <tr><th>Total Payment</th><td>{{ number_format($billing->total_payment, 2) }}</td></tr>

                        <tr><td colspan="2"><strong>ELECTRICITY & WATER BREAKDOWN</strong></td></tr>
                        <tr>
                            <td class="col-6">
                                <strong>Electricity</strong>
                                <ul>
                                    <li><strong>Current:</strong> {{ $billing->current_electricity }}</li>
                                    <li><strong>Previous:</strong> {{ $billing->previous_electricity }}</li>
                                    <li><strong>Consumption:</strong> {{ $billing->consumption_electricity }}</li>
                                    <li><strong>Rate per kWh:</strong> {{ $billing->rate_per_kwh_electricity }}</li>
                                    <li><strong>Total Electricity:</strong> {{ number_format($billing->total_electricity, 2) }}</li>
                                </ul>
                            </td>
                            <td class="col-6">
                                <strong>Water</strong>
                                <ul>
                                    <li><strong>Current:</strong> {{ $billing->current_water }}</li>
                                    <li><strong>Previous:</strong> {{ $billing->previous_water }}</li>
                                    <li><strong>Consumption:</strong> {{ $billing->consumption_water }}</li>
                                    <li><strong>Rate per cu.m:</strong> {{ $billing->rate_per_cu_water }}</li>
                                    <li><strong>Total Water:</strong> {{ number_format($billing->total_water, 2) }}</li>
                                </ul>
                            </td>
                        </tr>

                        <tr>
                            <th>Payment Computation</th>
                            <td>
                                <strong>TO PAY:</strong> {{ number_format($billing->total_payment, 2) }}<br>
                                <strong>TENANT PAY AMOUNT:</strong> {{ number_format($billing->amount, 2) }}<br>
                                <hr>
                                <strong>Balance for that month:</strong> 
                                {{ number_format($billing->total_payment - $billing->amount, 2) }} - {{ ucfirst($billing->status) }}
                            </td>
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

                    <!-- End Modal -->
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
