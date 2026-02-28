<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Testimonial extends Model
{
    use HasFactory;

    public function getNameTranslatedAttribute()
    {
        if ($this->translation?->name) {
            return $this->translation->name;
        }
        return $this->name;
    }

    public function getDesignationTranslatedAttribute()
    {
        if ($this->translation?->designation) {
            return $this->translation->designation;
        }
        return $this->designation;
    }

    public function getCommentTranslatedAttribute()
    {
        if ($this->translation?->comment) {
            return $this->translation->comment;
        }
        return $this->comment;
    }

    public function translation($language = null)
    {
        if ($language == null) {
            $language = getSessionLanguage();
        }

        return $this->hasOne(TestimonialTranslation::class, 'testimonial_id', 'id')->where('language', '=', $language);
    }

    public function translations()
    {
        return $this->hasMany(TestimonialTranslation::class);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $defaultTranslation = TestimonialTranslation::firstOrCreate([
                'language' => config('app.locale'),
                'testimonial_id' => $model->id,
            ]);

            $defaultTranslation->name = $model->name;
            $defaultTranslation->designation = $model->designation;
            $defaultTranslation->comment = $model->comment;
            $defaultTranslation->save();
        });

        static::updated(function ($model) {
            $defaultTranslation = TestimonialTranslation::firstOrCreate([
                'language' => config('app.locale'),
                'testimonial_id' => $model->id,
            ]);
            $defaultTranslation->name = $model->name;
            $defaultTranslation->designation = $model->designation;
            $defaultTranslation->comment = $model->comment;
            $defaultTranslation->save();
        });

        static::deleted(function ($model) {
            if ($model->translations) {
                $model->translations()->delete();
            }
        });
    }
}
