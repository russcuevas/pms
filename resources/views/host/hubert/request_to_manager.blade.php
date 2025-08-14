<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Host Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light p-4">
    <div class="container">
        <h2 class="mb-4">Requests</h2>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Approval</th>
                </tr>
            </thead>
            <tbody>
    @forelse ($request_to_managers as $request)
        <tr>
            <td>{{ $request->admin_name }}</td>
            <td>{{ $request->request_subject }}</td>
            <td>{{ $request->request_message }}</td>
            <td>
                @if ($request->is_approved)
                    <span class="badge bg-success">Approved</span>
                @else
                    <span class="badge bg-warning text-dark">Pending</span>
                @endif
            </td>
            <td>
                @if (!$request->is_approved)
                    <form action="{{ route('host.hubert.request_to_manager.approve', $request->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-success">Approve</button>
                    </form>
                    <form action="{{ route('host.hubert.request_to_manager.decline', $request->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Decline</button>
                    </form>
                @else
                    <form action="{{ route('host.hubert.request_to_manager.delete', $request->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this request?')">
                            Delete
                        </button>
                    </form>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center text-muted">No requests found.</td>
        </tr>
    @endforelse
</tbody>



        </table>
    </div>
</body>
</html>
