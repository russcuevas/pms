<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Page</title>
    <style>
        table {
            width: 80%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #444;
            padding: 8px 12px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        a.button {
            padding: 5px 10px;
            margin: 0 2px;
            background-color: #ddd;
            text-decoration: none;
            border-radius: 4px;
        }
        a.button.view { background-color: #007bff; color: white; }
        a.button.approve { background-color: #28a745; color: white; }
        a.button.decline { background-color: #dc3545; color: white; }
    </style>
</head>
<body>
    <h1>Billing Page</h1>
    <a href="{{ route('host.logout.request') }}">Logout</a>
    <a href="{{ route('host.home.page') }}">Home</a><br>
    <a href="{{ route('host.huberts.dashboard.page') }}">Dashboard</a><br>
    <a href="">Admin Management</a><br>
    <a href="">Admin Requests</a><br>
    <a href="{{ route('host.huberts.billing.page') }}">Billing</a><br>
    <a href="">Payments</a><br>
    <a href="">Expense Details</a><br>
    <a href="">Announcements</a><br>
    <a href="">Requests</a><br>

    <h2>Units for Property ID 1:</h2>

    <table>
        <thead>
            <tr>
                <th>Unit Name</th>
                <th>Property</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($units as $unit)
                <tr>
                    <td>{{ $unit->units_name }}</td>
                    <td>{{ $unit->property_name }}</td>
                    <td>{{ ucfirst($unit->status) }}</td>
                    <td>
                        <a href="" class="button view">View</a>
                        <a href="" class="button approve">Approve</a>
                        <a href="" class="button decline">Decline</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
