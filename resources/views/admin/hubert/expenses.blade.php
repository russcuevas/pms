<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hubert Expenses</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    Expenses
    @include('admin.hubert.left_sidebar')

    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Expenses</h4>
            <div>
                <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#addExpenseModal">+ Add Expenses</button>                
                <button id="printBtn" class="btn btn-success">
                    <i class="fa-solid fa-print"></i> Print
                </button>
            </div>
        </div>


        <!-- Expenses Table -->
        <div class="table-responsive">
            <table id="expensesTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Salaries</th>
                        <th>Labor</th>
                        <th>Materials</th>
                        <th>Food</th>
                        <th>Taxes</th>
                        <th>Miscellaneous</th>
                        <th>Utilities</th>
                        <th>Refund</th>
                        <th>Office Supplies</th>
                        <th>Total</th>
                        <th>Remarks</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expenses as $expense)
                    <tr>
                        <td>{{ $expense->date }}</td>
                        <td>₱{{ number_format($expense->salaries, 2) }}</td>
                        <td>₱{{ number_format($expense->labor_for_repair, 2) }}</td>
                        <td>₱{{ number_format($expense->materials, 2) }}</td>
                        <td>₱{{ number_format($expense->food, 2) }}</td>
                        <td>₱{{ number_format($expense->taxes, 2) }}</td>
                        <td>₱{{ number_format($expense->miscellaneous, 2) }}</td>
                        <td>₱{{ number_format($expense->water_electricity, 2) }}</td>
                        <td>₱{{ number_format($expense->refund, 2) }}</td>
                        <td>₱{{ number_format($expense->office_supplies, 2) }}</td>
                        <td>₱{{ number_format($expense->total, 2) }}</td>
                        <td>{{ $expense->remarks }}</td>
                        <td><span class="badge bg-success">Approved</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="modal fade" id="addExpenseModal" tabindex="-1" aria-labelledby="addExpenseModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <form action="{{ route('admin.huberts.expenses.request') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addExpenseModalLabel">Add New Expense</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body row g-3">
                            <div class="col-md-6">
                                <label>Date</label>
                                <input type="date" name="date" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label>Salaries</label>
                                <input type="text" name="salaries" id="salaries" class="form-control" value="0" required>
                            </div>

                            <div class="col-md-6">
                                <label>Labor for Repair</label>
                                <input type="text" name="labor_for_repair" id="labor_for_repair" class="form-control" value="0" required>

                            </div>

                            <div class="col-md-6">
                                <label>Materials</label>
                                <input type="text" name="materials" id="materials" class="form-control" value="0" required>

                            </div>

                            <div class="col-md-6">
                                <label>Food</label>
                                <input type="text" name="food" id="food" class="form-control" value="0" required>

                            </div>

                            <div class="col-md-6">
                                <label>Taxes</label>
                                <input type="text" name="taxes" id="taxes" class="form-control" value="0" required>

                            </div>

                            <div class="col-md-6">
                                <label>Miscellaneous</label>
                                <input type="text" name="miscellaneous" id="miscellaneous" class="form-control" value="0" required>

                            </div>

                            <div class="col-md-6">
                                <label>Water & Electricity</label>
                                <input type="text" name="water_electricity" id="water_electricity" class="form-control" value="0" required>
                            </div>

                            <div class="col-md-6">
                                <label>Refund</label>
                                <input type="text" name="refund" id="refund" class="form-control" value="0" required>
                            </div>

                            <div class="col-md-6">
                                <label>Office Supplies</label>
                                <input type="text" name="office_supplies" id="office_supplies" class="form-control" value="0" required>
                            </div>

                            <div class="col-md-12">
                                <label>Remarks</label>
                                <textarea name="remarks" class="form-control" rows="2" required></textarea>
                            </div>

                            <div class="col-md-12">
                                <label>Total</label>
                                <input style="background-color: gray; color: white;" type="number" step="0.01" name="total" id="total" class="form-control" value="0" readonly>
                            </div>


                            <input type="hidden" name="property_id" value="{{ $property_id ?? 1 }}">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Save Expense</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#expensesTable').DataTable();
        });
    </script>
<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }
      form.classList.add('was-validated')
    }, false)
  })
})()
</script>

    <script>
        @if (session('success'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut": "3000",
                "positionClass": "toast-top-right"
            };
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut": "3000",
                "positionClass": "toast-top-right"
            };
            toastr.error("{{ session('error') }}");
        @endif
    </script>

    <script>
        function calculateTotal() {
            const getVal = id => parseFloat(document.getElementById(id).value) || 0;

            const total =
                getVal('salaries') +
                getVal('labor_for_repair') +
                getVal('materials') +
                getVal('food') +
                getVal('taxes') +
                getVal('miscellaneous') +
                getVal('water_electricity') +
                getVal('refund') +
                getVal('office_supplies');

            document.getElementById('total').value = total.toFixed(2);
        }

        const fields = [
            'salaries',
            'labor_for_repair',
            'materials',
            'food',
            'taxes',
            'miscellaneous',
            'water_electricity',
            'refund',
            'office_supplies'
        ];

        fields.forEach(id => {
            document.getElementById(id).addEventListener('input', calculateTotal);
        });
    </script>

</body>
</html>
