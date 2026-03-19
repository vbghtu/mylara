<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductItemResource;
use App\Http\Resources\ProductListResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\showcase;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class ShowcaseController extends Controller
{
    public function index(string $showCaseSlug, Request $request, $page = null): InertiaResponse
    {
        $showCase = Showcase::where('slug', $showCaseSlug)->firstOrFail();
        dd($showCase);
//        return Inertia::render('');

    }



}
