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
        <!-- Heading + Button Row -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Announcement</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAnnouncementModal">
                Add Announcement
            </button>
        </div>

        <!-- Table -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($announcements as $announcement)
                    <tr>
                        <td>{{ $announcement->announcement_subject }}</td>
                        <td>{{ $announcement->announcement_message }}</td>
                        <td>
                            @if ($announcement->is_approved == 0)
                                <span>Pending</span>
                            @else
                                <span>Approved</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addAnnouncementModal" tabindex="-1" aria-labelledby="addAnnouncementLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.hubert.announcement.request') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAnnouncementLabel">Add Announcement</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Announcement Subject</label>
                            <input type="text" class="form-control" name="announcement_subject" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Announcement Message</label>
                            <textarea class="form-control" name="announcement_message" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Announcement</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
