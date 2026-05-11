<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsVendedor
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->vendedor) {
            abort(403, 'Acesso restrito a vendedores.');
        }

        return $next($request);
    }
}
