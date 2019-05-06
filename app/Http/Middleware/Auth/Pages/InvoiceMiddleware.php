<?php

namespace App\Http\Middleware\Auth\Pages;

use App\Models\Pemesanan;
use Closure;
use Illuminate\Support\Facades\Auth;

class InvoiceMiddleware
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
            if (Auth::check()) {
                $check = Pemesanan::where('id', decrypt($request->route('id')))
                    ->where('user_id', Auth::id())->firstOrFail();
                if ($check != null) {
                    return $next($request);
                }
            }
        }
        return response()->view('errors.403');
    }
}
