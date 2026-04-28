<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckGettingStarted
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && !auth()->user()->hasCompletedGettingStarted()) {
            // Don't redirect if already on getting started pages
            if (!$request->is('getting-started*')) {
                return redirect()->route('getting-started');
            }
        }

        return $next($request);
    }
}
