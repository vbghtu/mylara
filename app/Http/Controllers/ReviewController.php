<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function storeForProduct(Request $request, string $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        // 🔹 Проверка прав (дубликат, владелец и т.д.)
//        $this->authorize('create', [Review::class, $product]);
//dd($this->authorize('create', [Review::class, $product]));
        $validated = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        // 🔹 Создание отзыва
        try {
            $request->user()->reviews()->create([
                'reviewable_type' => $product->getMorphClass(), // ✅ Вернёт 'product' вместо 'App\Models\Product'
                'reviewable_id'   => $product->id,
                'rating'          => $validated['rating'],
                'comment'         => $validated['comment'],
                'status'          => 'approved',
            ]);

            return back()->with('success', 'Спасибо! Ваш отзыв опубликован.');
        } catch (UniqueConstraintViolationException $e) {
            // 🔹 Ловим дубликат и отдаём понятное сообщение
            return back()->withErrors(['review' => 'Вы уже оставляли отзыв к этому товару.']);
        }

        // 🔹 Observer автоматически сбросит кэш рейтинга
//        return back()->with('success', 'Спасибо! Ваш отзыв опубликован.');
    }
}
