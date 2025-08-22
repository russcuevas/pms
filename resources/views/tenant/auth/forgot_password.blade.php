<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Password Reset</title>
</head>
<body>
    <p>Hello {{ $tenant->fullname }},</p>

    <p>You requested a password reset for your account.</p>

    <p>
        Click the button below to reset your password:
    </p>

    <p>
        <a href="{{ $resetLink }}" style="padding: 10px 20px; background-color: #68d391; color: white; text-decoration: none; border-radius: 5px;">
            Reset Password
        </a>
    </p>

    <p>If you didn’t request this, please ignore this email.</p>

    <p>Thanks,<br>AVA Tenants Portal</p>
</body>
</html>
