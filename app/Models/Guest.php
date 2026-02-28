<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
    ];

    // Optional: if guests can have orders later
    // public function orders()
    // {
    //     return $this->hasMany(Order::class);
    // }
    
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class)->select(['id', 'guest_id']); // Limit fields!
    }
}
