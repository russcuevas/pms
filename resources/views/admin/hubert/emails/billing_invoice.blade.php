<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Billing Statement</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f4f4;">
    <div style="max-width: 600px; margin: 40px auto; background-color: #1e1e1e; padding: 30px; border-radius: 8px; color: #ffffff; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
        
        <h2 style="margin-top: 0; font-weight: 600; color: #f8c146;">Dear {{ $billing->fullname }},</h2>

        <p style="line-height: 1.6;">We are pleased to send your current <strong>e-billing</strong> with the following details:</p>

        <table style="width: 100%; margin-top: 20px; border-collapse: collapse; color: #e0e0e0;">
            <tr>
                <td style="padding: 8px 0;">📅 <strong>Invoice Date:</strong></td>
                <td style="text-align: right; color: #ffffff;">{{ \Carbon\Carbon::parse($billing->statement_date)->format('F d, Y') }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0;">🔢 <strong>Account Number:</strong></td>
                <td style="text-align: right;">{{ $billing->account_number }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0;">🏠 <strong>Unit Number:</strong></td>
                <td style="text-align: right;">{{ $billing->units_name }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0;">📅 <strong>Due Date:</strong></td>
                <td style="text-align: right; color: #f8c146;">{{ \Carbon\Carbon::parse($billing->due_date)->format('F d, Y') }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0;">📎 <strong>Previous Balance:</strong></td>
                <td style="text-align: right;">Php {{ number_format($billing->previous_balance ?? 0, 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 12px 0; font-size: 1.1em;"><strong>Total Amount Due:</strong></td>
                <td style="text-align: right; font-size: 1.1em; color: #ff4f4f;"><strong>Php {{ number_format($billing->total_balance_to_pay, 2) }}</strong></td>
            </tr>
        </table>

        <hr style="margin: 30px 0; border: 0; height: 1px; background-color: #444;">

        <p style="line-height: 1.6;">Thank you for your continued trust.</p>
        <p style="margin-top: 30px; font-weight: bold;">— Admin Hubert Residence</p>
    </div>
</body>
</html>
