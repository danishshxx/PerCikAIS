<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class DetectMobile
{
    /**
     * Detect mobile devices via User-Agent and share $isMobile to all views.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userAgent = $request->header('User-Agent', '');
        $isMobile = (bool) preg_match('/mobile|android|iphone|ipod|blackberry|iemobile|opera mini/i', $userAgent);

        View::share('isMobile', $isMobile);

        return $next($request);
    }
}
