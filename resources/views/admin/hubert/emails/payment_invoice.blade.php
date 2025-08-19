<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payment Confirmation</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f4f4;">
    <div style="max-width: 600px; margin: 40px auto; background-color: #1e1e1e; padding: 30px; border-radius: 8px; color: #ffffff; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">

        <h2 style="margin-top: 0; font-weight: 600; color: #4caf50;">
            {{ $payment->mode_of_payment === 'cash' ? 'Payment Received' : 'Payment Request Submitted' }}
        </h2>

        <p style="line-height: 1.6;">Dear <strong>{{ $payment->fullname }}</strong>,</p>

        <p style="line-height: 1.6;">
            We have {{ $payment->mode_of_payment === 'cash' ? 'received' : 'recorded your request for' }} your payment with the following details:
        </p>

        <table style="width: 100%; margin-top: 20px; border-collapse: collapse; color: #e0e0e0;">
            <tr>
                <td style="padding: 8px 0;">🏠 <strong>Unit Number:</strong></td>
                <td style="text-align: right;">{{ $payment->units_name }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0;">💰 <strong>Amount:</strong></td>
                <td style="text-align: right; color: #f8c146;">Php {{ number_format($payment->amount, 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0;">📅 <strong>For the Month of:</strong></td>
                <td style="text-align: right;">{{ $payment->for_the_month_of }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0;">📎 <strong>Reference Number:</strong></td>
                <td style="text-align: right;">{{ $payment->reference_number }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0;">💳 <strong>Mode of Payment:</strong></td>
                <td style="text-align: right;">{{ ucfirst($payment->mode_of_payment) }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0;">📄 <strong>Type:</strong></td>
                <td style="text-align: right;">{{ ucfirst($payment->type) }}</td>
            </tr>
        </table>

        <hr style="margin: 30px 0; border: 0; height: 1px; background-color: #444;">

        <p style="line-height: 1.6;">
            @if ($payment->mode_of_payment === 'cash')
                Thank you for your payment. It has been successfully recorded.
            @else
                Please wait while we review and approve your online payment.
            @endif
        </p>

        <p style="margin-top: 30px; font-weight: bold;">— Admin Hubert Residence</p>
    </div>
</body>
</html>
