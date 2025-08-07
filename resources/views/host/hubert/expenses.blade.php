<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="container my-5">
    <h3>Expenses</h3>
    <table class="table table-bordered table-striped">
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
                <th>Total</th>
                <th>Remarks</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenses as $expense)
                <tr>
                    <td>{{ $expense->date }}</td>
                    <td>{{ $expense->salaries }}</td>
                    <td>{{ $expense->labor_for_repair }}</td>
                    <td>{{ $expense->materials }}</td>
                    <td>{{ $expense->food }}</td>
                    <td>{{ $expense->taxes }}</td>
                    <td>{{ $expense->miscellaneous }}</td>
                    <td>{{ $expense->water_electricity }}</td>
                    <td>₱{{ number_format($expense->total, 2) }}</td>
                    <td>{{ $expense->remarks }}</td>
                    <td>
                        @if ($expense->is_approved)
                            <span class="badge bg-success">Approved</span>
                        @else
                            <form action="{{ route('host.hubert.expenses.approve', $expense->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Approve this expense?')">Approve</button>
                            </form>

                            <form action="{{ route('host.hubert.expenses.decline', $expense->id) }}" method="POST" style="display:inline-block;">
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
</body>
</html>