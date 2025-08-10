<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Units Management</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <style>
    .swal2-html-container {
        text-align: center !important;
    }

    #transferUnit {
        display: block; 
        margin: 0 auto 1rem 0;
        width: auto;        
        min-width: 200px;   
        text-align: left; 
        float: left;      
    }

    .select-wrapper {
        text-align: left;
        margin: 0 auto 1rem auto;
        width: 220px;    
    }

    </style>
</head>
<body>
    <div class="container my-4">
        <h3 class="mb-4">UNITS MANAGEMENT</h3>

        <table id="unitsTable" class="table table-bordered table-striped align-middle">
        <thead class="table-secondary">
            <tr>
                <th>Unit Name</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <tr>
                <th><input type="text" placeholder="Search Unit Name" class="form-control form-control-sm" /></th>
                <th><input type="text" placeholder="Search Status" class="form-control form-control-sm" /></th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            @forelse ($units as $unit)
                <tr>
                    <td>{{ $unit->units_name }}</td>
                    <td>
                        @php
                            $badgeClass = match($unit->status) {
                                'occupied' => 'badge bg-info',
                                'vacant' => 'badge bg-primary',
                                'for repair' => 'badge bg-danger',
                                default => 'badge bg-secondary'
                            };
                        @endphp

                        <span class="{{ $badgeClass }}">{{ ucfirst($unit->status) }}</span>
                    </td>
                    <td>
                        @if ($unit->status === 'vacant')
                            <strong>NO TENANT ASSIGNED - </strong>
                            <button 
                                type="button" 
                                class="btn btn-warning btn-sm ms-2 btn-for-repair" 
                                data-unit-id="{{ $unit->unit_id }}" 
                                data-tenant-id="{{ $unit->tenant_id ?? '' }}" 
                                data-is-occupied="{{ $unit->status === 'occupied' ? 'true' : 'false' }}"
                                >
                                For Repair
                            </button>
                        @elseif ($unit->status === 'occupied')
                            <button 
                                type="button" 
                                class="btn btn-info btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#tenantModal-{{ $unit->unit_id }}"
                            >
                                View Tenant
                            </button>
                            <button 
                                type="button" 
                                class="btn btn-warning btn-sm ms-2 btn-for-repair" 
                                data-unit-id="{{ $unit->unit_id }}" 
                                data-tenant-id="{{ $unit->tenant_id ?? '' }}" 
                                data-is-occupied="{{ $unit->status === 'occupied' ? 'true' : 'false' }}"
                            >
                                For Repair
                            </button>

                        @elseif ($unit->status === 'for repair')
                        <button 
                            type="button" 
                            class="btn btn-success btn-sm btn-repaired" 
                            data-unit-id="{{ $unit->unit_id }}">
                            Repaired
                        </button>
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
                                                <span class="text-muted">NO AVAILABLE BILLING YET</span>
                                            @endif
                                        </dd>

                                        <dt class="col-sm-4">ADV & DEP:</dt>
                                        <dd class="col-sm-8">₱{{ number_format($unit->advance_deposit, 2) ?? 'N/A' }}</dd>

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

                                    <dl class="row">
                                        <h5>PERSON TO CONTACT</h5>

                                        <dt class="col-sm-4">Fullname:</dt>
                                        <dd class="col-sm-8">{{ $unit->contact_fullname }}</dd>

                                        <dt class="col-sm-4">Phone number:</dt>
                                        <dd class="col-sm-8">{{ $unit->contact_phone_number }}</dd>
                                    </dl>

                                </div>
                                <div class="modal-footer">
                                    @if ($unit->billing_status === 'paid')
                                        <form method="POST" action="{{ route('admin.units.moveout', [$unit->unit_id, $unit->tenant_id]) }}" class="moveout-form" data-unit-id="{{ $unit->unit_id }}" data-tenant-id="{{ $unit->tenant_id }}">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Move out</button>
                                        </form>
                                    @endif
                                    <a href="{{ route('admin.hubert.billing.page', ['unit_id' => $unit->unit_id, 'tenant_id' => $unit->tenant_id]) }}" class="btn btn-info">
                                        Create Billing
                                    </a>
                                    <a href="{{ route('admin.hubert.payments.page', ['unit_id' => $unit->unit_id, 'tenant_id' => $unit->tenant_id]) }}" class="btn btn-success">
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

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        @if (session('success'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut": "3000",
                "positionClass": "toast-top-right"
            };
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut": "3000",
                "positionClass": "toast-top-right"
            };
            toastr.error("{{ session('error') }}");
        @endif
    </script>

    <script>
    document.querySelectorAll('.btn-for-repair').forEach(button => {
        button.addEventListener('click', function() {
            const unitId = this.dataset.unitId;
            const tenantId = this.dataset.tenantId;
            const isOccupied = this.dataset.isOccupied === 'true';
            const vacantUnits = @json($vacantUnits);

            if (isOccupied) {
                let optionsHtml = '<select id="transferUnit" class="swal2-select form-select">';
                optionsHtml += '<option value="" selected disabled>Select vacant unit</option>';
                vacantUnits.forEach(unit => {
                    optionsHtml += `<option value="${unit.id}">${unit.units_name}</option>`;
                });
                optionsHtml += '</select>';

                Swal.fire({
                    title: 'Transfer Tenant',
                    html: `
                        <p>This unit is occupied. Please select a vacant unit to transfer the tenant before marking for repair.</p>
                        <div class="select-wrapper">
                            <select id="transferUnit" class="swal2-select form-select">
                                <option value="" selected disabled>Select vacant unit</option>
                                ${vacantUnits.map(unit => `<option value="${unit.id}">${unit.units_name}</option>`).join('')}
                            </select>
                        </div>
                    `,

                    showCancelButton: true,
                    confirmButtonText: 'Transfer & Repair',
                    preConfirm: () => {
                        const transferUnitId = Swal.getPopup().querySelector('#transferUnit').value;
                        if (!transferUnitId) {
                            Swal.showValidationMessage('Please select a vacant unit');
                        }
                        return transferUnitId;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const transferUnitId = result.value;
                        // Send AJAX request to transfer tenant and mark unit for repair
                        fetch('/admin/huberts/units/transfer-and-repair', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                current_unit_id: unitId,
                                tenant_id: tenantId,
                                transfer_unit_id: transferUnitId
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if(data.success) {
                                Swal.fire('Success', data.message, 'success').then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error', data.message || 'Something went wrong', 'error');
                            }
                        })
                        .catch(() => {
                            Swal.fire('Error', 'Request failed', 'error');
                        });
                    }
                });
            } else {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Are you sure you want to mark this unit for repair?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, mark for repair',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('/admin/huberts/units/mark-for-repair', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ unit_id: unitId })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Success', data.message, 'success').then(() => location.reload());
                            } else {
                                Swal.fire('Error', data.message || 'Something went wrong', 'error');
                            }
                        })
                        .catch(() => {
                            Swal.fire('Error', 'Request failed', 'error');
                        });
                    }
                });
            }
        });
    });
    </script>

    <script>
    document.querySelectorAll('.btn-repaired').forEach(button => {
        button.addEventListener('click', function () {
            const unitId = this.dataset.unitId;

            Swal.fire({
                title: 'Mark as Repaired?',
                text: "This will change the unit's status to 'vacant'.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, mark as repaired',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/admin/huberts/units/mark-as-repaired', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ unit_id: unitId })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Success', data.message, 'success').then(() => location.reload());
                        } else {
                            Swal.fire('Error', data.message || 'Something went wrong', 'error');
                        }
                    })
                    .catch(() => {
                        Swal.fire('Error', 'Request failed', 'error');
                    });
                }
            });
        });
    });
    </script>

    <script>
        $(document).ready(function () {
            var table = $('#unitsTable').DataTable({
                responsive: true,
                pageLength: 10,
                orderCellsTop: true,
                fixedHeader: true,
                columnDefs: [
                    { orderable: false, targets: 2 }
                ]
            });

            $('#unitsTable thead tr:eq(1) th').each(function (i) {
                $('input', this).on('keyup change', function () {
                    if (table.column(i).search() !== this.value) {
                        table.column(i).search(this.value).draw();
                    }
                });
            });
        });
    </script>

    <script>
        document.querySelectorAll('.moveout-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to move out this tenant',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, move out',
                    cancelButtonText: 'Cancel',
                }).then(result => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    </script>


</body>
</html>
