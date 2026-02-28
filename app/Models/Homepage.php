<?php

namespace App\Models;
require_once app_path('Helpers/languageDynamic.php');

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Homepage extends Model
{
    use HasFactory;

    public function getTodaySpecialShortTitleTranslatedAttribute()
    {
        if ($this->translation?->today_special_short_title) {
            return $this->translation->today_special_short_title;
        }
        return $this->today_special_short_title;
    }

    public function getTodaySpecialLongTitleTranslatedAttribute()
    {
        if ($this->translation?->today_special_long_title) {
            return $this->translation->today_special_long_title;
        }
        return $this->today_special_long_title;
    }

    public function getTodaySpecialDescriptionTranslatedAttribute()
    {
        if ($this->translation?->today_special_description) {
            return $this->translation->today_special_description;
        }
        return $this->today_special_description;
    }

    public function getMenuShortTitleTranslatedAttribute()
    {
        if ($this->translation?->menu_short_title) {
            return $this->translation->menu_short_title;
        }
        return $this->menu_short_title;
    }

    public function getMenuLongTitleTranslatedAttribute()
    {
        if ($this->translation?->menu_long_title) {
            return $this->translation->menu_long_title;
        }
        return $this->menu_long_title;
    }

    public function getMenuDescriptionTranslatedAttribute()
    {
        if ($this->translation?->menu_description) {
            return $this->translation->menu_description;
        }
        return $this->menu_description;
    }

    public function getChefShortTitleTranslatedAttribute()
    {
        if ($this->translation?->chef_short_title) {
            return $this->translation->chef_short_title;
        }
        return $this->chef_short_title;
    }

    public function getChefLongTitleTranslatedAttribute()
    {
        if ($this->translation?->chef_long_title) {
            return $this->translation->chef_long_title;
        }
        return $this->chef_long_title;
    }

    public function getChefDescriptionTranslatedAttribute()
    {
        if ($this->translation?->chef_description) {
            return $this->translation->chef_description;
        }
        return $this->chef_description;
    }

    public function getTestimonialShortTitleTranslatedAttribute()
    {
        if ($this->translation?->testimonial_short_title) {
            return $this->translation->testimonial_short_title;
        }
        return $this->testimonial_short_title;
    }

    public function getTestimonialLongTitleTranslatedAttribute()
    {
        if ($this->translation?->testimonial_long_title) {
            return $this->translation->testimonial_long_title;
        }
        return $this->testimonial_long_title;
    }

    public function getTestimonialDescriptionTranslatedAttribute()
    {
        if ($this->translation?->testimonial_description) {
            return $this->translation->testimonial_description;
        }
        return $this->testimonial_description;
    }

    public function getBlogShortTitleTranslatedAttribute()
    {
        if ($this->translation?->blog_short_title) {
            return $this->translation->blog_short_title;
        }
        return $this->blog_short_title;
    }

    public function getBlogLongTitleTranslatedAttribute()
    {
        if ($this->translation?->blog_long_title) {
            return $this->translation->blog_long_title;
        }
        return $this->blog_long_title;
    }

    public function getBlogDescriptionTranslatedAttribute()
    {
        if ($this->translation?->blog_description) {
            return $this->translation->blog_description;
        }
        return $this->blog_description;
    }

    public function translation($language = null)
    {
        if ($language == null) {
            $language = getSessionLanguage();
        }

        return $this->hasOne(HomepageTranslation::class, 'homepage_id', 'id')->where('language', '=', $language);
    }

    public function translations()
    {
        return $this->hasMany(HomepageTranslation::class);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $defaultTranslation = HomepageTranslation::firstOrCreate([
                'language' => config('app.locale'),
                'homepage_id' => $model->id,
            ]);
            $defaultTranslation->today_special_short_title = $model->today_special_short_title;
            $defaultTranslation->today_special_long_title = $model->today_special_long_title;
            $defaultTranslation->today_special_description = $model->today_special_description;
            $defaultTranslation->menu_short_title = $model->menu_short_title;
            $defaultTranslation->menu_long_title = $model->menu_long_title;
            $defaultTranslation->menu_description = $model->menu_description;
            $defaultTranslation->chef_short_title = $model->chef_short_title;
            $defaultTranslation->chef_long_title = $model->chef_long_title;
            $defaultTranslation->chef_description = $model->chef_description;
            $defaultTranslation->testimonial_short_title = $model->testimonial_short_title;
            $defaultTranslation->testimonial_long_title = $model->testimonial_long_title;
            $defaultTranslation->testimonial_description = $model->testimonial_description;
            $defaultTranslation->blog_short_title = $model->blog_short_title;
            $defaultTranslation->blog_long_title = $model->blog_long_title;
            $defaultTranslation->blog_description = $model->blog_description;
            $defaultTranslation->save();
        });

        static::updated(function ($model) {
            $defaultTranslation = HomepageTranslation::firstOrCreate([
                'language' => config('app.locale'),
                'homepage_id' => $model->id,
            ]);
            $defaultTranslation->today_special_short_title = $model->today_special_short_title;
            $defaultTranslation->today_special_long_title = $model->today_special_long_title;
            $defaultTranslation->today_special_description = $model->today_special_description;
            $defaultTranslation->menu_short_title = $model->menu_short_title;
            $defaultTranslation->menu_long_title = $model->menu_long_title;
            $defaultTranslation->menu_description = $model->menu_description;
            $defaultTranslation->chef_short_title = $model->chef_short_title;
            $defaultTranslation->chef_long_title = $model->chef_long_title;
            $defaultTranslation->chef_description = $model->chef_description;
            $defaultTranslation->testimonial_short_title = $model->testimonial_short_title;
            $defaultTranslation->testimonial_long_title = $model->testimonial_long_title;
            $defaultTranslation->testimonial_description = $model->testimonial_description;
            $defaultTranslation->blog_short_title = $model->blog_short_title;
            $defaultTranslation->blog_long_title = $model->blog_long_title;
            $defaultTranslation->blog_description = $model->blog_description;
            $defaultTranslation->save();
        });

        static::deleted(function ($model) {
            if (@$model->translations) {
                $model->translations()->delete();
            }
        });
    }
}
