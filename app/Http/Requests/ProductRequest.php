<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $productId = $this->route('product');

        return [
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'main_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'gallery' => ['nullable', 'array', 'max:5'],
            'gallery.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'removed_gallery_ids' => ['nullable', 'array'],
            'removed_gallery_ids.*' => ['exists:product_images,id'],
            'slug' => [
                'required',
                'string',
                'max:50',
                'regex:/^[a-zA-Z0-9_-]+$/', // только буквы, цифры, дефисы и подчёркивания
                Rule::unique('products', 'slug')->ignore($productId),
            ],
            'is_customizable' => ['required', 'boolean'],
            'is_available' => ['required', 'boolean'],
            'description' => ['required', 'string'],
            'material' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0', 'max:999999.99']
        ];
    }
}
