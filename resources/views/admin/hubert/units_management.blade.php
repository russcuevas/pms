<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Units Management</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container my-4">
        <h1 class="mb-4">Units Management Page</h1>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>Unit Name</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($units as $unit)
                <tr>
                    <td>{{ $unit->units_name }}</td>
                    <td>{{ ucfirst($unit->status) }}</td>
                    <td>
                        @if ($unit->status === 'vacant')
                            <span class="text-muted">No assigned tenant</span>
                            <button type="button" class="btn btn-warning btn-sm ms-2">For Repair</button>

                        @elseif ($unit->status === 'occupied')
                            <button 
                                type="button" 
                                class="btn btn-primary btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#tenantModal-{{ $unit->unit_id }}"
                            >
                                View Tenant
                            </button>
                            <button type="button" class="btn btn-warning btn-sm ms-2">For Repair</button>

                        @elseif ($unit->status === 'for repair')
                            <button type="button" class="btn btn-success btn-sm">Repaired</button>

                        @else
                            <span class="text-muted">Unknown status</span>
                        @endif
                    </td>
                </tr>

                {{-- Render modal for each tenant assigned --}}
                @if ($unit->status === 'occupied')
                    <div class="modal fade" id="tenantModal-{{ $unit->unit_id }}" tabindex="-1" aria-labelledby="tenantModalLabel-{{ $unit->unit_id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="tenantModalLabel-{{ $unit->unit_id }}">Tenant Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <dl class="row">
                                        <dt class="col-sm-4">Balance:</dt>
                                        <dd class="col-sm-8">
                                            @if (!is_null($unit->current_balance))
                                                ₱{{ number_format($unit->current_balance, 2) }}
                                            @else
                                                <span class="text-muted">No billing yet</span>
                                            @endif
                                        </dd>

                                        <dt class="col-sm-4">Full Name:</dt>
                                        <dd class="col-sm-8">{{ $unit->fullname ?? 'N/A' }}</dd>

                                        <dt class="col-sm-4">Username:</dt>
                                        <dd class="col-sm-8">{{ $unit->username ?? 'N/A' }}</dd>

                                        <dt class="col-sm-4">Email:</dt>
                                        <dd class="col-sm-8">{{ $unit->email ?? 'N/A' }}</dd>

                                        <dt class="col-sm-4">Phone Number:</dt>
                                        <dd class="col-sm-8">{{ $unit->phone_number ?? 'N/A' }}</dd>

                                        <dt class="col-sm-4">Address:</dt>
                                        <dd class="col-sm-8">{{ $unit->address ?? 'N/A' }}</dd>

                                        <dt class="col-sm-4">Move-in Date:</dt>
                                        <dd class="col-sm-8">{{ $unit->move_in_date ?? 'N/A' }}</dd>

                                        <dt class="col-sm-4">Move-out Date:</dt>
                                        <dd class="col-sm-8">{{ $unit->move_out_date ?? 'N/A' }}</dd>

                                    </dl>
                                </div>
                                <div class="modal-footer">
                                    <form action="">
                                        <button type="button" class="btn btn-danger">Move out</button>
                                    </form>
                                    <a href="{{ route('admin.hubert.billing.page', ['unit_id' => $unit->unit_id, 'tenant_id' => $unit->tenant_id]) }}" class="btn btn-info">
                                        Create Billing
                                    </a>
                                    <a href="{{ route('admin.hubert.payments.page', ['unit_id' => $unit->unit_id, 'tenant_id' => $unit->tenant_id]) }}" class="btn btn-info">
                                        Create Payment
                                    </a>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <tr>
                    <td colspan="3" class="text-center">No units found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    </div>

    <!-- Bootstrap JS Bundle CDN (optional, for dropdowns etc) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
