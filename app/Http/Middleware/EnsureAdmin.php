<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth('web')->check()) {
            return redirect()->route('login');
        }

        abort_unless(auth('web')->user()->isAdmin(), 403);

        return $next($request);
    }
}
