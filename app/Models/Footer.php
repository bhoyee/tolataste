<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Footer extends Model
{
    use HasFactory;

    public function getAboutUsTranslatedAttribute()
    {
        if ($this->translation?->about_us) {
            return $this->translation->about_us;
        }
        return $this->about_us;
    }

    public function getAddressTranslatedAttribute()
    {
        if ($this->translation?->address) {
            return $this->translation->address;
        }
        return $this->address;
    }

    public function getCopyrightTranslatedAttribute()
    {
        if ($this->translation?->copyright) {
            return $this->translation->copyright;
        }
        return $this->copyright;
    }

    public function translation($language = null)
    {
        if ($language == null) {
            $language = getSessionLanguage();
        }

        return $this->hasOne(FooterTranslation::class, 'footer_id', 'id')->where('language', '=', $language);
    }

    public function translations()
    {
        return $this->hasMany(FooterTranslation::class);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $defaultTranslation = FooterTranslation::firstOrCreate([
                'language' => config('app.locale'),
                'footer_id' => $model->id,
            ]);
            $defaultTranslation->about_us = $model->about_us;
            $defaultTranslation->address = $model->address;
            $defaultTranslation->copyright = $model->copyright;
            $defaultTranslation->save();
        });

        static::updated(function ($model) {
            $defaultTranslation = FooterTranslation::firstOrCreate([
                'language' => config('app.locale'),
                'footer_id' => $model->id,
            ]);
            $defaultTranslation->about_us = $model->about_us;
            $defaultTranslation->address = $model->address;
            $defaultTranslation->copyright = $model->copyright;
            $defaultTranslation->save();
        });

        static::deleted(function ($model) {
            if ($model->translations) {
                $model->translations()->delete();
            }
        });
    }
}
