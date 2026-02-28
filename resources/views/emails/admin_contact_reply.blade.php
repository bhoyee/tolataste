<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reply to Your Message</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <table width="100%" style="max-width: 600px; margin: auto; background: #ffffff; border-radius: 8px; padding: 20px;">
        <tr>
            <td>
                <h2 style="color: #333;">Hello {{ $name }},</h2>

                <p style="color: #555;">Thank you for contacting us. Please see our response to your message below:</p>

                <h4 style="color: #333; margin-top: 30px;">Your Original Message:</h4>
                <div style="background-color: #f1f1f1; padding: 15px; border-left: 4px solid #ffc107; margin-bottom: 30px;">
                    {!! nl2br(e($userMessage)) !!}
                </div>

                <h4 style="color: #333;">Our Reply:</h4>
                <blockquote style="background-color: #f9f9f9; padding: 15px; border-left: 4px solid #007bff;">
                    {!! $replyMessage !!}
                </blockquote>

                <p style="color: #555;">If you have any further questions, feel free to get in touch.</p>

                <p style="margin-top: 30px;">Best regards,<br>
                <strong>{{ config('app.name') }} Team</strong></p>
            </td>
        </tr>
    </table>
</body>
</html>
