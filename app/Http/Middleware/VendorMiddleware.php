<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if (!$user || !$user->isVendor()) {
            abort(403, 'Unauthorized - Vendors only');
        }
        return $next($request);
    }
}
