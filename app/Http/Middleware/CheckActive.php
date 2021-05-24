<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $authUser = $request->user();

        if (!$authUser || !$authUser->is_active || $authUser->deleted_at) {
            auth()->logout();
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
