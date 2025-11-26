<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): InertiaResponse
    {
        $user = Auth::user();
// @todo добавить категории
        $products = $user->products()
            ->with('images')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($product) {
                if ($product->image_path) {
                    $product->main_image_url = Storage::url($product->image_path);
                }

                // Галерея
                $product->gallery_urls = $product->images->map(fn($image) => Storage::url($image->path));

                return $product;
            });

        return Inertia::render('Profile/Products/Index', [
            'user' => $user,
            'layoutData' => [
                'h1' => 'Мои продукты',
            ],
            'products' => $products,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        // Начинаем транзакцию (на случай ошибки при загрузке изображений)
        \DB::transaction(function () use ($request) {
            // Сохраняем главное изображение, если есть
            $mainImagePath = null;
            if ($request->hasFile('main_image')) {
                $mainImagePath = $request->file('main_image')->store('products', 'public');
            }

            // Создаём продукт от имени текущего пользователя
            $product = $request->user()->products()->create([
                'category_id' => $request->integer('category_id'),
                'title' => $request->title,
                'slug' => $request->slug,
                'description' => $request->description,
                'price' => $request->price,
                'is_available' => $request->boolean('is_available'),
                'material' => $request->material,
                'is_customizable' => $request->boolean('is_customizable'),
                'image_path' => $mainImagePath,
            ]);

            // Сохраняем галерею (доп. изображения)
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $image) {
                    $product->images()->create([
                        'path' => $image->store('products/gallery', 'public'),
                    ]);
                }
            }

            return $product;
        });

        return to_route('products.index')->with('success', 'Продукт успешно создан!');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Profile/Products/Create', [
            'layoutData' => [
                'h1' => 'Новый продукт',
            ],
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
