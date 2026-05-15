<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Showcase extends Model
{
    protected $fillable = [
        'seller_id',
        'slug',
        'title',
        'logo',
        'banner',
        'is_active',
        'subscription_start',
        'subscription_end',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'contact_email',
        'contact_phone'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'user_id', 'seller_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    //   общий рейтинг продавца
//    public function getAvgRatingAttribute(): float
//    {
//        return Cache::remember("showcase:rating:{$this->id}", 3600, function () {
//            // 1. Отзывы напрямую к витрине
//            $showcaseAvg = $this->reviews()->approved()->avg('rating');
//            $showcaseCount = $this->reviews()->approved()->count();
//
//            // 2. Отзывы ко всем товарам продавца
//            $productStats = $this->products()
//                ->join('reviews', 'products.id', '=', 'reviews.reviewable_id')
//                ->where('reviews.reviewable_type', Product::class)
//                ->where('reviews.status', 'approved')
//                ->selectRaw('AVG(reviews.rating) as avg, COUNT(*) as count')
//                ->first();
//
//            $productAvg = $productStats->avg ?? 0;
//            $productCount = $productStats->count ?? 0;
//
//            // 3. Взвешенное среднее
//            $total = $showcaseCount + $productCount;
//            if ($total === 0) return 0.0;
//
//            $weighted = (($showcaseAvg * $showcaseCount) + ($productAvg * $productCount)) / $total;
//            return round($weighted, 2);
//        });
//    }

// общее количество отзывов продавца
//    public function getReviewsCountAttribute(): int
//    {
//        return Cache::remember("showcase:reviews:{$this->id}", 3600, function () {
//            // Отзывы к витрине + отзывы ко всем товарам
//            $showcaseCount = $this->reviews()->approved()->count();
//            $productCount = $this->products()
//                ->join('reviews', 'products.id', '=', 'reviews.reviewable_id')
//                ->where('reviews.reviewable_type', Product::class)
//                ->where('reviews.status', 'approved')
//                ->count();
//
//            return $showcaseCount + $productCount;
//        });
//    }
}
