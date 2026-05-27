<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Support\PaginationMeta;
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

        return Inertia::render('AdminArea/Category/Index', [
            'user' => $user,
            'layoutData' => [
                'h1' => 'Категории',
            ],
            'categories' => [
                'data' => $categories,
                'meta' => PaginationMeta::fromRequest($categories, $request),
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
        $categories = Category::all(['id', 'name']);

        return Inertia::render('AdminArea/Category/Edit', [
            'layoutData' => [
                'h1' => 'Редактировать категорию "' . $category->name . '"',
            ],
            'category' => $category,
            'categories' => $categories,

        ]);
    }

    public function store(CategoryRequest $request, Category $category)
    {
        $category->create($request->validated());

        return back()->with('success', 'Категория создана!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all(['id', 'name']);

        return Inertia::render('AdminArea/Category/Create', [
            'layoutData' => [
                'h1' => 'Новая Категория',
            ],
            'categories' => $categories,
        ]);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return back()->with('success', 'Категория обновлёна!');
    }
}
