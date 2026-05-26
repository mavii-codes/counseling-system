<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

/**
 * In local dev, generate URLs from the current request host (localhost vs 127.0.0.1).
 * Prevents 419 CSRF errors when APP_URL does not match the browser address bar.
 */
class UseRequestRootUrl
{
    public function handle(Request $request, Closure $next): Response
    {
        if (app()->environment('local') && $request->getHttpHost()) {
            URL::forceRootUrl($request->getSchemeAndHttpHost());
        }

        return $next($request);
    }
}
