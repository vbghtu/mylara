<?php

namespace App\Observers;

use App\Models\Review;
use Illuminate\Support\Facades\Cache;
class ReviewObserver
{
    /**
     * Handle the Review "created" event.
     */
    public function created(Review $review): void
    {
        $this->clearCache($review);
    }

    /**
     * Handle the Review "updated" event.
     */
    public function updated(Review $review): void
    {
        // Сбрасываем кэш только если изменился статус или рейтинг
        if ($review->isDirty('status') || $review->isDirty('rating')) {
            $this->clearCache($review);
        }
    }

    /**
     * Handle the Review "deleted" event.
     */
    public function deleted(Review $review): void
    {
        $this->clearCache($review);
    }

    /**
     * Handle the Review "restored" event.
     */
    public function restored(Review $review): void
    {
        //
    }

    /**
     * Handle the Review "force deleted" event.
     */
    public function forceDeleted(Review $review): void
    {
        //
    }

    private function clearCache(Review $review): void
    {
        if ($review->isProductReview()) {
            // 1. Сброс кэша товара
            Cache::forget("product:rating:{$review->reviewable_id}");
            Cache::forget("product:reviews:{$review->reviewable_id}");

            // 2. Сброс кэша продавца (т.к. рейтинг товара влияет на общий)
            $product = \App\Models\Product::find($review->reviewable_id);
            if ($product) {
                Cache::forget("showcase:rating:{$product->user_id}");
                Cache::forget("showcase:reviews:{$product->user_id}");
            }
        } else {
            // 3. Отзыв к витрине
            Cache::forget("showcase:rating:{$review->reviewable_id}");
            Cache::forget("showcase:reviews:{$review->reviewable_id}");
        }
    }
}
