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
    public function index(string $showCaseSlug, Request $request, $page = null): InertiaResponse
    {
        $showCase = Showcase::with(['seller', 'products'])
            ->where('slug', $showCaseSlug)
            ->firstOrFail();

        $sellerResource = new SellerResource($showCase->seller);
        $sellerResource->additional([
            'is_active' => $showCase->is_active,
            'showcase_logo' => $showCase->logo ? asset('storage/'.$showCase->logo) : null,
            'subscription_end' => $showCase->subscription_end?->format('Y-m-d'),
            'contact_email' => $showCase->contact_email,
            'contact_phone' => $showCase->contact_phone,
        ]);

        $hasReviewed = false;
        if ($request->user()) {
            $hasReviewed = Review::where('user_id', $request->user()->id)
                ->where('reviewable_type', $showCase->getMorphClass()) // ✅ Учитывает morphMap
                ->where('reviewable_id', $showCase->id)
                ->exists();
        }
//@todo добавить проверку на активность витрины через Policy (?)!!!
//@todo добавить проверку на активность подписки внутри витрины и если да что то дбавлять
//@todo в зависимости от активности подписки выводить баннер (?)



        return inertia('showCase/Index', [
            'layoutData' => [
                'h1' => $showCase->title,
                'metaTitle' => $showCase->meta_title,
                'metaDescription' => $showCase->meta_description,
            ],
//            'category' => $category, // неуверен надо ли оно
//            'categories' => $categories,
            'products' => [
                'data' => ProductListResource::collection($showCase->products)
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
            'showCase' => $showCase,
        ]);

    }



}
