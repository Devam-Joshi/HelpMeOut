<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Reset OTP</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f4f4f4; padding:0; margin:0;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background:#f4f4f4; padding:40px 0;">
        <tr>
            <td align="center">
                <table width="500" style="background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
                    <tr>
                        <td style="background:#2d6cdf; padding:20px; color:#fff; font-size:20px; font-weight:bold; text-align:center;">
                            {{ config('app.name') }} - Password Verification
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:25px; font-size:15px; color:#333;">
                            <p>Hello <strong>{{ $name }}</strong>,</p>
                            <p>You requested to reset your password. Use the OTP given below to proceed:</p>

                            <p style="font-size:32px; font-weight:bold; text-align:center; margin:25px 0; color:#2d6cdf;">
                                {{ $otp }}
                            </p>

                            <p style="font-size:14px; color:#777;">
                                This OTP is valid for <strong>10 minutes</strong>. Do not share this with anyone.
                            </p>

                            <p>If you didn't request this, please ignore this email.</p>

                            <br>
                            <p>Regards,<br><strong>{{ config('app.name') }}</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#f1f1f1; padding:15px; text-align:center; font-size:12px; color:#777;">
                            © {{ date('Y') }} {{ config('app.name') }} • All Rights Reserved
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
