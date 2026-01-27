<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductListResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class MainController extends Controller
{
    public function index(Request $request, $page = null): InertiaResponse
    {
        $user = Auth::user();
        $perPage = config('app.pagination.products_per_page');
        $basePath = preg_replace('#/page/\d+$#', '', $request->url());

        $categories = Category::all();
        $products = Product::paginate($perPage, ['*'], 'page', $page);


        return Inertia::render('Site/Index', [
            'user' => $user,
            'layoutData' => [
                'h1' => 'Главная',
            ],
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
}
