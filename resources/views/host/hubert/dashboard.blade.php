<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hubert Host Dashboard</title>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background-color: #e9ecef;
        }

        .top-bar {
            background: #000;
            color: white;
            padding: 15px 30px;
            font-weight: bold;
        }

        .quick-actions .card {
            border: none;
            border-radius: 12px;
            transition: all 0.3s;
        }

        .quick-actions .card:hover {
            background-color: #f1f1f1;
            transform: translateY(-5px);
        }
    </style>
    <style>
/* Container styling for each chart */
.chart-container {
    background-color: #fff;
    border-radius: 10px;
    padding: 15px 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
    margin-bottom: 30px;
    transition: box-shadow 0.3s ease-in-out;
    height: 100%;
}

.chart-container:hover {
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

/* Chart title styling */
.chart-container h6 {
    font-weight: 600;
    font-size: 16px;
    margin-bottom: 15px;
    color: #333;
    text-align: center;
}

/* Canvas: make charts responsive */
canvas {
    width: 100% !important;
    height: auto !important;
}

/* Optional: match Bootstrap's column height if using cards or grid */
.row > .col-md-4 {
    display: flex;
    flex-direction: column;
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

    <!-- CONTENT SECTION -->
<div class="container my-4">
    <h5 class="mb-3">Actions</h5>
    <div class="row quick-actions g-3">
        <!-- Dashboard -->
        <div class="col-6 col-md-3">
            <a href="{{ route('host.huberts.dashboard.page') }}" style="text-decoration: none !important">
                <div class="card text-center p-4">
                    <i class="fas fa-chart-line fa-2x mb-2"></i>
                    <div>Dashboard</div>
                </div>
            </a>
        </div>

        <!-- Home -->
        <div class="col-6 col-md-3">
            <a href="{{ route('host.home.page') }}" style="text-decoration: none !important">
                <div class="card text-center p-4">
                    <i class="fas fa-home fa-2x mb-2"></i>
                    <div>Home</div>
                </div>
            </a>
        </div>

        <!-- Admin Management -->
        <div class="col-6 col-md-3">
            <a href="{{ route('host.huberts.admin.management.page') }}" style="text-decoration: none !important">
                <div class="card text-center p-4">
                    <i class="fas fa-user-cog fa-2x mb-2"></i>
                    <div>Admin Management</div>
                </div>
            </a>
        </div>

        <!-- Admin Requests -->
        <div class="col-6 col-md-3">
            <a href="{{ route('host.huberts.request_to_manager.page') }}" style="text-decoration: none !important">
                <div class="card text-center p-4">
                    <i class="fas fa-user-shield fa-2x mb-2"></i>
                    <div>Admin Requests</div>
                </div>
            </a>
        </div>

        <!-- Turnovers -->
        <div class="col-6 col-md-3">
            <a href="{{ route('host.huberts.turnover.page') }}" style="text-decoration: none !important">
                <div class="card text-center p-4">
                    <i class="fas fa-exchange-alt fa-2x mb-2"></i>
                    <div>Turnovers</div>
                </div>
            </a>
        </div>

        <!-- Billing -->
        <div class="col-6 col-md-3">
            <a href="{{ route('host.huberts.billing.page') }}" style="text-decoration: none !important">
                <div class="card text-center p-4">
                    <i class="fas fa-file-invoice fa-2x mb-2"></i>
                    <div>Billing</div>
                </div>
            </a>
        </div>

        <!-- Payments -->
        <div class="col-6 col-md-3">
            <a href="{{ route('host.huberts.payments.page') }}" style="text-decoration: none !important">
                <div class="card text-center p-4">
                    <i class="fas fa-wallet fa-2x mb-2"></i>
                    <div>Payments</div>
                </div>
            </a>
        </div>

        <!-- Expense Details -->
        <div class="col-6 col-md-3">
            <a href="{{ route('host.huberts.expenses.page') }}" style="text-decoration: none !important">
                <div class="card text-center p-4">
                    <i class="fas fa-receipt fa-2x mb-2"></i>
                    <div>Expense Details</div>
                </div>
            </a>
        </div>

        <!-- Announcements -->
        <div class="col-6 col-md-3">
            <a href="{{ route('host.huberts.announcement.page') }}" style="text-decoration: none !important">
                <div class="card text-center p-4">
                    <i class="fas fa-bullhorn fa-2x mb-2"></i>
                    <div>Announcements</div>
                </div>
            </a>
        </div>

        <!-- Requests -->
        <div class="col-6 col-md-3">
            <a href="{{ route('host.huberts.request.page') }}" style="text-decoration: none !important">
                <div class="card text-center p-4">
                    <i class="fas fa-inbox fa-2x mb-2"></i>
                    <div>Requests</div>
                </div>
            </a>
        </div>

        <!-- Payment Proof -->
        <div class="col-6 col-md-3">
            <a href="{{ route('host.hubert.paymemt.proof.page') }}" style="text-decoration: none !important">
                <div class="card text-center p-4">
                    <i class="fas fa-money-check fa-2x mb-2"></i>
                    <div>Payment Proof</div>
                </div>
            </a>
        </div>

        <!-- Balance -->
        <div class="col-6 col-md-3">
            <a href="{{ route('host.hubert.balance.page') }}" style="text-decoration: none !important">
                <div class="card text-center p-4">
                    <i class="fas fa-balance-scale fa-2x mb-2"></i>
                    <div>Balance</div>
                </div>
            </a>
        </div>
    </div>

    <div class="my-5">
    <h5>Financial Overview</h5>
    <div class="mb-3">
            <label for="yearSelect" class="form-label">Select Year:</label>
            <select id="yearSelect" class="form-select w-auto d-inline-block">
                <option value="2025">2025</option>
                <option value="2026">2026</option>
                <option value="2027">2027</option>
                <option value="2028">2028</option>
                <option value="2029">2029</option>
                <option value="2030">2030</option>
            </select>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-success h-100">
                    <div class="card-body">
                        <h5 class="card-title">Total Payment</h5>
                        <h2 id="totalPayment" class="card-text">₱0.00</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-white bg-success h-100">
                    <div class="card-body">
                        <h5 class="card-title">Cash Payment</h5>
                        <h2 id="cashPayment" class="card-text">₱0.00</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-white bg-success h-100">
                    <div class="card-body">
                        <h5 class="card-title">Online Payment</h5>
                        <h2 id="onlinePayment" class="card-text">₱0.00</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="chart-container">
                    <h6>Monthly Sales (₱)</h6>
                    <canvas id="monthlySalesChart"></canvas>
                </div>
            </div>
            <div class="col-md-4">
                <div class="chart-container">
                    <h6>Monthly Expenses (₱)</h6>
                    <canvas id="monthlyExpensesChart"></canvas>
                </div>
            </div>
            <div class="col-md-4">
                <div class="chart-container">
                    <h6>Monthly Net Income (₱)</h6>
                    <canvas id="monthlyNetIncomeChart"></canvas>
                </div>
            </div>
        </div>



    </div>
</div>





    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function () {
    const labels = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];

    const ctxSales = document.getElementById('monthlySalesChart').getContext('2d');
    const ctxExpenses = document.getElementById('monthlyExpensesChart').getContext('2d');
    const ctxNetIncome = document.getElementById('monthlyNetIncomeChart').getContext('2d');

    let monthlySalesChart;
    let monthlyExpensesChart;
    let monthlyNetIncomeChart;

    function createOrUpdateChart(chart, ctx, label, data, bgColor, borderColor) {
        if (chart) {
            chart.data.datasets[0].data = data;
            chart.update();
            return chart;
        } else {
            return new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: label,
                        data: data,
                        backgroundColor: bgColor,
                        borderColor: borderColor,
                        borderWidth: 1,
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '₱' + value.toLocaleString();
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return '₱' + context.raw.toLocaleString();
                                }
                            }
                        },
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }
    }

    function fetchAndRenderCharts(year) {
        // --- Sales ---
        $.ajax({
            url: "{{ route('host.huberts.monthly.sales') }}",
            method: 'GET',
            data: { year: year },
            success: function (response) {
                const salesData = new Array(12).fill(0);
                if (response.sales) {
                    response.sales.forEach(sale => {
                        const index = parseInt(sale.month_number, 10) - 1;
                        salesData[index] = parseFloat(sale.total);
                    });
                }

monthlySalesChart = createOrUpdateChart(
    monthlySalesChart,
    ctxSales,
    'Monthly Sales (₱)',
    salesData,
    'rgba(75, 192, 75, 0.6)',      // Green background
    'rgba(75, 192, 75, 1)'         // Green border
);
            },
            error: function () {
                alert('Failed to load sales data.');
            }
        });

        // --- Expenses ---
        $.ajax({
            url: "{{ route('host.huberts.monthly.expenses') }}",
            method: 'GET',
            data: { year: year },
            success: function (response) {
                const expensesData = new Array(12).fill(0);
                if (response.expenses) {
                    response.expenses.forEach(expense => {
                        const index = parseInt(expense.month_number, 10) - 1;
                        expensesData[index] = parseFloat(expense.total);
                    });
                }

                monthlyExpensesChart = createOrUpdateChart(
                    monthlyExpensesChart,
                    ctxExpenses,
                    'Monthly Expenses (₱)',
                    expensesData,
                    'rgba(255, 99, 132, 0.6)',     // Red background
                    'rgba(255, 99, 132, 1)'        // Red border
                );
            },
            error: function () {
                alert('Failed to load expenses data.');
            }
        });

        // --- Net Income ---
        $.ajax({
            url: "{{ route('host.huberts.monthly.net.income') }}",
            method: 'GET',
            data: { year: year },
            success: function (response) {
                const netIncomeData = new Array(12).fill(0);
                if (response.net_income) {
                    response.net_income.forEach(item => {
                        const index = parseInt(item.month_number, 10) - 1;
                        netIncomeData[index] = parseFloat(item.net_income);
                    });
                }

monthlyNetIncomeChart = createOrUpdateChart(
    monthlyNetIncomeChart,
    ctxNetIncome,
    'Monthly Net Income (₱)',
    netIncomeData,
    'rgba(135, 206, 235, 0.6)',    // Sky blue background
    'rgba(135, 206, 235, 1)'       // Sky blue border
);
            },
            error: function () {
                alert('Failed to load net income data.');
            }
        });
    }

    const initialYear = $('#yearSelect').val() || new Date().getFullYear();
    fetchAndRenderCharts(initialYear);

    $('#yearSelect').change(function () {
        const selectedYear = $(this).val();
        fetchAndRenderCharts(selectedYear);
    });
});
</script>

<script>
    // Function to fetch and update payment data
    function updatePaymentData(year) {
        fetch(`/host/hubert/payment-breakdown?year=${year}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('totalPayment').textContent = `₱${data.total_payment.toLocaleString()}`;
                document.getElementById('cashPayment').textContent = `₱${data.cash_payment.toLocaleString()}`;
                document.getElementById('onlinePayment').textContent = `₱${data.online_payment.toLocaleString()}`;
            })
            .catch(error => {
                console.error('Error fetching payment data:', error);
            });
    }

    // Event listener for year change
    document.getElementById('yearSelect').addEventListener('change', function () {
        updatePaymentData(this.value);
    });

    // Run on page load for the default selected year
    document.addEventListener('DOMContentLoaded', function () {
        const defaultYear = document.getElementById('yearSelect').value;
        updatePaymentData(defaultYear);
    });
</script>







    @if (session('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
    @endif
</body>
</html>
