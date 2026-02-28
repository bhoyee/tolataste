<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomepageTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'homepage_id',
        'language',
        'today_special_short_title',
        'today_special_long_title',
        'today_special_description',
        'menu_short_title',
        'menu_long_title',
        'menu_description',
        'chef_short_title',
        'chef_long_title',
        'chef_description',
        'testimonial_short_title',
        'testimonial_long_title',
        'testimonial_description',
        'blog_short_title',
        'blog_long_title',
        'blog_description',
    ];
}
