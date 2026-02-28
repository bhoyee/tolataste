<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Order Notification</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 30px;">
    <div style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 6px; padding: 25px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        <h2 style="margin-top: 0; color: #333333;">📢 New Order Placed</h2>

        <p style="line-height: 1.6;">
            A new order has been placed by <strong>{{ $user->name }}</strong>.
        </p>

        <ul style="padding-left: 20px; line-height: 1.6; color: #444444;">
            <li><strong>Order ID:</strong> {{ $order->order_id }}</li>
            <li><strong>Total:</strong> ${{ number_format($order->grand_total, 2) }}</li>
            <li><strong>Payment:</strong> {{ $order->payment_method }} 
                @if(isset($payment_status)) ({{ $payment_status }}) @endif
            </li>
            <li><strong>Date:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, h:i A') }}</li>
        </ul>

        <p style="margin-top: 20px;">
            🔗 <a href="{{ url('/admin/all-order') }}" style="color: #007bff; text-decoration: none;">Login to the admin panel</a> to view full order details.
        </p>

        <hr style="margin: 30px 0; border: none; border-top: 1px solid #dddddd;">

        <p style="font-size: 12px; color: #999999;">This is an automated email from your website's order system.</p>
    </div>
</body>
</html>
