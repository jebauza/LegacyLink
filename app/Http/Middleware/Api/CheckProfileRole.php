<?php
namespace App\Http\Middleware\API;


use Closure;
use Illuminate\Http\Request;

class CheckProfileRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $profile_id = $request->route('profile_id');

        $profile = auth()->user()->deceased_profiles()
                                ->wherePivot('role',$role)
                                ->where('deceased_profiles.id', $profile_id)
                                ->first();

        if (!$profile) {
            return response()->json([
                'success' => false,
                'message' => __('You do not have permissions for the requested resources'),
            ], 403);
        }

        session(['profileWeb' => $profile]);
        return $next($request);
    }
}
