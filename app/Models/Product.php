<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\App;

class Product extends Model
{
    use HasFactory;

    protected $appends = ['averageRating', 'totalReview', 'isOffer', 'offer'];

    public function getNameTranslatedAttribute()
    {
        if ($this->translation?->name) {
            return $this->translation->name;
        }
        return $this->name;
    }

    public function getShortDescriptionTranslatedAttribute()
    {
        if ($this->translation?->short_description) {
            return $this->translation->short_description;
        }
        return $this->short_description;
    }

    public function getLongDescriptionTranslatedAttribute()
    {
        if ($this->translation?->long_description) {
            return $this->translation->long_description;
        }
        return $this->long_description;
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

    public function getIsOfferAttribute()
    {
        return $this->offer_price ? true : false;
    }

    public function getOfferAttribute()
    {
        $price = $this->price;
        $offer_price = $this->offer_price ? $this->offer_price : 0;
        $offer_amount = $price - $offer_price;
        $percentage = ($offer_amount * 100) / $price;
        $percentage = round($percentage);

        return $this->offer_price ? $percentage : 0;
    }

    public function getAverageRatingAttribute()
    {
        return $this->avgReview()->avg('rating') ?: '0';
    }

    public function getTotalReviewAttribute()
    {
        return $this->avgReview()->count();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function gallery()
    {
        return $this->hasMany(ProductGallery::class);
    }
    public function galleryImages()
    {
        return $this->hasMany(ProductGallery::class, 'product_id');
    }


    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function avgReview()
    {
        return $this->hasMany(ProductReview::class)->where('status', 1);
    }

    public function translation($language = null)
    {
        if ($language == null) {
            $language = getSessionLanguage();
        }

        return $this->hasOne(ProductTranslation::class, 'product_id', 'id')->where('language', '=', $language);
    }

    public function translations()
    {
        return $this->hasMany(ProductTranslation::class);
    }

    public function getProteinItemDecodedAttribute()
    {
        return json_decode($this->protein_item, true) ?? [];
    }

    public function getSoupItemDecodedAttribute()
{
    return $this->soup_item ? json_decode($this->soup_item, true) : [];
}

public function getWrapItemDecodedAttribute()
{
    return $this->wrap_item ? json_decode($this->wrap_item, true) : [];
}

public function getDrinkItemDecodedAttribute()
{
    return $this->drink_item ? json_decode($this->drink_item, true) : [];
}
    

    // public function getProteinItemDecodedAttribute()
    // {
    //     if (!$this->protein_item) {
    //         return [];
    //     }

    //     $decoded = json_decode($this->protein_item, true);

    //     if (json_last_error() !== JSON_ERROR_NONE) {
    //         \Log::error('❌ Invalid protein_item JSON for product ID ' . $this->id);
    //         return [];
    //     }

    //     return $decoded;
    // }
  
    


    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $defaultTranslation = ProductTranslation::firstOrCreate([
                'language' => config('app.locale'),
                'product_id' => $model->id,
            ]);
            $defaultTranslation->name = $model->name;
            $defaultTranslation->short_description = $model->short_description;
            $defaultTranslation->long_description = $model->long_description;
            $defaultTranslation->seo_title = $model->seo_title;
            $defaultTranslation->seo_description = $model->seo_description;
            $defaultTranslation->save();
        });

        static::updated(function ($model) {
            $defaultTranslation = ProductTranslation::firstOrCreate([
                'language' => config('app.locale'),
                'product_id' => $model->id,
            ]);
            $defaultTranslation->name = $model->name;
            $defaultTranslation->short_description = $model->short_description;
            $defaultTranslation->long_description = $model->long_description;
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
