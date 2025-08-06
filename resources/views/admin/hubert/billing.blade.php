<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Form</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <style>
    input[readonly] {
        background-color: #6c757d !important;
        color: #fff !important;
    }
</style>

</head>
<body>
<div class="container mt-5">
    <h5>Billing Form</h5>
    <div class="mb-4">
        <h5 class="mb-0">
            Tenant: <strong>{{ $tenant->fullname }}</strong> |
            Unit: <strong>{{ $unit->units_name }}</strong>
        </h5>

        <div class="alert alert-info mt-3">
            Balance <strong>₱{{ number_format($lastTotalBalance, 2) }}</strong>
        </div>
    </div>

<form action="{{ route('admin.hubert.billing.create') }}" method="POST" novalidate>
    @csrf

    <!-- Hidden IDs -->
    <input type="hidden" name="tenant_id" value="{{ $tenant->id }}">
    <input type="hidden" name="unit_id" value="{{ $unit->id }}">
    <input type="hidden" name="property_id" value="{{ $property_id }}">

    <!-- Main Billing Info -->
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
                <td>
                    <input name="account_number" class="form-control" required>
                    <div class="invalid-feedback">Account number is required.</div>
                </td>
                <td>
                    <input id="soaNo" name="soa_no" class="form-control" readonly required>
                    <div class="invalid-feedback">SOA number is required.</div>
                </td>
                <td>
                    <input name="for_the_month_of" type="month" class="form-control" required>
                    <div class="invalid-feedback">Please select a month.</div>
                </td>
                <td>
                    <input name="statement_date" type="date" class="form-control" required>
                    <div class="invalid-feedback">Statement date is required.</div>
                </td>
                <td>
                    <input name="due_date" type="date" class="form-control" required>
                    <div class="invalid-feedback">Due date is required.</div>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Billing Breakdown -->
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
                <td>
                    <input id="rental" name="rental" type="number" step="0.01" class="form-control" required>
                    <div class="invalid-feedback">Rental is required.</div>
                </td>
                <td>
                    <input id="billingWater" name="water" type="number" step="0.01" class="form-control" readonly>
                </td>
                <td>
                    <input id="billingElectricity" name="electricity" type="number" step="0.01" class="form-control" readonly>
                </td>
                <td>
                    <input id="parking" name="parking" type="number" step="0.01" class="form-control" required>
                    <div class="invalid-feedback">Parking fee is required.</div>
                </td>
                <td>
                    <input id="foam" name="foam" type="number" step="0.01" class="form-control" required>
                    <div class="invalid-feedback">Foam fee is required.</div>
                </td>
                <td>
                    <input id="previous_balance" readonly name="previous_balance" type="number" step="0.01" class="form-control" required value="{{ $lastTotalBalance }}">
                    <div class="invalid-feedback">Previous balance is required.</div>
                </td>
            </tr>
            <tr>
                <td colspan="5" class="text-end fw-bold align-middle">TOTAL BALANCE TO PAY</td>
                <td>
                    <input id="totalBalance" name="total_balance" type="number" step="0.01" class="form-control" readonly>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Electricity -->
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
                <td>
                    <input id="currentElectricity" name="current_electricity" type="number" class="form-control" required>
                    <div class="invalid-feedback">Current electricity reading is required.</div>
                </td>
                <td>
                    <input id="previousElectricity" name="previous_electricity" type="number" class="form-control" required>
                    <div class="invalid-feedback">Previous electricity reading is required.</div>
                </td>
                <td>
                    <input id="consumptionElectricity" name="consumption_electricity" type="number" class="form-control" readonly required>
                </td>
                <td>
                    <input id="kwhElectricity" name="rate_per_kwh_electricity" type="number" step="0.01" class="form-control" required>
                    <div class="invalid-feedback">Rate per kWh is required.</div>
                </td>
                <td>
                    <input id="totalElectricity" name="total_electricity" type="number" step="0.01" class="form-control" readonly required>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Water -->
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
                <td>
                    <input id="currentWater" name="current_water" type="number" class="form-control" required>
                    <div class="invalid-feedback">Current water reading is required.</div>
                
                </td>
                <td>
                    <input id="previousWater" name="previous_water" type="number" class="form-control" required>
                    <div class="invalid-feedback">Previous water reading is required.</div>

                </td>
                <td>
                    <input id="consumptionWater" name="consumption_water" type="number" class="form-control" readonly>
                </td>
                <td>
                    <input id="cuWater" name="rate_per_cu_water" type="number" step="0.01" class="form-control" required>
                    <div class="invalid-feedback">Rate per CU Meter is required.</div>

                </td>
                <td>
                    <input id="totalWater" name="total_water" type="number" step="0.01" class="form-control" readonly>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="d-flex justify-content-end mt-3 mb-3 gap-2">
        <a href="{{ route('admin.huberts.units.management.page') }}" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-success">Save Billing</button>
    </div>
</form>
</div>

<script>
function calculateConsumption(currentId, previousId, outputId, rateId = null, totalId = null, mirrorToId = null) {
    const current = document.getElementById(currentId);
    const previous = document.getElementById(previousId);
    const output = document.getElementById(outputId);
    const rate = rateId ? document.getElementById(rateId) : null;
    const total = totalId ? document.getElementById(totalId) : null;
    const mirror = mirrorToId ? document.getElementById(mirrorToId) : null;

    function update() {
        const currentVal = parseFloat(current.value) || 0;
        const previousVal = parseFloat(previous.value) || 0;
        const consumption = currentVal - previousVal;
        const validConsumption = consumption >= 0 ? consumption : 0;
        output.value = validConsumption.toFixed(2);

        if (rate && total) {
            const rateVal = parseFloat(rate.value) || 0;
            const totalVal = validConsumption * rateVal;
            total.value = totalVal.toFixed(2);
            if (mirror) {
                mirror.value = total.value;
            }
        }

        calculateTotalBalance();
    }

    current.addEventListener('input', update);
    previous.addEventListener('input', update);
    if (rate) {
        rate.addEventListener('input', update);
    }
}


    calculateConsumption(
        'currentElectricity', 'previousElectricity', 'consumptionElectricity',
        'kwhElectricity', 'totalElectricity', 'billingElectricity'
    );

    calculateConsumption(
        'currentWater', 'previousWater', 'consumptionWater',
        'cuWater', 'totalWater', 'billingWater'
    );
</script>

<script>
    function calculateTotalBalance() {
        const rental = parseFloat(document.getElementById('rental').value) || 0;
        const water = parseFloat(document.getElementById('billingWater').value) || 0;
        const electricity = parseFloat(document.getElementById('billingElectricity').value) || 0;
        const parking = parseFloat(document.getElementById('parking').value) || 0;
        const foam = parseFloat(document.getElementById('foam').value) || 0;

        const total = rental + water + electricity + parking + foam;
        document.getElementById('totalBalance').value = total.toFixed(2);
    }

['rental', 'billingWater', 'billingElectricity', 'parking', 'foam', 'totalWater', 'totalElectricity'].forEach(id => {
    const el = document.getElementById(id);
    if (el) {
        el.addEventListener('input', calculateTotalBalance);
    }
});


    calculateTotalBalance();
</script>

<script>
    function generateSOANumber() {
        const randomDigits = Math.floor(1000000000 + Math.random() * 9000000000);
        const soaNumber = 'SOA-' + randomDigits;
        document.getElementById('soaNo').value = soaNumber;
    }

    window.addEventListener('DOMContentLoaded', function () {
        const soaField = document.getElementById('soaNo');
        if (!soaField.value) {
            generateSOANumber();
        }
    });
</script>

<script>
    (() => {
        'use strict';
        const form = document.querySelector('form');

        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    })();
</script>


</body>
</html>
