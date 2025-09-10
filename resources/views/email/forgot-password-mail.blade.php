<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f8; margin: 0; padding: 0;">
    <table align="center" width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: auto;">
        <!-- Header -->
        <tr>
            <td style="background-color: #2563eb; padding: 20px; text-align: center; color: white; border-radius: 8px 8px 0 0;">
                <h1 style="margin: 0; font-size: 22px;">{{ config('app.name') }}</h1>
                <p style="margin: 5px 0 0 0; font-size: 14px;">Reset Password Request</p>
            </td>
        </tr>

        <!-- Body -->
        <tr>
            <td style="background-color: #ffffff; padding: 25px; border: 1px solid #e5e7eb; border-top: none;">
                <h2 style="margin-top: 0; color: #111827; font-size: 20px;">Hello, {{ $name }}</h2>

                <p style="font-size: 15px; color: #374151; line-height: 1.6;">
                    You recently requested to reset your password for your account.
                    Click the button below to reset it. If you did not request a password reset, please ignore this email.
                </p>

                <!-- Call to action -->
                <div style="text-align: center; margin: 30px 0;">
                    <a href="{{ config('app.frontend_url') }}/reset-password?token={{ $token }}&email={{ $email }}"
                       style="background-color: #2563eb; color: #ffffff; text-decoration: none; padding: 12px 25px; border-radius: 6px; font-size: 15px; display: inline-block;">
                        Reset Password
                    </a>
                </div>

                <p style="font-size: 14px; color: #6b7280; margin-top: 20px;">
                    This password reset link will expire in 60 minutes.
                </p>

                <p style="font-size: 14px; color: #6b7280; margin-top: 30px;">
                    Best regards,<br>
                    <strong>{{ config('app.name') }} Team</strong>
                </p>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="background-color: #f9fafb; padding: 15px; text-align: center; font-size: 12px; color: #6b7280; border-radius: 0 0 8px 8px;">
                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </td>
        </tr>
    </table>
</body>
</html>
