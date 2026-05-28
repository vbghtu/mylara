<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductListResource;
use App\Models\Category;
use App\Models\Product;
use App\Support\PaginationMeta;
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

        $categories = Category::all();
        $products = Product::paginate($perPage, ['*'], 'page', $page);

        return Inertia::render('Site/Index', [
            'user' => $user,
            'layoutData' => [
                'h1' => 'Главная',
                'metaTitle' => PaginationMeta::titleWithPage('Главная — Мой магазин', $products),
                'metaDescription' => 'Лучшие товары по низким ценам',
            ],
            'categories' => $categories,
            'products' => [
                'data' => ProductListResource::collection($products),
                'meta' => PaginationMeta::fromRequest($products, $request),
            ],
        ]);
    }
}
