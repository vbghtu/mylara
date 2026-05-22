<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Review;
use App\Models\Showcase;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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

    public function storeForShowcase(Request $request, string $slug)
    {
        $type = Cache::remember("route:slug:{$slug}", 3600, fn() => $this->resolveType($slug));

        if ($type === 'showcase') {
            $showcase = Showcase::where('slug', $slug)->firstOrFail();

            // 🔹 Авторизация (как у товара)
//            $this->authorize('create', [Review::class, $showcase]);

            $validated = $request->validate([
                'rating'  => 'required|integer|min:1|max:5',
                'comment' => 'nullable|string|max:2000',
            ]);
            try {
            $request->user()->reviews()->create([
                'reviewable_type' => $showcase->getMorphClass(),
                'reviewable_id'   => $showcase->id,
                'rating'          => $validated['rating'],
                'comment'         => $validated['comment'],
                'status'          => 'approved',
            ]);

            // 🔹 Сброс кэша
            Cache::forget("showcase:rating:{$showcase->id}");
            Cache::forget("showcase:reviews:{$showcase->id}");

            return back()->with('success', 'Спасибо за отзыв автору/витрине!');
            } catch (UniqueConstraintViolationException $e) {
                // 🔹 Обработка дубликата (если политика не сработала)
                return back()->withErrors(['review' => 'Вы уже оставляли отзыв этому автору.']);
            }
        }

        abort(404);
    }
}
