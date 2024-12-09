<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle($request, Closure $next)
{
    if (Auth::check() && Auth::user()->isAdmin()) {
        return $next($request);
    }
    return redirect('/')->with('error', 'Accès non autorisé.');
}
}

