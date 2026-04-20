<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EsUsuario
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            abort(403);
        }
        return $next($request);
    }
}
