<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Counter extends Model
{
    use HasFactory;

    public function getTitleTranslatedAttribute()
    {
        if ($this->translation?->title) {
            return $this->translation->title;
        }
        return $this->title;
    }

    public function translation($language = null)
    {
        if ($language == null) {
            $language = getSessionLanguage();
        }

        return $this->hasOne(CounterTranslation::class, 'counter_id', 'id')->where('language', '=', $language);
    }

    public function translations()
    {
        return $this->hasMany(CounterTranslation::class);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $defaultTranslation = CounterTranslation::firstOrCreate([
                'language' => config('app.locale'),
                'counter_id' => $model->id,
            ]);
            $defaultTranslation->title = $model->title;
            $defaultTranslation->save();
        });

        static::updated(function ($model) {
            $defaultTranslation = CounterTranslation::firstOrCreate([
                'language' => config('app.locale'),
                'counter_id' => $model->id,
            ]);
            $defaultTranslation->title = $model->title;
            $defaultTranslation->save();
        });

        static::deleted(function ($model) {
            if ($model->translations) {
                $model->translations()->delete();
            }
        });
    }
}
