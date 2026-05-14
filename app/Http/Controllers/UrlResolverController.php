<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\showcase;
use Illuminate\Http\Request;

class UrlResolverController extends Controller
{
    public function resolve(Request $request, string $slug, int $page = 1)
    {
        $type =  $this->resolveType($slug);

        if ($type === 'category') {
            return app(SiteController::class)->categories($slug, $request, $page);
        }

        if ($type === 'showcase') {
            return app(ShowcaseController::class)->index( $slug, $request, $page);
        }

        abort(404, 'Страница не найдена');
    }

    private function resolveType(string $slug): ?string
    {
        if (Category::where('slug', $slug)->exists()) return 'category';
        if (Showcase::where('slug', $slug)->exists()) return 'showcase';
        return null;
    }
}
