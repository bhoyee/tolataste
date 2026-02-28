<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CateringRequest extends Model
{
    protected $fillable = [
        'full_name', 'email', 'phone', 'delivery_address', 'occasion', 'event_date',
        'catering_type', 'event_start_time', 'dropoff_time', 'guest_count', 'menu_items'
    ];
}