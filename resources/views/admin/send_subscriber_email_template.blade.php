<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $subject ?? 'Newsletter' }}</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px;">
    <table style="max-width: 600px; margin: auto; background: #ffffff; padding: 30px; border-radius: 8px;">
        <tr>
            <td>
                {!! $template !!}
                <p style="margin-top: 30px;">Best regards,<br><strong>{{ config('app.name') }} Team</strong></p>
            </td>
        </tr>
    </table>
</body>
</html>
