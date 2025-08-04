<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Management - Huberts</title>
    <!-- Toastr CSS CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body>
    <h1>Huberts Admin Management</h1>
    @include('host.hubert.left_sidebar')

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Username</th>
                <th>Full Name</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($admins as $admin)
                <tr>
                    <td>{{ $admin->username }}</td>
                    <td>{{ $admin->fullname }}</td>
                    <td>{{ $admin->phone_number }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>{{ $admin->address }}</td>
                    <td>
                        @if ($admin->is_approved == 0)
                            <form action="{{ route('host.hubert.update.admin.approval', $admin->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" name="action" value="approve">Approve</button>
                                <button type="submit" name="action" value="decline">Decline</button>
                            </form>
                        @else
                            <span>Approved</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No admins found for Huberts Residence.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- jQuery and Toastr JS CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Toastr Success Message -->
    <script>
        @if (session('success'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "3000"
            };
            toastr.success("{{ session('success') }}");
        @endif
    </script>
</body>
</html>
