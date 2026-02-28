<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Blog extends Model
{
    use HasFactory;

    protected $appends = ['totalComment'];

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

    public function getSeoTitleTranslatedAttribute()
    {
        if ($this->translation?->seo_title) {
            return $this->translation->seo_title;
        }
        return $this->seo_title;
    }

    public function getSeoDescriptionTranslatedAttribute()
    {
        if ($this->translation?->seo_description) {
            return $this->translation->seo_description;
        }
        return $this->seo_description;
    }

    public function getTotalCommentAttribute()
    {
        return $this->activeComments()->count();
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function comments()
    {
        return $this->hasMany(BlogComment::class);
    }

    public function activeComments()
    {
        return $this->hasMany(BlogComment::class)->where('status', 1);
    }

    public function translation($language = null)
    {
        if ($language == null) {
            $language = getSessionLanguage();
        }

        return $this->hasOne(BlogTranslation::class, 'blog_id', 'id')->where('language', '=', $language);
    }

    public function translations()
    {
        return $this->hasMany(BlogTranslation::class);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $defaultTranslation = BlogTranslation::firstOrCreate([
                'language' => config('app.locale'),
                'blog_id' => $model->id,
            ]);
            $defaultTranslation->title = $model->title;
            $defaultTranslation->description = $model->description;
            $defaultTranslation->seo_title = $model->seo_title;
            $defaultTranslation->seo_description = $model->seo_description;
            $defaultTranslation->save();
        });

        static::updated(function ($model) {
            $defaultTranslation = BlogTranslation::firstOrCreate([
                'language' => config('app.locale'),
                'blog_id' => $model->id,
            ]);
            $defaultTranslation->title = $model->title;
            $defaultTranslation->description = $model->description;
            $defaultTranslation->seo_title = $model->seo_title;
            $defaultTranslation->seo_description = $model->seo_description;
            $defaultTranslation->save();
        });

        static::deleted(function ($model) {
            if ($model->translations) {
                $model->translations()->delete();
            }
        });
    }
}
