<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="container">
    <h2>Billing Form</h2>

    <form action="{{ route('admin.hubert.billing.create') }}" method="POST">
        @csrf

        <!-- Hidden IDs -->
        <input type="hidden" name="tenant_id" value="{{ $tenant->id }}">
        <input type="hidden" name="unit_id" value="{{ $unit->id }}">
        <input type="hidden" name="property_id" value="{{ $property_id }}">

        <table class="table table-bordered text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>Account No</th>
                    <th>SOA No</th>
                    <th>For the Month Of</th>
                    <th>Statement Date</th>
                    <th>Due Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input name="account_number" class="form-control" required></td>
                    <td><input name="soa_no" class="form-control" required></td>
                    <td><input name="for_the_month_of" type="month" class="form-control" required></td>
                    <td><input name="statement_date" type="date" class="form-control" required></td>
                    <td><input name="due_date" type="date" class="form-control" required></td>
                </tr>
            </tbody>
        </table>

        <h5 class="mt-4">Billing Breakdown</h5>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Rental</th>
                    <th>Water</th>
                    <th>Electricity</th>
                    <th>Parking</th>
                    <th>Foam</th>
                    <th>Previous Balance</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input name="rental" type="number" step="0.01" class="form-control" required></td>
                    <td><input name="water" type="number" step="0.01" class="form-control"></td>
                    <td><input name="electricity" type="number" step="0.01" class="form-control"></td>
                    <td><input name="parking" type="number" step="0.01" class="form-control"></td>
                    <td><input name="foam" type="number" step="0.01" class="form-control"></td>
                    <td><input name="previous_balance" type="number" step="0.01" class="form-control"></td>
                </tr>
            </tbody>
        </table>

        <h5 class="mt-4">Electricity</h5>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Current</th>
                    <th>Previous</th>
                    <th>Consumption</th>
                    <th>Rate Per kWh</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input name="current_electricity" type="number" class="form-control"></td>
                    <td><input name="previous_electricity" type="number" class="form-control"></td>
                    <td><input name="consumption_electricity" type="number" class="form-control"></td>
                    <td><input name="rate_per_kwh_electricity" type="number" step="0.01" class="form-control"></td>
                    <td><input name="total_electricity" type="number" step="0.01" class="form-control"></td>
                </tr>
            </tbody>
        </table>

        <h5 class="mt-4">Water</h5>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Current</th>
                    <th>Previous</th>
                    <th>Consumption</th>
                    <th>Rate Per Cu</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input name="current_water" type="number" class="form-control"></td>
                    <td><input name="previous_water" type="number" class="form-control"></td>
                    <td><input name="consumption_water" type="number" class="form-control"></td>
                    <td><input name="rate_per_cu_water" type="number" step="0.01" class="form-control"></td>
                    <td><input name="total_water" type="number" step="0.01" class="form-control"></td>
                </tr>
            </tbody>
        </table>

        <div class="text-end mt-3">
            <button type="submit" class="btn btn-primary">Save Billing</button>
        </div>
    </form>
</div>
</body>
</html>