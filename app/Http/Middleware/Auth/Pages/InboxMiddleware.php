<?php

namespace App\Http\Middleware\Auth\Pages;

use Closure;
use Illuminate\Support\Facades\Auth;

class InboxMiddleware
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
        $role = Auth::guard('admin')->user();
        if (Auth::guard('admin')->check()) {
            if ($role->isRoot() || $role->isCEO() || $role->isCTO() || $role->isAdmin()) {
                return $next($request);
            }

        } else {
            return $next($request);
        }

        return response()->view('errors.403');
    }
}
