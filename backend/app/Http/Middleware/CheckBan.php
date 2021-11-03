<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckBan
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            if (auth()->user()->is_ban == 1) {
                auth()->logout();
                return response()->json(['error' => 'Access is denied'],Response::HTTP_FORBIDDEN);
            }
        }
        return $next($request);
    }
}
