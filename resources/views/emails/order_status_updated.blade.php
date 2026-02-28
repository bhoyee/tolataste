<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Status Update</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .container {
            background: white;
            max-width: 600px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            padding: 30px;
        }

        .status-badge {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            border-radius: 24px;
            font-weight: bold;
            font-size: 14px;
            text-transform: capitalize;
        }

        .footer {
            font-size: 12px;
            color: #888;
            margin-top: 30px;
            text-align: center;
        }

        h1 {
            color: #222;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Hello {{ $customerName ?? 'Valued Customer' }},</h1>

        <p>We wanted to let you know that the status of your order <strong>#{{ $order->order_id }}</strong> has been updated.</p>

        <p>Your order is now:</p>
        <div class="status-badge">{{ ucwords(str_replace('_', ' ', $statusLabel)) }}</div>

        <!--<p style="margin-top: 20px;">-->
        <!--    You can rest assured that we’re working on your order and will notify you of any further updates.-->
        <!--</p>-->

        <p>
            If you have any questions or concerns, feel free to contact our support team.
        </p>

        <p style="margin-top: 40px;">
            Thank you for choosing {{ config('app.name') }}!
        </p>

        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>
</html>
