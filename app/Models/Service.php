<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Service extends Model
{
    use HasFactory;

    public function getTitleTranslatedAttribute()
    {
        if ($this->translation?->title) {
            return $this->translation->title;
        }
        return $this->title;
    }

    public function getDescriptionTranslatedAttribute()
    {
        if ($this->translation?->description) {
            return $this->translation->description;
        }
        return $this->description;
    }

    public function translation($language = null)
    {
        if ($language == null) {
            $language = getSessionLanguage();
        }

        return $this->hasOne(ServiceTranslation::class, 'service_id', 'id')->where('language', '=', $language);
    }

    public function translations()
    {
        return $this->hasMany(ServiceTranslation::class);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $defaultTranslation = ServiceTranslation::firstOrCreate([
                'language' => config('app.locale'),
                'service_id' => $model->id,
            ]);
            $defaultTranslation->title = $model->title;
            $defaultTranslation->description = $model->description;
            $defaultTranslation->save();
        });

        static::updated(function ($model) {
            $defaultTranslation = ServiceTranslation::firstOrCreate([
                'language' => config('app.locale'),
                'service_id' => $model->id,
            ]);
            $defaultTranslation->title = $model->title;
            $defaultTranslation->description = $model->description;
            $defaultTranslation->save();
        });

        static::deleted(function ($model) {
            if ($model->translations) {
                $model->translations()->delete();
            }
        });
    }
}
