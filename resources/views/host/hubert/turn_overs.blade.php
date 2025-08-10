<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hubert Turnovers</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #aaa;
            padding: 8px 12px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        .status-received {
            color: green;
            font-weight: bold;
        }

        .status-declined {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Hubert Turnovers</h1>

    @include('host.hubert.left_sidebar')

    <h2>Turnover Records</h2>

    @if($turnOvers->isEmpty())
        <p>No turnover records found</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Admin Fullname</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date Requested</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($turnOvers as $index => $turnOver)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $turnOver->admin_fullname }}</td>
                        <td>PHP {{ number_format($turnOver->turn_over_money, 2) }}</td>
                            <td>
                                @if ($turnOver->is_approved)
                                    <span class="status-received">Received</span>
                                @else
                                    <form action="{{ route('host.huberts.turnovers.approve', $turnOver->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" style="color:green;">Received</button>
                                    </form>

                                    <form action="{{ route('host.huberts.turnovers.decline', $turnOver->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to decline this turnover?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="color:red;">Decline</button>
                                    </form>
                                @endif
                            </td>
                        <td>{{ \Carbon\Carbon::parse($turnOver->created_at)->format('M d, Y h:i A') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
