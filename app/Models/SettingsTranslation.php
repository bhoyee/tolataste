<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'setting_id',
        'language',
        'app_name',
        'currency_name',
        'app_title',
        'app_description',
    ];
}
