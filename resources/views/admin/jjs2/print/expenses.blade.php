<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Expenses Report - Printable</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <style>
        * {
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background: #fff;
            color: #000;
            margin: 0;
            padding: 30px;
        }

        .report-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .report-header h2 {
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f8f9fa;
        }

        tfoot tr td {
            font-weight: bold;
            background-color: #f1f1f1;
        }

        @media print {
            @page {
                margin: 15mm 10mm;
            }

            body {
                padding: 0;
                margin: 0;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body onload="window.print();">

    <div class="report-header">
        <h2>JJS2 Bldg</h2>
        <h4>Expenses Report</h4>
        <p><strong>Date Printed:</strong> {{ now()->format('F d, Y - h:i A') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Salaries</th>
                <th>Labor</th>
                <th>Materials</th>
                <th>Food</th>
                <th>Taxes</th>
                <th>Misc</th>
                <th>Utilities</th>
                <th>Refund</th>
                <th>Office</th>
                <th>Total</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @php
                $grand_total = 0;
            @endphp

            @foreach($expenses as $expense)
                @php
                    $grand_total += $expense->total;
                @endphp
                <tr>
                    <td>{{ \Carbon\Carbon::parse($expense->date)->format('Y-m-d') }}</td>
                    <td>₱{{ number_format($expense->salaries, 2) }}</td>
                    <td>₱{{ number_format($expense->labor_for_repair, 2) }}</td>
                    <td>₱{{ number_format($expense->materials, 2) }}</td>
                    <td>₱{{ number_format($expense->food, 2) }}</td>
                    <td>₱{{ number_format($expense->taxes, 2) }}</td>
                    <td>₱{{ number_format($expense->miscellaneous, 2) }}</td>
                    <td>₱{{ number_format($expense->water_electricity, 2) }}</td>
                    <td>₱{{ number_format($expense->refund, 2) }}</td>
                    <td>₱{{ number_format($expense->office_supplies, 2) }}</td>
                    <td><strong>₱{{ number_format($expense->total, 2) }}</strong></td>
                    <td>{{ $expense->remarks }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="10" style="text-align: right;">Grand Total</td>
                <td colspan="2"><strong>₱{{ number_format($grand_total, 2) }}</strong></td>
            </tr>
        </tfoot>
    </table>

</body>
</html>
