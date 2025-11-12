<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
    
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
