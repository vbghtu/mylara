<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductItemResource;
use App\Http\Resources\ProductListResource;
use App\Models\showcase;
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

//        dd(ProductListResource::collection($showCase->products));
        return inertia('showCase/Index', [
            'layoutData' => [
                'h1' => $showCase->title,
                'metaTitle' => $showCase->meta_title,
                'metaDescription' => $showCase->meta_description,
            ],
//            'category' => $category, // неуверен надо ли оно
//            'categories' => $categories,
            'products' => [
                'data' => ProductListResource::collection($showCase->products),
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
        ]);

    }



}
