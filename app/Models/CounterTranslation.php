<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounterTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'counter_id',
        'language',
        'title',
        'quantity',
    ];
}
