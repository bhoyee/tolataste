<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $table = 'galleries'; // Ensures Laravel uses the correct table
    protected $fillable = ['image_path']; // Allows mass assignment of image_path
}
