<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChangeMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->must_change_password) {
            if (
                ! $request->routeIs('password.change.*') &&
                ! $request->routeIs('logout')
            ) {
                return redirect()->route('password.change.show');
            }
        }

        return $next($request);
    }
}
