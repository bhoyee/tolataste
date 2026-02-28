<h2>New Catering Request</h2>
<p><strong>Name:</strong> {{ $catering->full_name }}</p>
<p><strong>Email:</strong> {{ $catering->email }}</p>
<p><strong>Phone:</strong> {{ $catering->phone }}</p>
<p><strong>Occasion:</strong> {{ $catering->occasion ?? 'N/A' }}</p>
<p><strong>Date:</strong> {{ $catering->event_date }}</p>
<p><strong>Catering Type:</strong> {{ $catering->catering_type }}</p>
<p><strong>Guests:</strong> {{ $catering->guest_count }}</p>
<p><strong>Delivery Address:</strong> {{ $catering->delivery_address }}</p>
<p><strong>Event Start:</strong> {{ $catering->event_start_time ?? 'N/A' }}</p>
<p><strong>Dropoff Time:</strong> {{ $catering->dropoff_time ?? 'N/A' }}</p>
<p><strong>Menu:</strong></p>
<p>{!! nl2br(e($catering->menu_items)) !!}</p>
