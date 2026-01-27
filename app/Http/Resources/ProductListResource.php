<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'is_available' => $this->is_available,
            'material' => $this->material,
            'is_customizable' => $this->is_customizable,

            // Основное изображение
            'main_image_url' => $this->image_path
                ? Storage::url($this->image_path)
                : null,

            // Галерея — только если связь загружена
//            'gallery_urls' => $this->whenLoaded('product_images', function () {
//                return $this->images->map(fn($image) => Storage::url($image->path));
//            }),

            // Категория — если нужна
//            'category' => $this->whenLoaded('category', fn() => [
//                'id' => $this->category->id,
//                'name' => $this->category->name,
//                'slug' => $this->category->slug,
//            ]),

            // Другие поля по желанию
//            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
