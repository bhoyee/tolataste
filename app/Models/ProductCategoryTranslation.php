<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategoryTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'language',
        'category_id',
        'name',
    ];
}
