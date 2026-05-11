<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureVendedor
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->vendedor) {
            abort(403, 'Ops! Não foi Possível Acessar essa Pagina');
        }

        return $next($request);
    }
}
