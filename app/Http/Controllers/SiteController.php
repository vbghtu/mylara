<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductItemResource;
use App\Http\Resources\ProductListResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Support\PaginationMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Response as InertiaResponse;

class SiteController extends Controller
{
    public function categories(string $categorySlug, Request $request, $page = null): InertiaResponse
    {
        $category = Category::where('slug', $categorySlug)->firstOrFail();
        $perPage = config('app.pagination.products_per_page');
        $categories = Category::all();

        $products = $category->products()->paginate($perPage, ['*'], 'page', $page);
        return inertia('Site/Category', [
            'layoutData' => [
                'h1' => $category->name,
                'metaTitle' => PaginationMeta::titleWithPage($category->meta_title, $products),
                'metaDescription' => $category->meta_description,
            ],
            'category' => $category, // неуверен надо ли оно
            'categories' => $categories,
            'products' => [
                'data' => ProductListResource::collection($products),
                'meta' => PaginationMeta::fromRequest($products, $request),
            ],
        ]);
    }


    public function product(string $productSlug, Request $request): InertiaResponse
    {
        $product = Product::where('slug', $productSlug)
            ->with(['images', 'user', 'category','reviews.user'])
            ->firstOrFail();

        $categories = Category::all();

        $hasReviewed = false;
        if ($request->user()) {
            $hasReviewed = Review::where('user_id', $request->user()->id)
                ->where('reviewable_type', $product->getMorphClass()) // ✅ 'product' благодаря morphMap
                ->where('reviewable_id', $product->id)
                ->exists();
        }

        return inertia('Site/Product', [
            'layoutData' => [
                'h1' => $product->title,
                'metaTitle' => $product->meta_title,
                'metaDescription' => $product->meta_description,
            ],
            'categories' => $categories,
            'product' => new ProductItemResource($product),
            'reviews' => $product->reviews()->with('user')->latest()->paginate(10),
            'avg_rating' => $product->avg_rating,
            'reviews_count' => $product->reviews_count,
            'hasReviewed' => $hasReviewed,
        ]);
    }
}
