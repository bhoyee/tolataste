<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermsAndConditionTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'language',
        'terms_and_condition_id',
        'terms_and_condition',
        'privacy_policy',
    ];
}
