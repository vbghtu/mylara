<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MainController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $categories = Category::all();
        $products = Product::all();

        return Inertia::render('Site/Index', [
            'user' => $user,
            'layoutData' => [
                'h1' => 'Главная',
            ],
            'categories' => $categories,
            'products' => $products,
        ]);
//        return view('welcome', compact('users'));
    }
}
