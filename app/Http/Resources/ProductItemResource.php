<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductItemResource extends JsonResource
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
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,

            'gallery' => $this->whenLoaded('images', function () {
                $galleryItems = [];
                if ($this->image_path) {
                    $galleryItems[] = [
                        'id' => 'main', // или можно использовать отрицательный ID, например -1
                        'full_url' => Storage::url($this->image_path),
                        'alt' => 'Основное изображение',
                    ];
                }

                foreach ($this->images as $image) {
                    $galleryItems[] = [
                        'id' => $image->id,
                        'full_url' => Storage::url($image->path),
                        'alt' => $image->alt ?? '',
                    ];
                }

                return $galleryItems;
            }),

            'author' => $this->whenLoaded('user', function () {
                return [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'avatar' => $this->user->profile_foto,
                    // Не отдавай email, password и т.д.!
                ];
            }),
            'category' => $this->whenLoaded('category', function () {
                return [
                    'id' => $this->category->id,
                    'name' => $this->category->name,
                    'slug' => $this->category->slug,
                ];
            })
        ];
    }
}
