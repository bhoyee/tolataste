<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Faq extends Model
{
    use HasFactory;

    public function getQuestionTranslatedAttribute()
    {
        if ($this->translation?->question) {
            return $this->translation->question;
        }
        return $this->question;
    }

    public function getAnswerTranslatedAttribute()
    {
        if ($this->translation?->answer) {
            return $this->translation->answer;
        }
        return $this->answer;
    }

    public function translation($language = null)
    {
        if ($language == null) {
            $language = getSessionLanguage();
        }

        return $this->hasOne(FaqTranslation::class, 'faq_id', 'id')->where('language', '=', $language);
    }

    public function translations()
    {
        return $this->hasMany(FaqTranslation::class);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $defaultTranslation = FaqTranslation::firstOrCreate([
                'language' => config('app.locale'),
                'faq_id' => $model->id,
            ]);

            $defaultTranslation->question = $model->question;
            $defaultTranslation->answer = $model->answer;
            $defaultTranslation->save();
        });

        static::updated(function ($model) {
            $defaultTranslation = FaqTranslation::firstOrCreate([
                'language' => config('app.locale'),
                'faq_id' => $model->id,
            ]);

            $defaultTranslation->question = $model->question;
            $defaultTranslation->answer = $model->answer;
            $defaultTranslation->save();
        });

        static::deleted(function ($model) {
            if ($model->translations) {
                $model->translations()->delete();
            }
        });
    }
}
