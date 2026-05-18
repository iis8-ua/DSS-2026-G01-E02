<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->tipo_usuario !== 'ADMIN') {
            abort(403);
        }
        return $next($request);
    }
}
