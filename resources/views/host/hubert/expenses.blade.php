<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Host - Expenses Management</title>

  <!-- CSS Links -->
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" />

  <style>
    body {
      background-color: #e9ecef;
    }

    .bottom-nav {
      position: fixed;
      bottom: 0;
      width: 100%;
      background: #000;
      display: flex;
      justify-content: space-around;
      padding: 10px 0;
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

  <!-- TOP NAV BAR -->
  <div class="bg-dark text-white py-3">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-6">
          <div>
            <small class="text-uppercase text-white">HUBERTS HOST PANEL</small>
            <div class="fw-bold">Host/Owner</div>
          </div>
        </div>
        <div class="col-6 text-end">
          <a href="{{ route('host.logout.request') }}" class="text-white text-decoration-none">
            <i class="fas fa-sign-out-alt fs-5"></i> Logout
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- MAIN CONTENT -->
  <div class="container my-5">
    <h2 class="mb-4">Expenses Management</h2>

    <div class="table-responsive">
      <table id="expensesTable" class="table table-bordered table-striped nowrap" style="width:100%">
        <thead>
          <tr>
            <th>Date</th>
            <th>Salaries</th>
            <th>Labor</th>
            <th>Materials</th>
            <th>Food</th>
            <th>Taxes</th>
            <th>Miscellaneous</th>
            <th>Water & Electricity</th>
            <th>Refund</th>
            <th>Remarks</th>
            <th>Total</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($expenses as $expense)
          <tr>
            <td>{{ \Carbon\Carbon::parse($expense->date)->format('M d, Y') }}</td>
            <td>₱{{ number_format($expense->salaries, 2) }}</td>
            <td>₱{{ number_format($expense->labor_for_repair, 2) }}</td>
            <td>₱{{ number_format($expense->materials, 2) }}</td>
            <td>₱{{ number_format($expense->food, 2) }}</td>
            <td>₱{{ number_format($expense->taxes, 2) }}</td>
            <td>₱{{ number_format($expense->miscellaneous, 2) }}</td>
            <td>₱{{ number_format($expense->water_electricity, 2) }}</td>
            <td>₱{{ number_format($expense->refund, 2) }}</td>
            <td>{{ $expense->remarks ?? '-' }}</td>
            <td class="fw-bold">₱{{ number_format($expense->total, 2) }}</td>
            <td>
              @if ($expense->is_approved)
                <span class="badge bg-success">Approved</span>
              @else
                <form action="{{ route('host.hubert.expenses.approve', $expense->id) }}" method="POST" style="display:inline;">
                  @csrf
                  <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Approve this expense?')">Approve</button>
                </form>

                <form action="{{ route('host.hubert.expenses.decline', $expense->id) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Decline and delete this expense?')">Decline</button>
                </form>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <!-- Bottom Navigation -->
  <div class="bottom-nav">
    <a href="{{ route('host.huberts.dashboard.page') }}">
      <i class="fas fa-home"></i><br>Back to dashboard
    </a>
  </div>

  <!-- JS Links -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <!-- DataTable Init -->
  <script>
    $(document).ready(function () {
      $('#expensesTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        language: {
          emptyTable: "No expenses available.",
        }
      });
    });
  </script>

  <!-- Toastr -->
  <script>
    @if (session('success'))
      toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "3000"
      };
      toastr.success("{{ session('success') }}");
    @endif
  </script>

</body>
</html>
