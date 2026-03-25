<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class showcase extends Model
{
    protected $fillable = [
        'id',
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
}
