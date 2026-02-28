<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class AboutUs extends Model
{
    use HasFactory;

    public function getAboutUsTranslatedAttribute()
    {
        if ($this->translation?->about_us) {
            return $this->translation->about_us;
        }
        return $this->about_us;
    }

    public function getVideoTitleTranslatedAttribute()
    {
        if ($this->translation?->video_title) {
            return $this->translation->video_title;
        }
        return $this->video_title;
    }

    public function getAboutUsShortTitleTranslatedAttribute()
    {
        if ($this->translation?->about_us_short_title) {
            return $this->translation->about_us_short_title;
        }
        return $this->about_us_short_title;
    }

    public function getAboutUsLongTitleTranslatedAttribute()
    {
        if ($this->translation?->about_us_long_title) {
            return $this->translation->about_us_long_title;
        }
        return $this->about_us_long_title;
    }

    public function getWhyChooseUsShortTitleTranslatedAttribute()
    {
        if ($this->translation?->why_choose_us_short_title) {
            return $this->translation->why_choose_us_short_title;
        }
        return $this->why_choose_us_short_title;
    }

    public function getWhyChooseUsLongTitleTranslatedAttribute()
    {
        if ($this->translation?->why_choose_us_long_title) {
            return $this->translation->why_choose_us_long_title;
        }
        return $this->why_choose_us_long_title;
    }

    public function getWhyChooseUsDescriptionTranslatedAttribute()
    {
        if ($this->translation?->why_choose_us_description) {
            return $this->translation->why_choose_us_description;
        }
        return $this->why_choose_us_description;
    }

    public function getTitleOneTranslatedAttribute()
    {
        if ($this->translation?->title_one) {
            return $this->translation->title_one;
        }
        return $this->title_one;
    }

    public function getTitleTwoTranslatedAttribute()
    {
        if ($this->translation?->title_two) {
            return $this->translation->title_two;
        }
        return $this->title_two;
    }

    public function getTitleThreeTranslatedAttribute()
    {
        if ($this->translation?->title_three) {
            return $this->translation->title_three;
        }
        return $this->title_three;
    }

    public function getTitleFourTranslatedAttribute()
    {
        if ($this->translation?->title_four) {
            return $this->translation->title_four;
        }
        return $this->title_four;
    }

    public function translation($language = null)
    {
        if (!$language) {
            $language = getSessionLanguage();
        }

        return $this->hasOne(AboutUsTranslation::class, 'about_us_id', 'id')->where('language', '=', $language);
    }

    public function translations()
    {
        return $this->hasMany(AboutUsTranslation::class);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $defaultTranslation = AboutUsTranslation::firstOrCreate([
                'language' => config('app.locale'),
                'about_us_id' => $model->id,
            ]);

            $defaultTranslation->about_us = $model->about_us;
            $defaultTranslation->about_us_short_title = $model->about_us_short_title;
            $defaultTranslation->about_us_long_title = $model->about_us_long_title;
            $defaultTranslation->why_choose_us_short_title = $model->why_choose_us_short_title;
            $defaultTranslation->why_choose_us_long_title = $model->why_choose_us_long_title;
            $defaultTranslation->why_choose_us_description = $model->why_choose_us_description;
            $defaultTranslation->video_title = $model->video_title;
            $defaultTranslation->title_one = $model->title_one;
            $defaultTranslation->title_two = $model->title_two;
            $defaultTranslation->title_three = $model->title_three;
            $defaultTranslation->title_four = $model->title_four;

            $defaultTranslation->save();
        });

        static::updated(function ($model) {
            $defaultTranslation = AboutUsTranslation::firstOrCreate([
                'language' => config('app.locale'),
                'about_us_id' => $model->id,
            ]);
            $defaultTranslation->about_us = $model->about_us;
            $defaultTranslation->about_us_short_title = $model->about_us_short_title;
            $defaultTranslation->about_us_long_title = $model->about_us_long_title;
            $defaultTranslation->why_choose_us_short_title = $model->why_choose_us_short_title;
            $defaultTranslation->why_choose_us_long_title = $model->why_choose_us_long_title;
            $defaultTranslation->why_choose_us_description = $model->why_choose_us_description;
            $defaultTranslation->video_title = $model->video_title;
            $defaultTranslation->title_one = $model->title_one;
            $defaultTranslation->title_two = $model->title_two;
            $defaultTranslation->title_three = $model->title_three;
            $defaultTranslation->title_four = $model->title_four;
            $defaultTranslation->save();
        });

        static::deleted(function ($model) {
            if ($model->translations) {
                $model->translations()->delete();
            }
        });
    }
}
