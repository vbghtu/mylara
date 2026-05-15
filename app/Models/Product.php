<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'description',
        'price',
        'is_available',
        'material',
        'is_customizable',
        'image_path',
        'meta_title',
        'meta_description',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class); //@todo мультикатегорйиность
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

// средний рейтинг товара (с кэшированием)
    public function getAvgRatingAttribute(): float
    {
        return Cache::remember("product:rating:{$this->id}", 3600, function () {
            $avg = $this->reviews()->approved()->avg('rating');
            return round($avg ?? 0, 2);
        });
    }

//  количество отзывов товара
    public function getReviewsCountAttribute(): int
    {
        return Cache::remember("product:reviews:{$this->id}", 3600, function () {
            return $this->reviews()->approved()->count();
        });
    }
}
