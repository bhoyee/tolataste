<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Setting extends Model
{
    use HasFactory;

    public function getAppNameTranslatedAttribute()
    {
        if ($this->translation?->app_name) {
            return $this->translation->app_name;
        }
        return $this->app_name;
    }

    public function getCurrencyNameTranslatedAttribute()
    {
        if ($this->translation?->currency_name) {
            return $this->translation->currency_name;
        }
        return $this->currency_name;
    }

    public function getAppTitleTranslatedAttribute()
    {
        if ($this->translation?->app_title) {
            return $this->translation->app_title;
        }
        return $this->app_title;
    }

    public function getAppDescriptionTranslatedAttribute()
    {
        if ($this->translation?->app_description) {
            return $this->translation->app_description;
        }
        return $this->app_description;
    }

    public function translation($language = null)
    {
        if ($language == null) {
            $language = getSessionLanguage();
        }

        return $this->hasOne(SettingsTranslation::class, 'setting_id', 'id')->where('language', '=', $language);
    }

    public function translations()
    {
        return $this->hasMany(SettingsTranslation::class);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $defaultTranslation = SettingsTranslation::firstOrCreate([
                'language' => config('app.locale'),
                'setting_id' => $model->id,
            ]);

            $defaultTranslation->app_name = $model->app_name;
            $defaultTranslation->currency_name = $model->currency_name;
            $defaultTranslation->app_title = $model->app_title;
            $defaultTranslation->app_description = $model->app_description;
            $defaultTranslation->save();
        });

        static::updated(function ($model) {
            $defaultTranslation = SettingsTranslation::firstOrCreate([
                'language' => config('app.locale'),
                'setting_id' => $model->id,
            ]);
            $defaultTranslation->app_name = $model->app_name;
            $defaultTranslation->currency_name = $model->currency_name;
            $defaultTranslation->app_title = $model->app_title;
            $defaultTranslation->app_description = $model->app_description;
            $defaultTranslation->save();
        });

        static::deleted(function ($model) {
            if ($model->translations) {
                $model->translations()->delete();
            }
        });
    }
}
