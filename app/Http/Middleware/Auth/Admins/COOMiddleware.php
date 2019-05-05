<?php

namespace App\Http\Middleware\Auth\Admins;

use Closure;
use Illuminate\Support\Facades\Auth;

class COOMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('admin')->check()) {
            if (Auth::guard('admin')->user()->isCOO() || Auth::guard('admin')->user()->isRoot()) {
                return $next($request);
            }

        } else {
            return $next($request);
        }

        return response()->view('errors.403');
    }
}
