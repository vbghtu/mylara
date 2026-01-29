<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductItemResource;
use App\Http\Resources\ProductListResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Response as InertiaResponse;

class SiteController extends Controller
{
    public function categories(string $categorySlug, Request $request, $page = null): InertiaResponse
    {
        $category = Category::where('slug', $categorySlug)->firstOrFail();
        $perPage = config('app.pagination.products_per_page');
        $basePath = preg_replace('#/page/\d+$#', '', $request->url());
        $categories = Category::all();

        $products = $category->products()->paginate($perPage, ['*'], 'page', $page);

        return inertia('Site/Category', [
            'layoutData' => [
                'h1' => $category->name,
                'metaTitle' => $category->meta_title,
                'metaDescription' => $category->meta_description,
            ],
            'category' => $category, // неуверен надо ли оно
            'categories' => $categories,
            'products' => [
                'data' => ProductListResource::collection($products),
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


    public function product(string $productSlug): InertiaResponse
    {
        $product = Product::where('slug', $productSlug)->with(['images', 'user'])->firstOrFail();
        $categories = Category::all();


        return inertia('Site/Product', [
            'layoutData' => [
                'h1' => $product->title,
                'metaTitle' => $product->title . ' купить заказать',
                'metaDescription' => $product->title . ' купить заказать описание',
            ],
            'categories' => $categories,
            'product' => new ProductItemResource($product) //@todo сделать ресурс
        ]);
    }
}
