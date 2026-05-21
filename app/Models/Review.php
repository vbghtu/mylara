<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'reviewable_id',
        'reviewable_type',
        'rating',
        'comment',
        'status',
        'is_verified_purchase',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_verified_purchase' => 'boolean',
        'created_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Полиморфная связь: к чему относится отзыв
    public function reviewable(): MorphTo
    {
        return $this->morphTo();
    }

    // Scope: только одобренные отзывы (самый частый запрос)
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // Scope: только отзывы к определённому типу (product/showcase)
    public function scopeForType(Builder $query, string $type): Builder
    {
        return $query->where('reviewable_type', $type);
    }

    // Helper: является ли отзыв к товару
    public function isProductReview(): bool
    {
        return $this->reviewable_type === Product::class;
    }

    // Helper: является ли отзыв к витрине
    public function isShowcaseReview(): bool
    {
        return $this->reviewable_type === Showcase::class;
    }
}
