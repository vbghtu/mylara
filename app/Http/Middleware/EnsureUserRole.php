<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Проверяем, авторизован ли пользователь
        if (!$request->user()) {
            return redirect()->route('login'); // или abort(403)
        }
//        dd($request->user()->role->value);
        // Если переданы допустимые роли — проверяем
        if (!empty($roles) && !in_array($request->user()->role->value, $roles)) {
            abort(403, 'Доступ запрещён');
        }

        return $next($request);
    }
}
