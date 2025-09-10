<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Interview Invitation</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f8; margin: 0; padding: 0;">
    <table align="center" width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: auto;">
        <!-- Header -->
        <tr>
            <td style="background-color: #2563eb; padding: 20px; text-align: center; color: white; border-radius: 8px 8px 0 0;">
                <h1 style="margin: 0; font-size: 22px;">{{ $namePerusahaan }}</h1>
                <p style="margin: 5px 0 0 0; font-size: 14px;">HR Recruitment Team</p>
            </td>
        </tr>

        <!-- Body -->
        <tr>
            <td style="background-color: #ffffff; padding: 25px; border: 1px solid #e5e7eb; border-top: none;">
                <h2 style="margin-top: 0; color: #111827; font-size: 20px;">Interview Invitation</h2>

                <p style="font-size: 15px; color: #374151;">Dear <strong>{{ $nameCandidate }}</strong>,</p>

                <p style="font-size: 15px; color: #374151; line-height: 1.6;">
                    Congratulations! 🎉 You have been shortlisted for an interview with
                    <strong>{{ $namePerusahaan }}</strong>.
                </p>

                <p style="font-size: 15px; color: #374151; line-height: 1.6;">
                    To proceed, please confirm whether you would like to
                    <strong>accept</strong> or <strong>decline</strong> this interview invitation
                    via our official platform.
                </p>

                <!-- Call to action -->
                <div style="text-align: center; margin: 30px 0;">
                    <a href=""
                       style="background-color: #16a34a; color: #ffffff; text-decoration: none; padding: 12px 20px; border-radius: 6px; font-size: 15px; display: inline-block; margin-right:10px;">
                        Accept Invitation
                    </a>
                    <a href=""
                       style="background-color: #dc2626; color: #ffffff; text-decoration: none; padding: 12px 20px; border-radius: 6px; font-size: 15px; display: inline-block;">
                        Decline Invitation
                    </a>
                </div>

                <p style="font-size: 14px; color: #6b7280; margin-top: 30px;">Best regards,</p>
                <p style="font-size: 14px; color: #111827; margin: 5px 0 0 0;"><strong>HR Recruitment</strong></p>
                <p style="font-size: 14px; color: #111827; margin: 0;">{{ $namePerusahaan }}</p>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="background-color: #f9fafb; padding: 15px; text-align: center; font-size: 12px; color: #6b7280; border-radius: 0 0 8px 8px;">
                © {{ date('Y') }} {{ $namePerusahaan }}. All rights reserved.
            </td>
        </tr>
    </table>
</body>
</html>
