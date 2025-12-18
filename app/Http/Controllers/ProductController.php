<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductImage;
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
    public function index(Request $request, $page = null): InertiaResponse
    {
        $user = Auth::user();
        $perPage = config('app.pagination.products_per_page');


// @todo добавить категории
        $products = $user->products()
            ->with('images')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page) // сколько элементов на странице (например, 15)
            ->through(function ($product) {
                if ($product->image_path) {
                    $product->main_image_url = Storage::url($product->image_path);
                }
                $product->gallery_urls = $product->images->map(fn($image) => Storage::url($image->path));
                return $product;
            });

        $basePath = preg_replace('#/page/\d+$#', '', $request->url());


        return Inertia::render('Profile/Products/Index', [
            'user' => $user,
            'layoutData' => [
                'h1' => 'Мои продукты',
            ],
            'products' => [
                'data' => $products,
                'meta' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'per_page' => $products->perPage(),
                    'total' => $products->total(),
                    'from' => $products->firstItem(),
                    'to' => $products->lastItem(),
                    'path' => $basePath, // ← критически важно!
                ],
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
        $user = Auth::user();
        $product = $user->products()->where('id', $id)->with('images')->firstOrFail();


//        if ($product->image_path) {
//            $product->main_image = [
//                'id' => 'main_image',
//                'full_url' => Storage::url($product->image_path),
//                'alt' => '',
//            ];
//        } else {
//            $product->main_image = null;
//        }
        $product->main_image = Storage::url($product->image_path);

        $product->gallery = $product->images->map(fn($image) => [
            'id' => $image->id,
            'full_url' => Storage::url($image->path),
            'alt' => $image->alt ?? '',
        ]);

        return Inertia::render('Profile/Products/Edit', [
            'layoutData' => [
                'h1' => 'Редактировать товар "' . $product->title . '"',
            ],
            'product' => $product,

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();
        //@todo доделать обработку ошибок  на типы файлов в первую очередь
        if ($request->has('removed_gallery_ids')) {
            $imagesToDelete = ProductImage::whereIn('id', $request->removed_gallery_ids)->get();

            foreach ($imagesToDelete as $image) {
                // Удаляем файл с диска
                if (Storage::disk('public')->exists($image->path)) {
                    Storage::disk('public')->delete($image->path);
                }
                $image->delete();
            }
        }

        // Загрузка новых
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $product->images()->create([
                    'path' => $image->store('products/gallery', 'public'),
                ]);
            }
        }

        // Замена главного изображения
        if ($request->hasFile('main_image')) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }

            $data['image_path'] = $request->file('main_image')->store('products', 'public');
        }

        $product->update($data);

//        session()->flash('success', 'Товар обновлён!');
        session()->flash('success', 'Товар обновлён!');
//        dd(session()->all());
        return redirect()->back()->with('success', 'Товар обновлён!');
//        return redirect()->route('products.edit')->with('success', 'Чарт создан!');
//        return redirect()->route('products.edit', ['product' => $product->id])->with('success', 'Чарт создан!');
//        return to_route('products.edit', ['product' => $product->id])->with('success', 'Продукт успешно создан!');
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
