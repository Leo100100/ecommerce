<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DisableCsrfForWebhook
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('asaas/webhook')) {
        return $next($request);
    }

    return app(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class)
        ->handle($request, $next);
    }
}
