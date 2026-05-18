<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EsGestor
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !in_array(auth()->user()->tipo_usuario, ['GESTOR_ESPACIOS', 'ADMIN'])) {
            abort(403);
        }
        return $next($request);
    }
}
