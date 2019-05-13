<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Support\Facades\Auth;

class RabbitsMiddleware
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
            return $next($request);

        } else {
            if (Auth::guest()) {
                return redirect()->guest(route('home'))
                    ->with('expire', 'Halaman yang Anda minta memerlukan otentikasi, silahkan masuk ke akun Anda.');
            }
        }

        return response()->view('errors.403');
    }
}
