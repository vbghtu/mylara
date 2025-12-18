<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class CategoryController extends Controller
{
    public function index(Request $request, $page = null): InertiaResponse
    {
        $user = Auth::user();
        $perPage = config('app.pagination.category_per_page');
        $categories = Category::paginate($perPage, ['*'], 'page', $page);

        $basePath = preg_replace('#/page/\d+$#', '', $request->url());

        return Inertia::render('AdminArea/Category/Index', [
            'user' => $user,
            'layoutData' => [
                'h1' => 'Категории',
            ],
            'categories' => [
                'data' => $categories,
                'meta' => [
                    'current_page' => $categories->currentPage(),
                    'last_page' => $categories->lastPage(),
                    'per_page' => $categories->perPage(),
                    'total' => $categories->total(),
                    'from' => $categories->firstItem(),
                    'to' => $categories->lastItem(),
                    'path' => $basePath,
                ],
            ],
        ]);
    }

    public function destroy(Category $category)
    {
        if ($category->products()->exists()) {
            return back()->with('error', 'Невозможно удалить категорию: в ней есть товары.');
        }

        $category->delete();

        return back()->with('success', 'Категория удалена');
    }

    public function edit(Category $category)
    {
    }
}
