<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliverySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'base_fee_per_mile',
        'mid_fee_per_mile',
        'long_fee_per_mile',
    ];
}
