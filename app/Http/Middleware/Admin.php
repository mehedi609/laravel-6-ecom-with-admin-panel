<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Brian2694\Toastr\Facades\Toastr;
use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
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
        if (!Auth::guard('admin')->check()) {
            Toastr::warning('Please Login as admin', 'Access Denied');
            return redirect(route('admin.login'));
        }
        return $next($request);
    }
}
