<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerImageTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'banner_image_id',
        'language',
        'title',
        'description',
    ];
}
