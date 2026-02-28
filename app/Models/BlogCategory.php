<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class BlogCategory extends Model
{
    use HasFactory;

    protected $appends = ['totalBlog'];

    public function getNameTranslatedAttribute()
    {
        if ($this->translation?->name) {
            return $this->translation->name;
        }
        return $this->name;
    }

    public function getTotalBlogAttribute()
    {
        return $this->blogs()->count();
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class)->where('status', 1);
    }

    public function translation($language = null)
    {
        if ($language == null) {
            $language = getSessionLanguage();
        }

        return $this->hasOne(CategoryTranslation::class, 'category_id', 'id')->where('language', '=', $language);
    }

    public function translations()
    {
        return $this->hasMany(CategoryTranslation::class, 'category_id');
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $defaultTranslation = CategoryTranslation::firstOrCreate([
                'language' => config('app.locale'),
                'category_id' => $model->id,
            ]);
            $defaultTranslation->name = $model->name;
            $defaultTranslation->save();
        });

        static::updated(function ($model) {
            $defaultTranslation = CategoryTranslation::firstOrCreate([
                'language' => config('app.locale'),
                'category_id' => $model->id,
            ]);
            $defaultTranslation->name = $model->name;
            $defaultTranslation->save();
        });

        static::deleted(function ($model) {
            if ($model?->translations) {
                $model->translations()->delete();
            }
        });
    }
}
