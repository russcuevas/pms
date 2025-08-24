<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Previous Billing Records</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" />

  <style>
    body {
      background-color: #e9ecef;
      padding-bottom: 70px; /* Space for bottom nav */
    }

    .bottom-nav {
      position: fixed;
      bottom: 0;
      width: 100%;
      background: #000;
      display: flex;
      justify-content: space-around;
      padding: 10px 0;
      z-index: 1030;
    }

    .bottom-nav a {
      color: #fff;
      text-align: center;
      font-size: 14px;
      text-decoration: none;
    }

    .bottom-nav a.active {
      color: #28a745;
    }
  </style>
</head>
<body>

  <div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h3 class="mb-1">Previous Billing Records</h3>
        @php
          $firstBilling = collect($groupedBillings)->flatten(1)->first();
        @endphp
        @if($firstBilling)
          <h5 class="mb-0">
            Tenant: <strong>{{ $firstBilling->tenant_name }}</strong> |
            Unit: <strong>{{ $firstBilling->units_name }}</strong>
          </h5>
        @endif
      </div>

      <div>
        <a href="{{ route('host.huberts.billing.page') }}" class="btn btn-secondary">
          ← Back
        </a>
      </div>
    </div>

    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table id="billingTable" class="table table-bordered table-striped nowrap" style="width:100%">
      <thead class="table-light">
        <tr>
          <th>Month</th>
          <th>SOA No</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($groupedBillings as $month => $billings)
          @foreach ($billings as $billing)
            <tr>
              <td>{{ \Carbon\Carbon::parse($month)->format('F Y') }}</td>
              <td>{{ $billing->soa_no }}</td>
              <td>
                @php
                  $status = strtolower($billing->status);
                @endphp
                @if($status === 'paid')
                  <span class="badge bg-success">{{ ucfirst($billing->status) }}</span>
                @elseif($status === 'pending')
                  <span class="badge bg-warning text-dark">{{ ucfirst($billing->status) }}</span>
                @else
                  <span class="badge bg-secondary">{{ ucfirst($billing->status) }}</span>
                @endif
              </td>
              <td>
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#billingModal{{ $billing->id }}">
                  <i class="fas fa-file-invoice"></i> View Billing Summary
                </button>
              </td>
            </tr>
          @endforeach
        @endforeach
      </tbody>
    </table>
  </div>

  <!-- Bottom Navigation -->
  <div class="bottom-nav">
    <a href="{{ route('host.huberts.dashboard.page') }}">
      <i class="fas fa-home"></i><br>Back to dashboard
    </a>
  </div>

  <!-- Modals OUTSIDE the table -->
  @foreach (collect($groupedBillings)->flatten(1) as $billing)
  <div class="modal fade" id="billingModal{{ $billing->id }}" tabindex="-1" aria-labelledby="billingModalLabel{{ $billing->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Billing Summary - SOA No: {{ $billing->soa_no }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
              <tr><th>Rental</th><td>PHP {{ number_format($billing->rental, 2) }}</td></tr>
              <tr><th>Water</th><td>PHP {{ number_format($billing->water, 2) }}</td></tr>
              <tr><th>Electricity</th><td>PHP {{ number_format($billing->electricity, 2) }}</td></tr>
              <tr><th>Parking</th><td>PHP {{ number_format($billing->parking, 2) }}</td></tr>
              <tr><th>Foam</th><td>PHP {{ number_format($billing->foam, 2) }}</td></tr>
              <tr><th>Previous Balance</th><td>PHP {{ number_format($billing->previous_balance, 2) }}</td></tr>
              <tr><th>Total Payment</th><td>PHP {{ number_format($billing->total_payment, 2) }}</td></tr>

              <tr><td colspan="2"><strong>Electricity & Water Breakdown</strong></td></tr>
              <tr>
                <td class="col-6">
                  <strong>Electricity</strong>
                  <ul>
                    <li><strong>Current:</strong> {{ $billing->current_electricity }}</li>
                    <li><strong>Previous:</strong> {{ $billing->previous_electricity }}</li>
                    <li><strong>Consumption:</strong> {{ $billing->consumption_electricity }}</li>
                    <li><strong>Rate per kWh:</strong> PHP {{ number_format($billing->rate_per_kwh_electricity, 4) }}</li>
                    <li><strong>Total Electricity:</strong> PHP {{ number_format($billing->total_electricity, 2) }}</li>
                  </ul>
                </td>
                <td class="col-6">
                  <strong>Water</strong>
                  <ul>
                    <li><strong>Current:</strong> {{ $billing->current_water }}</li>
                    <li><strong>Previous:</strong> {{ $billing->previous_water }}</li>
                    <li><strong>Consumption:</strong> {{ $billing->consumption_water }}</li>
                    <li><strong>Rate per cu.m:</strong> PHP {{ number_format($billing->rate_per_cu_water, 4) }}</li>
                    <li><strong>Total Water:</strong> PHP {{ number_format($billing->total_water, 2) }}</li>
                  </ul>
                </td>
              </tr>

              <tr>
                <th>Payment Computation</th>
                <td>
                  <strong>TO PAY:</strong> PHP {{ number_format($billing->total_payment, 2) }}<br />
                  <strong>AMOUNT:</strong> PHP {{ number_format($billing->amount, 2) }}<br />
                  <hr />
                  <strong>Balance for that month:</strong> PHP {{ number_format($billing->total_payment - $billing->amount, 2) }} - {{ ucfirst($billing->status) }}
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
  @endforeach

  <!-- JS Dependencies -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>

  <script>
    $(document).ready(function () {
      $('#billingTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        language: {
          emptyTable: "No billing records available.",
        },
        columnDefs: [
          { responsivePriority: 1, targets: -1 }, // Action column highest priority
          { responsivePriority: 2, targets: -2 }  // Status column second highest
        ],
      });
    });
  </script>
</body>
</html>
