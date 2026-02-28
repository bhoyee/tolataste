<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function orderAddress()
    {
        return $this->hasOne(OrderAddress::class);
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    // ✅ Add these methods for real-time refresh
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', now());
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
                     ->whereYear('created_at', now()->year);
    }

    public function scopeThisYear($query)
    {
        return $query->whereYear('created_at', now()->year);
    }
}
