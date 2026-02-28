<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Category extends Model
{
    use HasFactory;

    public function getNameTranslatedAttribute()
    {
        if ($this->translation?->name) {
            return $this->translation->name;
        }
        return $this->name;
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function menu_products()
    {
        return $this->hasMany(Product::class);
    }

    public function translation($language = null)
    {
        if ($language == null) {
            $language = getSessionLanguage();
        }

        return $this->hasOne(ProductCategoryTranslation::class, 'category_id', 'id')->where('language', '=', $language);
    }

    public function translations()
    {
        return $this->hasMany(ProductCategoryTranslation::class);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $defaultTranslation = ProductCategoryTranslation::firstOrCreate([
                'language' => config('app.locale'),
                'category_id' => $model->id,
            ]);
            $defaultTranslation->name = $model->name;
            $defaultTranslation->save();
        });

        static::updated(function ($model) {
            $defaultTranslation = ProductCategoryTranslation::firstOrCreate([
                'language' => config('app.locale'),
                'category_id' => $model->id,
            ]);
            $defaultTranslation->name = $model->name;
            $defaultTranslation->save();
        });

        static::deleted(function ($model) {
            if ($model->translations) {
                $model->translations()->delete();
            }
        });
    }
}
