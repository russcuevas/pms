<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Property Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
    <div class="container">
        <h2 class="mb-4">Requests</h2>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Tenant</th>
                    <th>Unit</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>For Approval</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($requests as $request)
                    <tr>
                        <td>{{ $request->tenant_name }}</td>
                        <td>{{ $request->unit_name }}</td>
                        <td>{{ $request->subject_request }}</td>
                        <td>{{ $request->subject_message }}</td>
                        <td>{{ $request->status }}</td>
                        <td>
                            @if (!$request->is_approved)
                                <form action="{{ route('admin.hubert.request.approve', $request->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-success btn-sm" onclick="return confirm('Approve this request?')">Approve</button>
                                </form>

                                <form action="{{ route('admin.hubert.request.decline', $request->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to decline this request?')">Decline</button>
                                </form>
                            @else
                                <span class="badge bg-success">Approved</span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($request->created_at)->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No requests found.</td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>
</body>
</html>
