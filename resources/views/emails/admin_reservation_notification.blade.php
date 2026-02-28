<h2>New Reservation Received</h2>

<p><strong>Date:</strong> {{ $reservation->reserve_date }}</p>
<p><strong>Time:</strong> {{ $reservation->reserve_time }}</p>
<p><strong>Number of People:</strong> {{ $reservation->person_qty }}</p>

@if($reservation->user_id == 0)
    <p><strong>Guest Name:</strong> {{ $reservation->guest_name }}</p>
    <p><strong>Email:</strong> {{ $reservation->guest_email ?? 'N/A' }}</p>
    <p><strong>Phone:</strong> {{ $reservation->guest_phone }}</p>
@else
    <p><strong>Customer ID:</strong> {{ $reservation->user_id }}</p>
    <p><strong>Phone:</strong> {{ $reservation->user->phone ?? 'N/A' }}</p>
@endif
