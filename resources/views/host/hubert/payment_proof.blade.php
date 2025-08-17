<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment Proofs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h3 class="mb-3">Payment Proofs</h3>

        @if($paymentProofs->isEmpty())
            <div class="alert alert-info">No payment proofs found.</div>
        @else
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Unit</th>
                        <th>Proof</th>
                        <th>Uploaded At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paymentProofs as $index => $proof)
                        <tr>
                            <td>{{ $proof->fullname }}</td>
                            <td>{{ $proof->email }}</td>
                            <td>{{ $proof->phone_number }}</td>
                            <td>{{ $proof->unit }}</td>
                            <td>
                                @if($proof->payment_proof)
                                    <button class="btn btn-sm btn-primary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#proofModal{{ $proof->id }}">
                                        View Proof
                                    </button>

                                    <div class="modal fade" id="proofModal{{ $proof->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Payment Proof - {{ $proof->fullname }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    @php 
                                                        $filePath = asset('assets/huberts/proof_of_payment/'.$proof->payment_proof); 
                                                    @endphp

                                                    @if(Str::endsWith($proof->payment_proof, ['.jpg','.jpeg','.png','.gif','.webp']))
                                                        <img src="{{ $filePath }}" class="img-fluid rounded" alt="Payment Proof">
                                                    @elseif(Str::endsWith($proof->payment_proof, ['.pdf']))
                                                        <embed src="{{ $filePath }}" type="application/pdf" width="100%" height="600px">
                                                    @else
                                                        <a href="{{ $filePath }}" target="_blank" class="btn btn-success">Download File</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">No file</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($proof->created_at)->format('M d, Y h:i A') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
