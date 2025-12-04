<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class RedirectPageOne
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->path();

        if (Str::endsWith($path, '/page/1')) {
            $newPath = Str::beforeLast($path, '/page/1');
            $newPath = $newPath === '' ? '/' : $newPath;

            $queryString = $request->getQueryString();
            $location = $newPath . ($queryString ? '?' . $queryString : '');

            return redirect($location, 301);
        }

        return $next($request);
    }
}
