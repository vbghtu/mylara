<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductItemResource;
use App\Http\Resources\ProductListResource;
use App\Http\Resources\SellerResource;
use App\Models\Review;
use App\Models\Showcase;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class ShowcaseController extends Controller
{
    public function index(string $showcaseSlug, Request $request, $page = null): InertiaResponse
    {
        $showcase = Showcase::with(['seller', 'products'])
            ->where('slug', $showcaseSlug)
            ->firstOrFail();

        $sellerResource = new SellerResource($showcase->seller);
        $sellerResource->additional([
            'is_active' => $showcase->is_active,
            'showcase_logo' => $showcase->logo ? asset('storage/'.$showcase->logo) : null,
            'subscription_end' => $showcase->subscription_end?->format('Y-m-d'),
            'contact_email' => $showcase->contact_email,
            'contact_phone' => $showcase->contact_phone,
        ]);

        $hasReviewed = false;
        if ($request->user()) {
            $hasReviewed = Review::where('user_id', $request->user()->id)
                ->where('reviewable_type', $showcase->getMorphClass()) // ✅ Учитывает morphMap
                ->where('reviewable_id', $showcase->id)
                ->exists();
        }
        return inertia('showcase/Index', [
            'layoutData' => [
                'h1' => $showcase->title,
                'metaTitle' => $showcase->meta_title,
                'metaDescription' => $showcase->meta_description,
            ],
//            'category' => $category, // неуверен надо ли оно
//            'categories' => $categories,
            'products' => [
                'data' => ProductListResource::collection($showcase->products)
//                'meta' => [
//                    'current_page' => $products->currentPage(),
//                    'last_page' => $products->lastPage(),
//                    'per_page' => $products->perPage(),
//                    'total' => $products->total(),
//                    'from' => $products->firstItem(),
//                    'to' => $products->lastItem(),
//                    'path' => $basePath, // ← критически важно!
//                ],
            ],
            'seller' => array_merge(
                $sellerResource->toArray(request()),
                $sellerResource->additional
            ),
            'hasReviewed' => $hasReviewed,
            'showcase' => $showcase,
        ]);

    }



}
