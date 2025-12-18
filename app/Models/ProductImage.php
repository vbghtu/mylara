<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'path',
    ];

    // Связь: изображение принадлежит продукту
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Пример: аксессор для полного URL (если нужно)
    public function getFullUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }
}
