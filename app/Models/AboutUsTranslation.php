<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUsTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'language',
        'about_us_id',
        'about_us',
        'video_title',
        'about_us_short_title',
        'about_us_long_title',
        'why_choose_us_short_title',
        'why_choose_us_long_title',
        'why_choose_us_description',
        'title_one',
        'title_two',
        'title_three',
        'title_four',
    ];
}
