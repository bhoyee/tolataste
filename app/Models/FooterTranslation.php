<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'footer_id',
        'language',
        'about_us',
        'address',
        'copyright',
    ];
}
