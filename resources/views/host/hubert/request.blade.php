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
                    <th>Tenant ID</th>
                    <th>Unit ID</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Approval</th>
                </tr>
            </thead>
        <tbody>
        @forelse ($requests as $request)
            <tr>
                <td>{{ $request->tenant_name }}</td>
                <td>{{ $request->unit_name }}</td>
                <td>{{ $request->subject_request }}</td>
                <td>{{ $request->subject_message }}</td>
                <td>
                    @if ($request->status == 'Waiting to address by the host')
                        <form method="POST" action="{{ route('host.hubert.request.address', $request->id) }}" style="display:inline-block;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-success" name="action" value="addressed">Already Addressed</button>
                        </form>

                        <form method="POST" action="{{ route('host.hubert.request.delete', $request->id) }}" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" name="action" value="not_addressed" onclick="return confirm('Are you sure you want to delete this request?');">Not Addressed</button>
                        </form>
                    @else
                        <span class="badge bg-success">Already addressed</span>
                    @endif
                </td>
                <td>
                    @if($request->is_approved == 1 && $request->status === 'Already addressed')
                        <span class="badge bg-success">Already Addressed</span>
                    @elseif ($request->is_approved == 1)
                        <span class="badge bg-primary text-white">Approved by the admin</span>
                    @else
                        <span>-</span>
                    @endif
                </td>
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
