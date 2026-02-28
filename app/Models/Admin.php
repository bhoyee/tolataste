<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'forget_password_token',
        'image',
        'status',
        'admin_type',
        'slug',
        'about_us',
        'fcm_token',        // ✅ add this
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'tokens',
        'pivot',
        'notifications',
        // (Optionally) 'fcm_token', // hide it from general API responses if you don't want to expose it
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // (Your custom toArray() override is fine; not required for FCM)
    public function toArray()
    {
        $attributes = parent::toArray();
        unset($attributes['notifications']);
        return $attributes;
    }
}
