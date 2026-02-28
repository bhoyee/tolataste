<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <h2>Order Confirmation - #{{ $order->order_id }}</h2>
    <p>Hi {{ $user->name }},</p>

    <p>Thank you for your order! We have received it and will process it shortly.</p>

    <p><strong>Order Details:</strong></p>
    <ul>
        <li>Total: ${{ number_format($order->grand_total, 2) }}</li>
        <li>Payment Method: Stripe</li>
        <li>Order Date: {{ \Carbon\Carbon::parse($order->created_at)->toDayDateTimeString() }}</li>
    </ul>

    <p>We'll notify you when your order is out for delivery or ready for pickup.</p>

    <p>Thanks again!<br>The Tola Taste of Africa Team</p>
</body>
</html>
